<?php

namespace App\Repository\Storage_1C;

use App\Entity\Equipment\Appliance;
use App\Entity\Storage_1C\Appliance1C;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class Appliance1CRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Appliance1C::class);
    }


    /**
     * @param Appliance $appliance
     * @return mixed
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findOneByVoiceAppliance(Appliance $appliance)
    {
        $query = $this->getEntityManager()->createQuery('SELECT a FROM App\Entity\Storage_1C\Appliance1C a JOIN a.voiceAppliance va WHERE va.id = :id');
        $query->setParameter('id', $appliance->getId());
        return $query->getOneOrNullResult();
    }

}
