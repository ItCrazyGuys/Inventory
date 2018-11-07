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
                if (!empty($viewInventoryItem1C['serialNumber'])) {
                    // Для всех InventoryItem1C имеющих серийный номер создать или обновить связь с Appliance
                    // Appliance1C check
                    $appliance1C = $this->em->getRepository('Storage_1C:Appliance1C')->findOneBy(['inventoryData' => $viewInventoryItem1C['id']]);
                    if (is_null($appliance1C)) {
                        $this->createAppliance1C($viewInventoryItem1C);
                    } else {
                        // Appliance check
                        $appliance = $this->findApplianceBySerialNumber($viewInventoryItem1C['serialNumber']);
                        if (!is_null($appliance)) {
                            $this->updateAppliance1C($appliance1C, $appliance);
                        } else {
                            // если Appliance не найден а связь есть, то удалить связь
                            $this->deleteAppliance1C($appliance1C);
                        }
                    }
                } else {
                    // Если серийника у InventoryItem1C нет, проверить по InventoryData есть ли соответствующий Appliance1C и удалить его
                    $appliance1C = $this->em->getRepository('Storage_1C:Appliance1C')->findOneBy(['inventoryData' => $viewInventoryItem1C['id']]);
                    if (!is_null($appliance1C)) {
                        $this->deleteAppliance1C($appliance1C);
                    }
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
     * @param Appliance $appliance
     * @throws \Doctrine\ORM\ORMException
     */
    private function updateAppliance1C(Appliance1C $appliance1C, Appliance $appliance)
    {
        $hasUpdate = false;

        // Appliance check
        if ($appliance1C->getVoiceAppliance()->getId() != $appliance->getId()) {
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
