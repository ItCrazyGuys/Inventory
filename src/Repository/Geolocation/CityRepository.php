<?php

namespace App\Repository\Geolocation;

use App\Entity\Geolocation\City;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class CityRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, City::class);
    }


    /**
     * @return mixed
     */
    public function findByTitle(string $title)
    {
        $query = $this->getEntityManager()->createQuery('SELECT c, a FROM App\Entity\Geolocation\City c JOIN c.addresses a WHERE c.title = :title');
        $query->setParameter('title', $title);
        return $query->getResult();
    }
}
