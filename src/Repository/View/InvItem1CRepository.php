<?php

namespace App\Repository\View;

use App\Entity\View\InvItem1C;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class InvItem1CRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, InvItem1C::class);
    }


    public function getAllIdAndSerialNumberAndMolTabNumber()
    {
        $sql = 'SELECT i.invItem_id id, i.invItem_serialNumber serialNumber, i.mol_tabNumber molTabNumber FROM App\Entity\View\InvItem1C i';
        $query = $this->getEntityManager()->createQuery($sql);
        return $query->getArrayResult();
    }
}
