<?php

namespace App\Service\Import1C;

use App\Entity\Equipment\ModuleItem;
use App\Entity\Storage_1C\Module1C;
use App\Service\Importer;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;

class ImporterModule1CFrom1C implements Importer
{
    private $em;
    private $logger;

    /**
     * ImportModule1CFrom1C constructor.
     * @param EntityManagerInterface $em
     * @param LoggerInterface $logger
     */
    public function __construct(EntityManagerInterface $em, LoggerInterface $logger)
    {
        $this->em = $em;
        $this->logger = $logger;
    }

    /**
     * Import Module1C from 1C-db
     */
    public function import()
    {
        // Get Data of InventoryItems1C from View
        $viewInventoryItems1C = $this->em->getRepository('View:InvItem1C')->getAllIdAndSerialNumberAndMolTabNumber();
        foreach ($viewInventoryItems1C as $viewInventoryItem1C) {
            try {
                if (!empty($viewInventoryItem1C['serialNumber'])) {
                    // Для всех InventoryItem1C имеющих серийный номер создать или обновить связь с Module
                    // Module1C check
                    $module1C = $this->em->getRepository('Storage_1C:Module1C')->findOneBy(['inventoryData' => $viewInventoryItem1C['id']]);
                    if (is_null($module1C)) {
                        $this->createModule1C($viewInventoryItem1C);
                    } else {
                        // Module check
                        $module = $this->findModuleBySerialNumber($viewInventoryItem1C['serialNumber']);
                        if (!is_null($module)) {
                            $this->updateModule1C($module1C, $module);
                        } else {
                            // если Module не найден а связь есть, то удалить связь
                            $this->deleteModule1C($module1C);
                        }
                    }
                } else {
                    // Если серийника у InventoryItem1C нет, проверить по InventoryData есть ли соответствующий Module1C и удалить его
                    $module1C = $this->em->getRepository('Storage_1C:Module1C')->findOneBy(['inventoryData' => $viewInventoryItem1C['id']]);
                    if (!is_null($module1C)) {
                        $this->deleteModule1C($module1C);
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
     * @param Module1C $module1C
     * @throws \Doctrine\ORM\ORMException
     */
    private function deleteModule1C(Module1C $module1C)
    {
        // InventoryItem1C set Empty Category
        $inventoryItem1C = $module1C->getInventoryData();
        $inventoryItem1C->setCategory($this->em->getRepository('Storage_1C:InventoryItemCategory')->getEmptyInstance());

        // Delete Module1C
        $this->em->remove($module1C);
        $this->em->flush();
    }

    /**
     * @param Module1C $module1C
     * @param ModuleItem $module
     * @throws \Doctrine\ORM\ORMException
     */
    private function updateModule1C(Module1C $module1C, ModuleItem $module)
    {
        $hasUpdate = false;

        // Module check
        if ($module1C->getVoiceModule()->getId() != $module->getId()) {
            $module1C->setVoiceModule($module);
            $hasUpdate = true;
        }

        // Category check
        $moduleCategory = $this->em->getRepository('Storage_1C:InventoryItemCategory')->getModuleCategory();
        $inventoryItem1C = $module1C->getInventoryData();
        if ($inventoryItem1C->getCategory()->getId() != $moduleCategory->getId()) {
            $inventoryItem1C->setCategory($moduleCategory);
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
    private function createModule1C(array $inventoryItem1CData)
    {
        // Find Module by Serial Number
        $module = $this->findModuleBySerialNumber($inventoryItem1CData['serialNumber']);

        // Если соответствующий Module нашелся, создать Module1C
        if (!is_null($module)) {
            // Get InventoryItem1C by Id and set ModuleCategory
            $inventoryItem1C = $this->em->getRepository('Storage_1C:InventoryItem1C')->find($inventoryItem1CData['id']);
            $inventoryItem1C->setCategory($this->em->getRepository('Storage_1C:InventoryItemCategory')->getModuleCategory());

            // Create Module1C
            $module1C = new Module1C();
            $module1C->setVoiceModule($module);
            $module1C->setInventoryData($inventoryItem1C);
            $this->em->persist($module1C);
            $this->em->flush();
        }
    }

    /**
     * @param $serialNumber
     * @return ModuleItem|null
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    private function findModuleBySerialNumber($serialNumber)
    {
        // Find Module by Serial Number
        $module = $this->em->getRepository('Equipment:ModuleItem')->findOneBySerialNumber($serialNumber);
        if (is_null($module)) {
            // проверить на наличие ошибочного серийника - (перед серийником стоит символ S или &), получаемый со сканера шрих-кодов.
            $erroneousSerialNumber = mb_ereg_match('^(S|&)', mb_strtoupper($serialNumber)) ? mb_ereg_replace('^(S|&)', '', mb_strtoupper($serialNumber)) : null;
            if (!is_null($erroneousSerialNumber)) {

                // Find Module by Erroneous SerialNumber
                $module = $this->em->getRepository('Equipment:ModuleItem')->findOneBySerialNumber($erroneousSerialNumber);
            }
        }
        return $module;
    }
}
