<?php

namespace App\Repository\Storage_1C;

use App\Entity\Storage_1C\InventoryItem1C;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class InventoryItem1CRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, InventoryItem1C::class);
    }

    public function getdAllInventoryNumbers()
    {
        $query = $this->getEntityManager()->createQuery('SELECT i.inventoryNumber FROM App\Entity\Storage_1C\InventoryItem1C i');
        return $query->getResult();
    }
}
