<?php

namespace App\Service\Import1C\Impl;

use App\Entity\Storage_1C\InventoryItem1C;
use App\Entity\Storage_1C\Rooms1C;
use App\Entity\View\InvItem1C;
use App\Repository\Storage_1C\MolRepository;
use App\Provider\Resource1cProvider;
use App\Service\Import1C\InventoryItems1cImporterService;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;

class InventoryItems1cFromCsvImporterServiceImpl implements InventoryItems1cImporterService
{
    private const IN_CHARSET = 'WINDOWS-1251';
    private const OUT_CHARSET = 'UTF-8';
    private const HEADER = 'ИнвентарнаяЕдиница';
    private const EMPTY = '';
    private const INPUT_DATA_SIZE = 11;
    private const EQUAL_DATES = '000';

    private $resource1cProvider;
    private $em;
    private $logger;

    /**
     * ImporterServiceInventoryItemsFrom1Ccsv constructor.
     * @param Resource1cProvider $resource1cProvider
     * @param EntityManagerInterface $em
     * @param LoggerInterface $logger
     */
    public function __construct(Resource1cProvider $resource1cProvider, EntityManagerInterface $em, LoggerInterface $logger)
    {
        $this->resource1cProvider = $resource1cProvider;
        $this->em = $em;
        $this->logger = $logger;
    }


    public function import()
    {
        $importedCsvResource = null;
        $resource = null;

        try {
            // Get CSV Resource
            $importedCsvResource = $this->resource1cProvider->getResource();

            // Import CSV Resource
            $resource = fopen($importedCsvResource, 'r');
            while (!feof($resource)) {
                if (!$this->em->isOpen()) {
                    throw new \Exception('Entity manager close');
                }

                $line = fgets($resource);
                if (false !== $line) {
                    $this->importFromCsv($line);
                }
            }
            fclose($resource);

            // Unlink CSV Resource
            unlink($importedCsvResource);

        } catch (\Throwable $e) {
            if (!is_null($resource)) {
                fclose($resource);
            }
            if (!is_null($importedCsvResource)) {
                unlink($importedCsvResource);
            }
        }
    }

    /**
     * @param string $line
     */
    private function importFromCsv(string $line)
    {
        try {
            // Prepare input data
            $inventoryData = $this->prepareInputData($line);

            // Find InventoryItems1C by inventory number and nomenclature type (InventoryItems1C is unique within nomenclatureType)
            $inventoryItems1C = $this->em->getRepository('Storage_1C:InventoryItem1C')->findOneByInventoryNumberAndNomenclatureType($inventoryData['inventoryNumber'], $inventoryData['typeOfNomenclature']);

            // Create or update inventoryItem1C
            if (!is_null($inventoryItems1C)) {
                $this->updateInventoryItem1C($inventoryItems1C, $inventoryData);
            } else {
                $this->createInventoryItem1C($inventoryData);
            }
            $this->em->clear();
        } catch (\Throwable $e) {
            $this->em->clear();
            $this->logger->error($e->getMessage());
        }
    }

