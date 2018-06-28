<?php

namespace App\Utils;

use App\Entity\Equipment\ModuleItem;
use App\Entity\Storage_1C\Module1C;
use App\Repository\Storage_1C\MolRepository;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;

class ImportModule1CFrom1C
{
    private const EMPTY = '';

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

    public function import()
    {
        // Get View of InventoryItems1C
        $viewInventoryItems1C = $this->em->getRepository('View:InvItem1C')->getAllIdAndSerialNumberAndMolTabNumber();
        foreach ($viewInventoryItems1C as $viewInventoryItem1C) {
            try {

                if (self::EMPTY != $viewInventoryItem1C['serialNumber']) {

                    // Find VoiceModule
                    $voiceModule = $this->em->getRepository('Equipment:ModuleItem')->findOneBy(['serialNumber' => $viewInventoryItem1C['serialNumber']]);

                    // Find VoiceModule by Erroneous SerialNumber
                    if (is_null($voiceModule)) {
                        // ошибочный серийник (перед серийником стоит символ S или &), получаемый со сканера шрих-кодов.
                        $erroneousSerialNumber = mb_ereg_match('^(S|&)', mb_strtoupper($viewInventoryItem1C['serialNumber'])) ? mb_ereg_replace('^(S|&)', '', mb_strtoupper($viewInventoryItem1C['serialNumber'])) : null;

                        if (!is_null($erroneousSerialNumber)) {
                            $voiceModule = $this->em->getRepository('Equipment:ModuleItem')->findOneBy(['serialNumber' => $erroneousSerialNumber]);
                        }
                    }

                    // Create or Update Module1C
                    if (!is_null($voiceModule)) {

                        // Find Module1C by InventoryItem1C
                        $module1cByInventoryItem1C = $this->em->getRepository('Storage_1C:Module1C')->findOneBy(['inventoryData' => $viewInventoryItem1C['id']]);

                        // Find Module1C by VoiceModule
                        $module1cByVoiceModule = $voiceModule->getModule1C();

                        // Create Module1C
                        if (is_null($module1cByInventoryItem1C) && is_null($module1cByVoiceModule)) {
                            $this->createModule1C($viewInventoryItem1C['id'], $voiceModule);
                            $this->em->flush();
                        }

                        // Create Module1C
                        if (is_null($module1cByInventoryItem1C) && !is_null($module1cByVoiceModule) && MolRepository::EMPTY_TAB_NUMBER !== $viewInventoryItem1C['molTabNumber']) {
                            $this->em->remove($module1cByVoiceModule);
                            $this->em->flush();
                            $this->em->refresh($voiceModule);
                            $this->createModule1C($viewInventoryItem1C['id'], $voiceModule);
                            $this->em->flush();
                        }

                        // Update Module1C
                        if (!is_null($module1cByInventoryItem1C) && is_null($module1cByVoiceModule)) {
                            $module1C = $module1cByInventoryItem1C;
                            $module1C->setVoiceModule($voiceModule);
                            $this->em->flush();
                        }

                        // Update Module1C
                        if (!is_null($module1cByInventoryItem1C) && !is_null($module1cByVoiceModule) && $module1cByInventoryItem1C->getId() != $module1cByVoiceModule->getId()) {
                            if (MolRepository::EMPTY_TAB_NUMBER !== $viewInventoryItem1C['molTabNumber']) {
                                $this->em->remove($module1cByVoiceModule);
                                $this->em->flush();
                                $this->em->refresh($voiceModule);
                                $module1C = $module1cByInventoryItem1C;
                                $module1C->setVoiceModule($voiceModule);
                            } else {
                                $this->em->remove($module1cByInventoryItem1C);
                            }
                            $this->em->flush();
                        }

                        $this->em->clear();
                    }
                }
            } catch (\Throwable $e) {
                $this->em->clear();
                $this->logger->error($e->getMessage());
            }
        }
    }

    /**
     * @param string $inventoryItem1cID
     * @param ModuleItem $voiceModule
     */
    private function createModule1C(string $inventoryItem1cID, ModuleItem $voiceModule)
    {
        // Get InventoryItem1C
        $inventoryItem1C = $this->em->getRepository('Storage_1C:InventoryItem1C')->find($inventoryItem1cID);

        // Create Module1C
        $module1C = new Module1C();
        $module1C->setInventoryData($inventoryItem1C);
        $module1C->setVoiceModule($voiceModule);
        $this->em->persist($module1C);
    }
}
