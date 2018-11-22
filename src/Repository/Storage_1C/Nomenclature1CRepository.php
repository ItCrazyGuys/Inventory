<?php

namespace App\Repository\Storage_1C;

use App\Entity\Storage_1C\Nomenclature1C;
use App\Entity\Storage_1C\NomenclatureType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class Nomenclature1CRepository extends ServiceEntityRepository
{
    private const EMPTY = '';
    private $validator;


    public function __construct(RegistryInterface $registry, ValidatorInterface $validator)
    {
        $this->validator = $validator;
        parent::__construct($registry, Nomenclature1C::class);
    }

    /**
     * @return Nomenclature1C
     * @throws \Doctrine\ORM\ORMException
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
     * @param $nomenclatureId
     * @param string $title
     * @param NomenclatureType $type
     * @return Nomenclature1C
     * @throws \Doctrine\ORM\ORMException
     */
    public function getByFields($nomenclatureId, string $title, NomenclatureType $type): Nomenclature1C
    {
        $nomenclature1C = self::findOneBy(['nomenclatureId' => $nomenclatureId, 'type' => $type]);
        if (is_null($nomenclature1C)) {
            $nomenclature1C = new Nomenclature1C();
            $nomenclature1C->setNomenclatureId($nomenclatureId);
            $nomenclature1C->setTitle($title);
            $nomenclature1C->setType($type);
            self::getEntityManager()->persist($nomenclature1C);
        } elseif ($title != $nomenclature1C->getTitle()) {
            $nomenclature1C->setTitle($title);
        }
        return $nomenclature1C;
    }

    /**
     * @param $nomenclatureId
     * @param $nomenclatureType
     * @return mixed
     */
    public function findByNomenclatureIdAndNomenclatureType($nomenclatureId, $nomenclatureType)
    {
        $sql = 'SELECT n FROM App\Entity\Storage_1C\Nomenclature1C n JOIN n.type nt WHERE n.nomenclatureId = :nomenclatureId AND nt.type = :nomenclatureType';
        $query = $this->getEntityManager()->createQuery($sql);
        $query->setParameter('nomenclatureId', $nomenclatureId);
        $query->setParameter('nomenclatureType', $nomenclatureType);
        return $query->getResult();
    }
}
