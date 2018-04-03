<?php

namespace App\Repository\Storage_1C;

use App\Entity\Storage_1C\City1C;
use App\Entity\Storage_1C\Region1C;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class City1CRepository extends ServiceEntityRepository
{
    private const EMPTY = '';


    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, City1C::class);
    }

    /**
     * @return City1C
     */
    public function getEmptyInstance(): City1C
    {
        $city1C = self::findOneBy(['title' => self::EMPTY]);
        if (is_null($city1C)) {
            $em = self::getEntityManager();
            $city1C = new City1C();
            $city1C->setTitle(self::EMPTY);
            $city1C->setRegion1C($em->getRepository('Storage_1C:Region1C')->getEmptyInstance());
            $em->persist($city1C);
        }
        return $city1C;
    }

    /**
     * @param string $cityTitle
     * @param Region1C $region
     * @return City1C
     */
    public function getByTitleAndRegion(string $cityTitle, Region1C $region): City1C
    {
        $city1C = self::findOneBy(['title' => $cityTitle, 'region1C' => $region]);
        if (is_null($city1C)) {
            $city1C = new City1C();
            $city1C->setTitle($cityTitle);
            $city1C->setRegion1C($region);
            self::getEntityManager()->persist($city1C);
        }
        return $city1C;
    }
}
