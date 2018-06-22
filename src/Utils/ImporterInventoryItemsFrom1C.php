<?php

namespace App\Utils;

use App\Entity\Storage_1C\InventoryItem1C;
use App\Entity\Storage_1C\InventoryItemCategory;
use App\Entity\Storage_1C\Rooms1C;
use App\Entity\View\InvItem1C;
use App\Repository\Storage_1C\MolRepository;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;

class ImporterInventoryItemsFrom1C
{
    private const IN_CHARSET = 'WINDOWS-1251';
    private const OUT_CHARSET = 'UTF-8';
    private const HEADER = 'ИнвентарнаяЕдиница';
    private const EMPTY = '';
    private const INPUT_DATA_SIZE = 9;
    private const GEOLOCATION_DATA_SIZE = 4;
    private const EQUAL_DATES = '000';

    private $em;
    private $logger;

    /**
     * ImporterInventoryItemsFrom1C constructor.
     * @param EntityManagerInterface $em
     * @param LoggerInterface $inventoryLogger
     */
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

            // Prepare input data
            $inventoryData = $this->prepareInputData($line);

            // Find InventoryItem1C
            $inventoryItem1C = $this->em->getRepository(InventoryItem1C::class)->findOneBy(['inventoryNumber' => $inventoryData['inventoryNumber']]);

