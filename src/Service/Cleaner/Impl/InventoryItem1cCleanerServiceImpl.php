<?php

namespace App\Service\Cleaner\Impl;

use App\Entity\Storage_1C\InventoryItem1C;
use App\Service\Cleaner\CleanerService;
use Doctrine\ORM\EntityManagerInterface;

class InventoryItem1cCleanerServiceImpl implements CleanerService
{
    private const ZERO = 0;
    private $em;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
    }

    public function clean()
    {
        // Get repository
        $repository = $this->em->getRepository(InventoryItem1C::class);

        // Find unprocessed InventoryItems
        $inventoryItems = $repository->findUnProcessed();

        // If InventoryItems does fined, then delete them
        if (count($inventoryItems) > self::ZERO) {
            foreach ($inventoryItems as $inventoryItem) {
                $repository->remove($inventoryItem);
            }
        }
    }
}
