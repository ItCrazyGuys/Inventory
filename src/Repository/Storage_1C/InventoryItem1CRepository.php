<?php

namespace App\Repository\Storage_1C;

use App\Entity\Storage_1C\Appliance1C;
use App\Entity\Storage_1C\InventoryItem1C;
use App\Entity\Storage_1C\Module1C;
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

    /**
     * @param InventoryItem1C $inventoryItem
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function remove(InventoryItem1C $inventoryItem)
    {
        // Get entity manager
        $em = $this->getEntityManager();

        // Find Appliance1C by InventoryItem and remove them
        $appliances1C = $em->getRepository(Appliance1C::class)->findBy(['inventoryData' => $inventoryItem]);
        if (count($appliances1C) > 0) {
            foreach ($appliances1C as $appliance1C) {
                $em->remove($appliance1C);
            }
        }

        // Find Module1C by InventoryItem and remove them
        $modules1C = $em->getRepository(Module1C::class)->findBy(['inventoryData' => $inventoryItem]);
        if (count($modules1C) > 0) {
            foreach ($modules1C as $module1C) {
                $em->remove($module1C);
            }
        }

        // Remove InventoryItem
        $em->remove($inventoryItem);
        $em->flush();
    }

    /**
     * @return mixed
     */
    public function findUnProcessed()
    {
        $query = $this->getEntityManager()->createQuery('SELECT i FROM App\Entity\Storage_1C\InventoryItem1C i WHERE i.lastUpdate < :currentDate');
        $query->setParameter('currentDate', (new \DateTime('now'))->format('Y-m-d'));
        return $query->getResult();
    }
}
