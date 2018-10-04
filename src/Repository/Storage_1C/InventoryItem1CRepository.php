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

    /**
     * @param $inventoryNumber
     * @param $nomenclatureType
     * @return mixed
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findOneByInventoryNumberAndNomenclatureType($inventoryNumber, $nomenclatureType)
    {
        $sql = 'SELECT i FROM App\Entity\Storage_1C\InventoryItem1C i JOIN i.nomenclature n JOIN n.type nt WHERE i.inventoryNumber = :inventoryNumber AND nt.type = :nomenclatureType';
        $query = $this->getEntityManager()->createQuery($sql);
        $query->setParameter('inventoryNumber', $inventoryNumber);
        $query->setParameter('nomenclatureType', $nomenclatureType);
        return $query->getOneOrNullResult();
    }

    /**
     * @param $inventoryNumber
     * @param $nomenclatureType
     * @return mixed
     */
    public function findByInventoryNumberAndNomenclatureType($inventoryNumber, $nomenclatureType)
    {
        $sql = 'SELECT i FROM App\Entity\Storage_1C\InventoryItem1C i JOIN i.nomenclature n JOIN n.type nt WHERE i.inventoryNumber = :inventoryNumber AND nt.type = :nomenclatureType';
        $query = $this->getEntityManager()->createQuery($sql);
        $query->setParameter('inventoryNumber', $inventoryNumber);
        $query->setParameter('nomenclatureType', $nomenclatureType);
        return $query->getResult();
    }
}
