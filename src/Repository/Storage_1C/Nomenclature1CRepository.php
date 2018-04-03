<?php

namespace App\Repository\Storage_1C;

use App\Entity\Storage_1C\Nomenclature1C;
use App\Entity\Storage_1C\NomenclatureType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class Nomenclature1CRepository extends ServiceEntityRepository
{
    private const EMPTY = '';


    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Nomenclature1C::class);
    }

    /**
     * @return Nomenclature1C
     */
    public function getEmptyInstance(): Nomenclature1C
    {
        $nomenclature1C = self::findOneBy(['title' => self::EMPTY]);
        if (is_null($nomenclature1C)) {
            $nomenclature1C = new Nomenclature1C();
            $nomenclature1C->setTitle(self::EMPTY);
            $nomenclature1C->setType(self::getEntityManager()->getRepository('Storage_1C:NomenclatureType')->getEmptyType());
            self::getEntityManager()->persist($nomenclature1C);
        }
        return $nomenclature1C;
    }

    /**
     * @param string $title
     * @param NomenclatureType $type
     * @return Nomenclature1C
     */
    public function getByTitleAndType(string $title, NomenclatureType $type): Nomenclature1C
    {
        $nomenclature1C = self::findOneBy(['title' => $title, 'type' => $type]);
        if (is_null($nomenclature1C)) {
            $nomenclature1C = new Nomenclature1C();
            $nomenclature1C->setTitle($title);
            $nomenclature1C->setType($type);
            self::getEntityManager()->persist($nomenclature1C);
        }
        return $nomenclature1C;
    }
}
