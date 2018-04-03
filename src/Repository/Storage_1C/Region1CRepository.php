<?php

namespace App\Repository\Storage_1C;

use App\Entity\Storage_1C\Region1C;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class Region1CRepository extends ServiceEntityRepository
{
    private const EMPTY = '';


    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Region1C::class);
    }

    /**
     * @return Region1C
     */
    public function getEmptyInstance(): Region1C
    {
        $region1C = self::findOneBy(['title' => self::EMPTY]);
        if (is_null($region1C)) {
            $region1C = new Region1C();
            $region1C->setTitle(self::EMPTY);
            self::getEntityManager()->persist($region1C);
        }
        return $region1C;
    }

    /**
     * @param string $regionTitle
     * @return Region1C
     */
    public function getByTitle(string $regionTitle): Region1C
    {
        $region1C = null;
        if ($regionTitle == self::EMPTY) {
            $region1C = $this->getEmptyInstance();
        } else {
            $region1C = self::findOneBy(['title' => $regionTitle]);
            if (is_null($region1C)) {
                $region1C = new Region1C();
                $region1C->setTitle($regionTitle);
                self::getEntityManager()->persist($region1C);
            }
        }
        return $region1C;
    }
}
