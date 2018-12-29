<?php

namespace App\Repository\View;

use App\Entity\View\DevPhoneInfoGeo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\RegistryInterface;

class DevPhoneInfoGeoRepository extends ServiceEntityRepository
{
    private $em;

    public function __construct(RegistryInterface $registry, EntityManagerInterface $em)
    {
        $this->em = $em;
        parent::__construct($registry, DevPhoneInfoGeo::class);
    }

    /**
     * @param $prefix
     * @param $dn
     * @return mixed
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getOfficeAndApplianceBy($prefix, $dn)
    {
        $sql = 'SELECT i.officeId, i.applianceId FROM App\Entity\View\DevPhoneInfoGeo i WHERE i.prefix = :prefix AND i.phoneDN = :dn';
        $query = $this->getEntityManager()->createQuery($sql);
        $query->setParameter('prefix', $prefix);
        $query->setParameter('dn', $dn);
        return $query->getOneOrNullResult();
    }
}