    /**
     * @param InventoryItem1C $inventoryItem1C
     * @param array $data
     * @throws \Doctrine\ORM\ORMException|\Exception
     */
    private function updateInventoryItem1C(InventoryItem1C $inventoryItem1C, array $data)
    {
        // Get View of InventoryItem1C
        $invItem1CView = $this->em->getRepository(InvItem1C::class)->findOneBy(['invItem_id' => $inventoryItem1C->getId()]);

        // Update Rooms1C
        if ($invItem1CView->getRooms1CRoomsCode() != $data['roomsCode'] || $invItem1CView->getRooms1CTitle() != $data['roomsTitle'] || $invItem1CView->getRooms1CAddress() != $data['roomsAddress'])
        {
            $rooms = $this->em->getRepository(Rooms1C::class)->getInstance($data['roomsCode'], $data['roomsTitle'], $data['roomsAddress']);
            $inventoryItem1C->setRooms1C($rooms);
        }

        // Update Mol
        $molTabNumber = ($invItem1CView->getMolTabNumber() == MolRepository::EMPTY_TAB_NUMBER) ? self::EMPTY : $invItem1CView->getMolTabNumber();
        if ($molTabNumber != $data['molTabNumber'] || $invItem1CView->getMolFio() != $data['mol'])
        {
            $mol = $this->em->getRepository('Storage_1C:Mol')->getByTabNumberAndFio($data['molTabNumber'], $data['mol']);
            $inventoryItem1C->setMol($mol);
        }

        // Update Nomenclature1C
        if ($invItem1CView->getNomenclature1CTitle() != $data['nomenclature'] || $invItem1CView->getNomenclatureTypeType() != $data['typeOfNomenclature'])
        {
            $nomenclatureType = $this->em->getRepository('Storage_1C:NomenclatureType')->getByType($data['typeOfNomenclature']);
            $nomenclature = $this->em->getRepository('Storage_1C:Nomenclature1C')->getByTitleAndType($data['nomenclature'], $nomenclatureType);
            $inventoryItem1C->setNomenclature($nomenclature);
        }

        // Update Serial Number
        if ($invItem1CView->getInvItemSerialNumber() != $data['serialNumber'])
        {
            $inventoryItem1C->setSerialNumber($data['serialNumber']);
        }

        // Update Date of Registration
        if (!empty($data['dateOfRegistration']) && self::EQUAL_DATES !== date_diff($data['dateOfRegistration'], $invItem1CView->getInvItemDateOfRegistration())->format("%y%m%d"))
        {
            $inventoryItem1C->setDateOfRegistration($data['dateOfRegistration']);
        }

        // Update InventoryItem1C
        $inventoryItem1C->setLastUpdate(new \DateTime('now', new \DateTimeZone('UTC')));
        $this->em->flush();
    }


    /**
     * @param array $inventoryData
     * @throws \Exception
     */
    private function createInventoryItem1C(array $inventoryData)
    {
        // Define Rooms1C
        $rooms = $this->em->getRepository(Rooms1C::class)->getInstance($inventoryData['roomsCode'], $inventoryData['roomsTitle'], $inventoryData['roomsAddress']);

        // Define Mol
        $mol = $this->em->getRepository('Storage_1C:Mol')->getByTabNumberAndFio($inventoryData['molTabNumber'], $inventoryData['mol']);
        $mol->addOffice1C($rooms);

        // Define NomenclatureType
        $nomenclatureType = $this->em->getRepository('Storage_1C:NomenclatureType')->getByType($inventoryData['typeOfNomenclature']);

        // Define Nomenclature1C
        $nomenclature = $this->em->getRepository('Storage_1C:Nomenclature1C')->getByTitleAndType($inventoryData['nomenclature'], $nomenclatureType);

        // Define InventoryItemCategory
        $category = $this->em->getRepository('Storage_1C:InventoryItemCategory')->getEmptyInstance();

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
        $item['typeOfNomenclature'] = empty($data[4]) ? self::EMPTY : $data[4];
        $item['dateOfRegistration'] = empty($data[3]) ? self::EMPTY : new \DateTime($data[3], new \DateTimeZone('UTC'));
        $item['mol'] = empty($data[5]) ? self::EMPTY : $data[5];
        $item['molTabNumber'] = empty($data[8]) ? self::EMPTY : $data[8];
        $item['roomsCode'] = empty($data[6]) ? self::EMPTY : $data[6];
        $item['roomsAddress'] = empty($data[7]) ? self::EMPTY : $data[7];

        $item['roomsTitle'] = self::EMPTY;
        if (self::EMPTY != $item['roomsAddress']) {
            $matches = [];
            mb_ereg('\([^\{|\)]+\)$', $item['roomsAddress'], $matches);
            if (!empty($matches)) {
                $item['roomsTitle'] = trim(mb_ereg_replace('\(|\)', '', $matches[0]));
            }
        }
        return $item;
    }
}
