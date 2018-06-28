<?php

namespace App\Utils;

use App\Entity\Equipment\Appliance;
use App\Entity\Storage_1C\Appliance1C;
use App\Repository\Storage_1C\MolRepository;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;

class ImporterAppliance1CFrom1C
{
    private const EMPTY = '';

    private $em;
    private $logger;

    /**
     * ImporterAppliance1CFrom1C constructor.
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

                    // Find VoiceAppliance
                    $voiceAppliance = $this->em->getRepository('Equipment:Appliance')->findOneBySerialNumber($viewInventoryItem1C['serialNumber']);

                    // Find VoiceAppliance by Erroneous SerialNumber
                    if (is_null($voiceAppliance)) {
                        // ошибочный серийник (перед серийником стоит символ S или &), получаемый со сканера шрих-кодов.
                        $erroneousSerialNumber = mb_ereg_match('^(S|&)', mb_strtoupper($viewInventoryItem1C['serialNumber'])) ? mb_ereg_replace('^(S|&)', '', mb_strtoupper($viewInventoryItem1C['serialNumber'])) : null;

                        if (!is_null($erroneousSerialNumber)) {
                            $voiceAppliance = $this->em->getRepository('Equipment:Appliance')->findOneBySerialNumber($erroneousSerialNumber);
                        }
                    }

                    // Create or Update Appliance1C
                    if (!is_null($voiceAppliance)) {

                        // Find Appliance1C by InventoryItem1C
                        $appliance1cByInventoryItem1C = $this->em->getRepository('Storage_1C:Appliance1C')->findOneBy(['inventoryData' => $viewInventoryItem1C['id']]);

                        // Find Appliance1C by VoiceAppliance
                        $appliance1cByVoiceAppliance = $voiceAppliance->getAppliance1C();

                        // Create Appliance1C
                        if (is_null($appliance1cByInventoryItem1C) && is_null($appliance1cByVoiceAppliance)) {
                            $this->createAppliance1C($viewInventoryItem1C['id'], $voiceAppliance);
                            $this->em->flush();
                        }

                        // Create Appliance1C
                        if (is_null($appliance1cByInventoryItem1C) && !is_null($appliance1cByVoiceAppliance) && MolRepository::EMPTY_TAB_NUMBER !== $viewInventoryItem1C['molTabNumber']) {
                            $this->em->remove($appliance1cByVoiceAppliance);
                            $this->em->flush();
                            $this->em->refresh($voiceAppliance);
                            $this->createAppliance1C($viewInventoryItem1C['id'], $voiceAppliance);
                            $this->em->flush();
                        }

                        // Update Appliance1C
                        if (!is_null($appliance1cByInventoryItem1C) && is_null($appliance1cByVoiceAppliance)) {
                            $appliance1C = $appliance1cByInventoryItem1C;
                            $appliance1C->setVoiceAppliance($voiceAppliance);
                            $this->em->flush();
                        }

                        // Update Appliance1C
                        if (!is_null($appliance1cByInventoryItem1C) && !is_null($appliance1cByVoiceAppliance) && $appliance1cByInventoryItem1C->getId() != $appliance1cByVoiceAppliance->getId()) {
                            if (MolRepository::EMPTY_TAB_NUMBER !== $viewInventoryItem1C['molTabNumber']) {
                                $this->em->remove($appliance1cByVoiceAppliance);
                                $this->em->flush();
                                $this->em->refresh($voiceAppliance);
                                $appliance1C = $appliance1cByInventoryItem1C;
                                $appliance1C->setVoiceAppliance($voiceAppliance);
                            } else {
                                $this->em->remove($appliance1cByInventoryItem1C);
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
     * @param Appliance $voiceAppliance
     */
    private function createAppliance1C(string $inventoryItem1cID, Appliance $voiceAppliance)
    {
        // Get InventoryItem1C
        $inventoryItem1C = $this->em->getRepository('Storage_1C:InventoryItem1C')->find($inventoryItem1cID);

        // Create Appliance1C
        $appliance1C = new Appliance1C();
        $appliance1C->setInventoryData($inventoryItem1C);
        $appliance1C->setVoiceAppliance($voiceAppliance);
        $this->em->persist($appliance1C);
    }
}
