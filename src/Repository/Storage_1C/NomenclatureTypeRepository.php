<?php

namespace App\Repository\Storage_1C;

use App\Entity\Storage_1C\NomenclatureType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class NomenclatureTypeRepository extends ServiceEntityRepository
{
    private const EMPTY = '';


    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, NomenclatureType::class);
    }

    /**
     * @return NomenclatureType
     */
    public function getEmptyType(): NomenclatureType
    {
        $nomenclatureType = self::findOneBy(['type' => self::EMPTY]);
        if (is_null($nomenclatureType)) {
            $nomenclatureType = new NomenclatureType();
            $nomenclatureType->setType(self::EMPTY);
            self::getEntityManager()->persist($nomenclatureType);
        }
        return $nomenclatureType;
    }

    /**
     * @param string $type
     * @return NomenclatureType
     */
    public function getByType(string $type): NomenclatureType
    {
        $nomenclatureType = null;
        if ($type == self::EMPTY) {
            $nomenclatureType = $this->getEmptyType();
        } else {
            $nomenclatureType = self::findOneBy(['type' => $type]);
            if (is_null($nomenclatureType)) {
                $nomenclatureType = new NomenclatureType();
                $nomenclatureType->setType($type);
                self::getEntityManager()->persist($nomenclatureType);
            }
        }
        return $nomenclatureType;
    }
}
