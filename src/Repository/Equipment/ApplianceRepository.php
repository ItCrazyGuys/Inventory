<?php

namespace App\Repository\Equipment;

use App\Entity\Equipment\Appliance;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class ApplianceRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Appliance::class);
    }


    /**
     * @return mixed
     */
    public function findAllSerialNumbers()
    {
        $query = $this->getEntityManager()->createQuery('SELECT a.id, p.serialNumber FROM App\Entity\Equipment\Appliance a JOIN a.platform p');
        return $query->getResult();
    }

    /**
     * @param $serialNumber
     * @return mixed
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findOneBySerialNumber($serialNumber)
    {
        $query = $this->getEntityManager()->createQuery('SELECT a FROM App\Entity\Equipment\Appliance a JOIN a.platform p WHERE p.serialNumber = :serialNumber');
        $query->setParameter('serialNumber', $serialNumber);
        return $query->getOneOrNullResult();
    }
}
