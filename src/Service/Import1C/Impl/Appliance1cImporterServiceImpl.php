<?php

namespace App\Service\Import1C\Impl;

use App\Entity\Equipment\Appliance;
use App\Entity\Storage_1C\Appliance1C;
use App\Service\Import1C\Appliance1cImporterService;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;

class Appliance1cImporterServiceImpl implements Appliance1cImporterService
{
    private $em;
    private $logger;

    /**
     * ImporterServiceAppliance1CFrom1C constructor.
     * @param EntityManagerInterface $em
     * @param LoggerInterface $logger
     */
    public function __construct(EntityManagerInterface $em, LoggerInterface $logger)
    {
        $this->em = $em;
        $this->logger = $logger;
    }

    /**
     * Import Appliance1C from 1C-db
     */
    public function import()
    {
        // Get Data of InventoryItems1C from View
        $viewInventoryItems1C = $this->em->getRepository('View:InvItem1C')->getAllIdAndSerialNumberAndMolTabNumber();
        foreach ($viewInventoryItems1C as $viewInventoryItem1C) {
            try {

                // Find Appliance1C by InventoryItemId
                $appliance1C = $this->em->getRepository('Storage_1C:Appliance1C')->findOneBy(['inventoryData' => $viewInventoryItem1C['id']]);

                // Для всех InventoryItem имеющих серийный номер создать или обновить связь с Appliance
                if (!empty($viewInventoryItem1C['serialNumber'])) {
                    if (is_null($appliance1C)) {
                        $this->createAppliance1C($viewInventoryItem1C);
                    } else {
                        $this->updateAppliance1C($appliance1C, $viewInventoryItem1C);
                    }
                } elseif (!is_null($appliance1C)) {
                    // Если у InventoryItem1C пустой серийник, но есть соответстующий Appliance1C - удалить этот Appliance1C
                    $this->deleteAppliance1C($appliance1C);
                }

                $this->em->clear();
            } catch (\Throwable $e) {
                $this->em->clear();
                $this->logger->error($e->getMessage());
            }
        }
    }

    /**
     * @param Appliance1C $appliance1C
     * @throws \Doctrine\ORM\ORMException
     */
    private function deleteAppliance1C(Appliance1C $appliance1C)
    {
        // InventoryItem1C set Empty Category
        $inventoryItem1C = $appliance1C->getInventoryData();
        $inventoryItem1C->setCategory($this->em->getRepository('Storage_1C:InventoryItemCategory')->getEmptyInstance());

        // Delete Module1C
        $this->em->remove($appliance1C);
        $this->em->flush();
    }

    /**
     * @param Appliance1C $appliance1C
     * @param $viewInventoryItem1C
     * @throws \Doctrine\ORM\NonUniqueResultException
     * @throws \Doctrine\ORM\ORMException
     */
    private function updateAppliance1C(Appliance1C $appliance1C, $viewInventoryItem1C)
    {
        $hasUpdate = false;

        // Appliance check
        $appliance = $this->findApplianceBySerialNumber($viewInventoryItem1C['serialNumber']);
        if ($appliance1C->getVoiceAppliance()->getId() != $appliance->getId()) {

            // Check Duplicate Appliance1C by Appliance, if true, then delete Duplicate Appliance1C
            $duplicateAppliances1C = $this->em->getRepository(Appliance1C::class)->findBy(['voiceAppliance' => $appliance]);
            if (count($duplicateAppliances1C) > 0) {
                foreach ($duplicateAppliances1C as $duplicateAppliance1C) {
                    $this->em->remove($duplicateAppliance1C);
                    $this->em->flush();
                }
            }
            $this->em->refresh($appliance1C);
            $this->em->refresh($appliance);

            $appliance1C->setVoiceAppliance($appliance);
            $hasUpdate = true;
        }

        // Category check
        $applianceCategory = $this->em->getRepository('Storage_1C:InventoryItemCategory')->getApplianceCategory();
        $inventoryItem1C = $appliance1C->getInventoryData();
        if ($inventoryItem1C->getCategory()->getId() != $applianceCategory->getId()) {
            $inventoryItem1C->setCategory($applianceCategory);
            $hasUpdate = true;
        }

        if ($hasUpdate) {
            $this->em->flush();
        }
    }

    /**
     * @param $inventoryItem1CData
     * @throws \Doctrine\ORM\NonUniqueResultException
     * @throws \Doctrine\ORM\ORMException
     */
    private function createAppliance1C($inventoryItem1CData)
    {
        // Find Appliance by Serial Number
        $appliance = $this->findApplianceBySerialNumber($inventoryItem1CData['serialNumber']);

        // Если соответствующий Appliance нашелся, создать Appliance1C
        if (!is_null($appliance)) {
            // Check Duplicate Appliance1C by Appliance, if true, then delete Duplicate Appliance1C
            $duplicateAppliance1C = $this->em->getRepository(Appliance1C::class)->findBy(['voiceAppliance' => $appliance]);
            if (count($duplicateAppliance1C) > 0) {
                foreach ($duplicateAppliance1C as $appliance1C) {
                    $this->em->remove($appliance1C);
                    $this->em->flush();
                }
            }
            $this->em->refresh($appliance);

            // Get InventoryItem1C by Id and set ApplianceCategory
            $inventoryItem1C = $this->em->getRepository('Storage_1C:InventoryItem1C')->find($inventoryItem1CData['id']);
            $inventoryItem1C->setCategory($this->em->getRepository('Storage_1C:InventoryItemCategory')->getApplianceCategory());

            // Create Appliance1C
            $appliance1C = new Appliance1C();
            $appliance1C->setVoiceAppliance($appliance);
            $appliance1C->setInventoryData($inventoryItem1C);
            $this->em->persist($appliance1C);
            $this->em->flush();
        }
    }

    /**
     * @param $serialNumber
     * @return Appliance|null
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    private function findApplianceBySerialNumber($serialNumber)
    {
        // Find Appliance by Serial Number
        $appliance = $this->em->getRepository('Equipment:Appliance')->findOneBySerialNumber($serialNumber);
        if (is_null($appliance)) {
            // проверить на наличие ошибочного серийника - (перед серийником стоит символ S или &), получаемый со сканера шрих-кодов.
            $erroneousSerialNumber = mb_ereg_match('^(S|&)', mb_strtoupper($serialNumber)) ? mb_ereg_replace('^(S|&)', '', mb_strtoupper($serialNumber)) : null;
            if (!is_null($erroneousSerialNumber)) {

                // Find Appliance by Erroneous SerialNumber
                $appliance = $this->em->getRepository('Equipment:Appliance')->findOneBySerialNumber($erroneousSerialNumber);
            }
        }
        return $appliance;
    }
}
