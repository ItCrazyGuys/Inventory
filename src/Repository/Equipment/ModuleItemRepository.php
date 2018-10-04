<?php

namespace App\Repository\Equipment;

use App\Entity\Equipment\ModuleItem;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class ModuleItemRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ModuleItem::class);
    }


    /**
     * @return mixed
     */
    public function findAllSerialNumbers()
    {
        $query = $this->getEntityManager()->createQuery('SELECT m.id, m.serialNumber FROM App\Entity\Equipment\ModuleItem m');
        return $query->getResult();
    }

    /**
     * @param $serialNumber
     * @return mixed
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findOneBySerialNumber($serialNumber)
    {
        $query = $this->getEntityManager()->createQuery('SELECT m FROM App\Entity\Equipment\ModuleItem m WHERE m.serialNumber = :serialNumber');
        $query->setParameter('serialNumber', $serialNumber);
        return $query->getOneOrNullResult();
    }
}