            // Create or update inventoryItem1C
            if (is_null($inventoryItem1C)) {
                $this->createInventoryItem1C($inventoryData);
            } else {
                $this->updateInventoryItem1C($inventoryItem1C, $inventoryData);
            }
            $this->em->clear();

        } catch (\Throwable $e) {
            $this->em->clear();
            $this->logger->error($e->getMessage());
        }
    }

    /**
     * @param InventoryItem1C $inventoryItem1C
     * @param array $inventoryData
     */
    private function updateInventoryItem1C(InventoryItem1C $inventoryItem1C, array $inventoryData)
    {
        // Get View of InventoryItem1C
        $invItem1CView = $this->em->getRepository(InvItem1C::class)->findOneBy(['invItem_inventoryNumber' => $inventoryData['inventoryNumber']]);

        // Update Rooms1C
        if ($inventoryData['roomsCode'] != $invItem1CView->getRooms1CRoomsCode()
            || $inventoryData['roomsTitle'] != $invItem1CView->getRooms1CTitle()
            || $inventoryData['regionTitle'] != $invItem1CView->getRegion1CTitle()
            || $inventoryData['cityTitle'] != $invItem1CView->getCity1CTitle()
            || $inventoryData['addressTitle'] != $invItem1CView->getRooms1CAddress()
        ) {
            $rooms = $this->em->getRepository(Rooms1C::class)->getInstance(
                $inventoryData['roomsCode'],
                $inventoryData['roomsTitle'],
                $inventoryData['regionTitle'],
                $inventoryData['cityTitle'],
                $inventoryData['addressTitle']
            );
            $inventoryItem1C->setRooms1C($rooms);
        }

        // Update Mol
        $molTabNumber = ($invItem1CView->getMolTabNumber() == MolRepository::EMPTY_TAB_NUMBER) ? self::EMPTY : $invItem1CView->getMolTabNumber();
        if ($inventoryData['molTabNumber'] != $molTabNumber
            || $inventoryData['mol'] != $invItem1CView->getMolFio()
        ) {
            $mol = $this->em->getRepository('Storage_1C:Mol')->getByTabNumberAndFio(
                $inventoryData['molTabNumber'],
                $inventoryData['mol']
            );
            $inventoryItem1C->setMol($mol);
        }

        // Update Nomenclature1C
        if ($inventoryData['typeOfNomenclature'] != $invItem1CView->getNomenclatureTypeType()
            || $inventoryData['nomenclature'] != $invItem1CView->getNomenclature1CTitle()
        ) {
            $nomenclatureType = $this->em->getRepository('Storage_1C:NomenclatureType')->getByType($inventoryData['typeOfNomenclature']);
            $nomenclature = $this->em->getRepository('Storage_1C:Nomenclature1C')->getByTitleAndType(
                $inventoryData['nomenclature'],
                $nomenclatureType
            );
            $inventoryItem1C->setNomenclature($nomenclature);
        }

        // Update Inventory Number
        if ($inventoryData['inventoryNumber'] != $invItem1CView->getInvItemInventoryNumber()) {
            $inventoryItem1C->setInventoryNumber($inventoryData['inventoryNumber']);
        }

        // Update Serial Number
        if ($inventoryData['serialNumber'] != $invItem1CView->getInvItemSerialNumber()) {
            $inventoryItem1C->setSerialNumber($inventoryData['serialNumber']);
        }

        // Update Date of Registration
        if (!empty($inventoryData['dateOfRegistration'])
            && self::EQUAL_DATES !== date_diff($inventoryData['dateOfRegistration'], $invItem1CView->getInvItemDateOfRegistration())->format("%y%m%d")
        ) {
            $inventoryItem1C->setDateOfRegistration($inventoryData['dateOfRegistration']);
        }

        // Update InventoryItem1C
        $inventoryItem1C->setLastUpdate(new \DateTime('now', new \DateTimeZone('UTC')));
        $this->em->flush();
    }


    /**
     * @param array $inventoryData
     */
    private function createInventoryItem1C(array $inventoryData)
    {
        // Define Rooms1C
        $rooms = $this->em->getRepository(Rooms1C::class)->getInstance(
            $inventoryData['roomsCode'],
            $inventoryData['roomsTitle'],
            $inventoryData['regionTitle'],
            $inventoryData['cityTitle'],
            $inventoryData['addressTitle']
        );

        // Define Mol
        $mol = $this->em->getRepository('Storage_1C:Mol')->getByTabNumberAndFio(
            $inventoryData['molTabNumber'],
            $inventoryData['mol']
        );
        $mol->addOffice1C($rooms);

        // Define NomenclatureType
        $nomenclatureType = $this->em->getRepository('Storage_1C:NomenclatureType')->getByType($inventoryData['typeOfNomenclature']);

        // Define Nomenclature1C
        $nomenclature = $this->em->getRepository('Storage_1C:Nomenclature1C')->getByTitleAndType(
            $inventoryData['nomenclature'],
            $nomenclatureType
        );

        // Define InventoryItemCategory
        $category = $this->em->getRepository(InventoryItemCategory::class)->getEmptyInstance();

        // Create InventoryItem1C
        $inventoryItem1C = new InventoryItem1C();
        $inventoryItem1C->setInventoryNumber($inventoryData['inventoryNumber']);
        $inventoryItem1C->setSerialNumber($inventoryData['serialNumber']);
        if (!empty($inventoryData['dateOfRegistration'])) {
            $inventoryItem1C->setDateOfRegistration($inventoryData['dateOfRegistration']);
        }
        $inventoryItem1C->setLastUpdate(new \DateTime('now', new \DateTimeZone('UTC')));
        $inventoryItem1C->setCategory($category);
        $inventoryItem1C->setRooms1C($rooms);
        $inventoryItem1C->setMol($mol);
        $inventoryItem1C->setNomenclature($nomenclature);
        $this->em->persist($inventoryItem1C);
        $this->em->flush();
    }


    /**
     * @param string $line
     * @return array
     * @throws \Exception
     */
    private function prepareInputData(string $line): array
    {
        // Select item1C's data from a line
        $line = trim(iconv(self::IN_CHARSET, self::OUT_CHARSET, $line));
        $data = array_map(
            function ($item) { return trim($item); },
            str_getcsv($line, ';')
        );

        // Prepare input data
        if (self::INPUT_DATA_SIZE != count($data)) {
            throw new \Exception('Not valid data: '. $line);
        }
        $item['inventoryNumber'] = empty($data[0]) ? self::EMPTY : $data[0];
        if (empty($item['inventoryNumber']) || $item['inventoryNumber'] == self::HEADER) {
            throw new \Exception('Does not have an inventory number: '. $line);
        }
        $item['serialNumber'] = empty($data[1]) ? self::EMPTY : $data[1];
        $item['nomenclature'] = empty($data[2]) ? self::EMPTY : $data[2];
        $item['dateOfRegistration'] = empty($data[3]) ? self::EMPTY : new \DateTime($data[3], new \DateTimeZone('UTC'));
        $item['typeOfNomenclature'] = empty($data[4]) ? self::EMPTY : $data[4];
        $item['mol'] = empty($data[5]) ? self::EMPTY : $data[5];
        $item['roomsCode'] = empty($data[6]) ? self::EMPTY : $data[6];
        $item['rooms'] = empty($data[7]) ? self::EMPTY : $data[7];
        $item['molTabNumber'] = empty($data[8]) ? self::EMPTY : $data[8];
        $item['roomsTitle'] = self::EMPTY;
        $item['regionTitle'] = self::EMPTY;
        $item['cityTitle'] = self::EMPTY;
        $item['addressTitle'] = self::EMPTY;
        if (self::EMPTY != $item['rooms']) {
            $geolocationData = array_map(
                function ($item) { return trim($item); },
                explode(',', $item['rooms'])
            );
            if (self::GEOLOCATION_DATA_SIZE == count($geolocationData)) {
                $item['regionTitle'] = $geolocationData[0];
                $item['cityTitle'] = mb_ereg_replace('г\.', '', $geolocationData[1]);
                $item['addressTitle'] = $geolocationData[2]. ', '. trim(mb_ereg_replace('\(.*\)', '', $geolocationData[3]));

                $matches = [];
                mb_ereg('\(.*\)', $geolocationData[3], $matches);
                if (!empty($matches)) {
                    $item['roomsTitle'] = $matches[0];
                    $item['roomsTitle'] = trim(mb_ereg_replace('\(|\)', '', $item['roomsTitle']));
                }
            }
        }
        return $item;
    }
}
