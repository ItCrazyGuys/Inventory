<?php

namespace App;

use App\Entity\Storage_1C\Appliance1C;
use App\Entity\Storage_1C\InventoryItem1C;
use App\Entity\Storage_1C\Module1C;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;

class InventoryImporter
{
    private const IN_CHARSET = 'WINDOWS-1251';
    private const OUT_CHARSET = 'UTF-8';
    private const HEADER = 'ИнвентарнаяЕдиница';
    private const EMPTY = '';

    private $em;
    private $logger;



    public function __construct(EntityManagerInterface $em, LoggerInterface $inventoryLogger)
    {
        $this->em = $em;
        $this->logger = $inventoryLogger;
    }


    /**
     * @param string $line
     */
    public function importFromCsv(string $line)
    {
        try {
            // Select item1C's data from a line
            $line = trim(iconv(self::IN_CHARSET, self::OUT_CHARSET, $line));
            $data = array_map(function ($item) {
                return trim($item);
            }, str_getcsv($line, ';'));

            // Process input
            $item['inventoryNumber'] = $data[0] == '' ? null : $data[0];
            if (is_null($item['inventoryNumber']) || $item['inventoryNumber'] == self::HEADER) {
                // unprocess a line if it does not have an inventory number
                return;
            }
            $item['serialNumber'] = empty($data[1]) ? self::EMPTY : $data[1];
            $item['nomenclature'] = empty($data[2]) ? self::EMPTY : $data[2];
            $item['dateOfRegistration'] = empty($data[3]) ? self::EMPTY : new \DateTime($data[3], new \DateTimeZone('UTC'));
            $item['typeOfNomenclature'] = empty($data[4]) ? self::EMPTY : $data[4];
            $item['mol'] = empty($data[5]) ? self::EMPTY : $data[5];
            $item['roomsCode'] = empty($data[6]) ? self::EMPTY : $data[6];
            $item['rooms'] = empty($data[7]) ? self::EMPTY : $data[7];
            $item['molTabNumber'] = empty($data[8]) ? self::EMPTY : $data[8];

            // Define Rooms1C
            $rooms1C = null;
            if ($item['roomsCode'] != self::EMPTY && $item['rooms'] != self::EMPTY) {
                // process input
                $geolocationData = array_map(
                    function ($item) { return trim($item); },
                    explode(',', $item['rooms'])
                );
                $regionTitle = !empty($geolocationData[0]) ? $geolocationData[0] : self::EMPTY;
                $cityTitle = !empty($geolocationData[1]) ? preg_replace('~г\.~', '', $geolocationData[1]) : self::EMPTY;
                $addressTitle = !empty($geolocationData[2]) ? implode(', ', array_splice($geolocationData, 2)) : self::EMPTY;

                // get Region1C by input
                $region = $this->em->getRepository('Storage_1C:Region1C')->getByTitle($regionTitle);

                // get City1C by input
                $city = $this->em->getRepository('Storage_1C:City1C')->getByTitleAndRegion($cityTitle, $region);

                // get RoomsType by $addressTitle
                $roomsType = $this->em->getRepository('Storage_1C:RoomsType')->getByAddress($addressTitle);

                // define Rooms1C by input (roomsCode)
                $rooms1C = $this->em->getRepository('Storage_1C:Rooms1C')->getByRoomsCodeAndCityAndAddressAndType($item['roomsCode'], $city, $addressTitle, $roomsType);

                // define VoiceOffice by input (city, address)
                if (is_null($rooms1C->getVoiceOffice())) {
                    // find voiceCity by title
                    $cities = $this->em->getRepository('Geolocation:City')->findByTitle($cityTitle);
                    foreach ($cities as $city) {
                        foreach ($city->getAddresses() as $address) {
                            $streetPattern = '(проспект|просп\.|пр-кт им.в.и.|пр-кт|пр-т|улица|ул\.|ул|\S )';

                            // select the address part
                            $addressTitle = mb_strtolower(preg_replace('~,.+~', '', $addressTitle));
                            $addressTitle = trim(preg_replace('~^'.$streetPattern.'~u', '', $addressTitle));
                            $addressTitle = trim(preg_replace('~^\d+~u', '', $addressTitle));
                            // select the street
                            $street = preg_replace('~ .+~', '', $addressTitle);
                            // select the buildingNumber
                            preg_match('~[\d]+~', $addressTitle, $buildingNumber);

                            $isEqualStreet = (1 == preg_match('~'.$street.'~', mb_strtolower($address->getAddress())));
                            $isEqualBuildingNumber = false;
                            if (!empty($buildingNumber[0])) {
                                $isEqualBuildingNumber = (1 == preg_match('~'.$buildingNumber[0].'~', $address->getAddress()));
                            }

                            // define VoiceOffice
                            if ($isEqualStreet && $isEqualBuildingNumber) {
                                $voiceOffice = $address->getOffice();
                                $rooms1C->setVoiceOffice($voiceOffice);
                                break(2);
                            }
                        }
                    }
                }

            } else {
                $rooms1C = $this->em->getRepository('Storage_1C:Rooms1C')->getEmptyInstance();
            }

            // Define Mol
            $mol = $this->em->getRepository('Storage_1C:Mol')->getByTabNumberAndFio($item['molTabNumber'], $item['mol']);
            $mol->addOffice1C($rooms1C);

            // Define NomenclatureType
            $nomenclatureType = $this->em->getRepository('Storage_1C:NomenclatureType')->getByType($item['typeOfNomenclature']);

            // Define Nomenclature1C
            $nomenclature1C = $this->em->getRepository('Storage_1C:Nomenclature1C')->getByTitleAndType($item['nomenclature'], $nomenclatureType);

            // Define InventoryItem1C
            $inventoryItem1C = $this->em->getRepository('Storage_1C:InventoryItem1C')->findOneBy(['inventoryNumber' => $item['inventoryNumber']]);
            if (is_null($inventoryItem1C)) {
                // Create new Appliance1C
                $inventoryItem1C = new InventoryItem1C();
                $this->em->persist($inventoryItem1C);

                $inventoryItem1C->setInventoryNumber($item['inventoryNumber']);
                $inventoryItem1C->setSerialNumber($item['serialNumber']);
                $inventoryItem1C->setNomenclature($nomenclature1C);
                $inventoryItem1C->setRooms1C($rooms1C);
                $inventoryItem1C->setMol($mol);
                if ($item['dateOfRegistration'] != self::EMPTY) {
                    $inventoryItem1C->setDateOfRegistration($item['dateOfRegistration']);
                }
                $inventoryItem1C->setLastUpdate(new \DateTime('now', new \DateTimeZone('UTC')));
            } else {
                // Update exist Appliance1C
                if ($inventoryItem1C->getSerialNumber() != $item['serialNumber']) {
                    $inventoryItem1C->setSerialNumber($item['serialNumber']);
                }
                if ($inventoryItem1C->getNomenclature()->getId() != $nomenclature1C->getId()) {
                    $inventoryItem1C->setNomenclature($nomenclature1C);
                }
                if ($inventoryItem1C->getRooms1C()->getId() != $rooms1C->getId()) {
                    $inventoryItem1C->setRooms1C($rooms1C);
                }
                if ($inventoryItem1C->getMol()->getId() != $mol->getId()) {
                    $inventoryItem1C->setMol($mol);
                }
                if ($item['dateOfRegistration'] != self::EMPTY) {
                    $inventoryItem1C->setDateOfRegistration($item['dateOfRegistration']);
                }
                $inventoryItem1C->setLastUpdate(new \DateTime('now', new \DateTimeZone('UTC')));
            }

            /// Define Appliance1C or Module1C
            $voiceAppliance = null;
            $voiceModule = null;
            $isAppliance = false;
            $isModule = false;

            // Define voiceAppliances or voiceModules by serialNumber for a item1C
            if ($item['serialNumber'] != self::EMPTY) {
                $serialNumber = mb_strtolower($item['serialNumber']);
                // ошибочный серийник (перед серийником стоит символ S или &), получаемый со сканера шрих-кодов.
                $washedSerialNumber = (1 == preg_match('~^(s|&)~', $serialNumber)) ? preg_replace('~^(s|&)~', '', $serialNumber) : null;

                // search for a item1C in the voiceAppliances
                $voiceAppliance = $this->em->getRepository('Equipment:Appliance')->findOneBySerialNumber($serialNumber);
                if (is_null($voiceAppliance) && !is_null($washedSerialNumber)) {
                    $voiceAppliance = $this->em->getRepository('Equipment:Appliance')->findOneBySerialNumber($washedSerialNumber);
                }

                // if voiceAppliance does not found, then search for a item1C in the voiceModules
                if (is_null($voiceAppliance)) {
                    $voiceModule = $this->em->getRepository('Equipment:ModuleItem')->findOneBySerialNumber($serialNumber);
                    if (is_null($voiceModule) && !is_null($washedSerialNumber)) {
                        $voiceModule = $this->em->getRepository('Equipment:ModuleItem')->findOneBySerialNumber($washedSerialNumber);
                    }
                }
            }

            // Define InventoryItemCategory
            if (!is_null($voiceAppliance)) {
                $isAppliance = true;
            } elseif (!is_null($voiceModule)) {
                $isModule = true;
            } else {
                // define a category by word patterns
                $moodulePattern = ['module'];
                foreach ($moodulePattern as $moodulePatter) {
                    if (1 == preg_match('~' . $moodulePatter . '~', mb_strtolower($item['nomenclature']))) {
                        $isModule = true;
                        break;
                    }
                }

                if (!$isModule) {
                    $appliancePatterns = [
                        'catalyst',
                        'маршрутизатор',
                        'коммутатор',
                        'телефон',
                        'шлюз',
                    ];
                    foreach ($appliancePatterns as $appliancePattern) {
                        if (1 == preg_match('~' . $appliancePattern . '~', mb_strtolower($item['nomenclature']))) {
                            $isAppliance = true;
                            break;
                        }
                    }
                }
            }

            // Define Appliance1C or Module1C
            if ($isAppliance) {
                $inventoryItem1C->setCategory($this->em->getRepository('Storage_1C:InventoryItemCategory')->getApplianceCategory());
                $isSetVoiceAppliance = false;

                // find Appliance1C by InventoryItem1C
                $appliance1C = $this->em->getRepository('Storage_1C:Appliance1C')->findOneBy(['inventoryData' => $inventoryItem1C]);
                if (is_null($appliance1C)) {
                    // create new Appliance1C
                    $appliance1C = new Appliance1C();
                    $appliance1C->setInventoryData($inventoryItem1C);
                    if (!is_null($voiceAppliance)) {
                        $isSetVoiceAppliance = true;
                    }
                    $this->em->persist($appliance1C);
                } elseif (is_null($appliance1C->getVoiceAppliance()) && !is_null($voiceAppliance)) {
                    // update Appliance1C
                    $isSetVoiceAppliance = true;
                } elseif (!is_null($appliance1C->getVoiceAppliance()) && !is_null($voiceAppliance) && $appliance1C->getVoiceAppliance()->getId() != $voiceAppliance->getId()) {
                    // update Appliance1C
                    $isSetVoiceAppliance = true;
                } elseif (!is_null($appliance1C->getVoiceAppliance() && is_null($voiceAppliance))) {
                    // update Appliance1C
                    $appliance1C->setVoiceAppliance($voiceAppliance);
                }
                // set voiceAppliance
                if ($isSetVoiceAppliance) {
                    // duplicate check
                    $duplicateAppliance1C = $this->em->getRepository('Storage_1C:Appliance1C')->findOneByVoiceAppliance($voiceAppliance);
                    if (is_null($duplicateAppliance1C)) {
                        // no duplicate
                        $appliance1C->setVoiceAppliance($voiceAppliance);
                    } else {
                        // log duplicate error
                        $message = 'Inventory number ' . $item['inventoryNumber'] . ' (serial ' . $item['serialNumber'] . ') has duplicate ' . $duplicateAppliance1C->getInventoryData()->getInventoryNumber() . ' (serial ' . $duplicateAppliance1C->getInventoryData()->getSerialNumber() . ')';
                        $this->logger->error($message);
                    }
                }

            } elseif ($isModule) {
                $inventoryItem1C->setCategory($this->em->getRepository('Storage_1C:InventoryItemCategory')->getModuleCategory());
                $isSetVoiceModule = false;

                // find Module1C by InventoryItem1C
                $module1C = $this->em->getRepository('Storage_1C:Module1C')->findOneBy(['inventoryData' => $inventoryItem1C]);
                if (is_null($module1C)) {
                    // create new Module1C
                    $module1C = new Module1C();
                    $module1C->setInventoryData($inventoryItem1C);
                    if (!is_null($voiceModule)) {
                        $isSetVoiceModule = true;
                    }
                    $this->em->persist($module1C);
                } elseif (is_null($module1C->getVoiceModule()) && !is_null($voiceModule)) {
                    // update Module1C
                    $isSetVoiceModule = true;
                } elseif (!is_null($module1C->getVoiceModule()) && !is_null($voiceModule) && $module1C->getVoiceModule()->getId() != $voiceModule->getId()) {
                    // update Module1C
                    $isSetVoiceModule = true;
                } elseif (!is_null($module1C->getVoiceModule() && is_null($voiceModule))) {
                    // update Module1C
                    $module1C->setVoiceModule($voiceModule);
                }
                // set voiceModule
                if ($isSetVoiceModule) {
                    // duplicate check
                    $duplicateModule1C = $this->em->getRepository('Storage_1C:Module1C')->findOneByVoiceModule($voiceModule);
                    if (is_null($duplicateModule1C)) {
                        // no duplicate
                        $module1C->setVoiceModule($voiceModule);
                    } else {
                        // log duplicate error
                        $message = 'Inventory number ' . $item['inventoryNumber'] . ' (serial ' . $item['serialNumber'] . ') has duplicate ' . $duplicateModule1C->getInventoryData()->getInventoryNumber() . ' (serial ' . $duplicateModule1C->getInventoryData()->getSerialNumber() . ')';
                        $this->logger->error($message);
                    }
                }

            } else {
                // set 'AutomaticallyUndefine' for inventoryItem1C
                $inventoryItem1C->setCategory($this->em->getRepository('Storage_1C:InventoryItemCategory')->getAutomaticallyUndefineCategory());
            }

            $this->em->flush();
            $this->em->clear();

        } catch (\Throwable $e) {
            $this->em->clear();
            $this->logger->error($e->getMessage());
        }
    }
}
