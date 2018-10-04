<?php

namespace App\Repository\Storage_1C;

use App\Entity\Storage_1C\Mol;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class MolRepository extends ServiceEntityRepository
{
    private const EMPTY = '';
    const EMPTY_TAB_NUMBER = -1;


    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Mol::class);
    }

    /**
     * @return Mol
     * @throws \Doctrine\ORM\ORMException
     */
    public function getEmptyInstance(): Mol
    {
        $mol = self::findOneBy(['molTabNumber' => self::EMPTY_TAB_NUMBER]);
        if (is_null($mol)) {
            $mol = new Mol();
            $mol->setFio(self::EMPTY);
            $mol->setMolTabNumber(self::EMPTY_TAB_NUMBER);
            self::getEntityManager()->persist($mol);
        }
        return $mol;
    }

    /**
     * @param $tabNumber
     * @param string $fio
     * @return Mol
     * @throws \Exception
     */
    public function getByTabNumberAndFio($tabNumber, string $fio): Mol
    {
        $mol = null;
        if ($tabNumber  == self::EMPTY) {
            $mol = $this->getEmptyInstance();
        } else {
            $mol = self::findOneBy(['molTabNumber' => $tabNumber]);
            if (is_null($mol)) {
                $mol = new Mol();
                $mol->setFio($fio);
                $mol->setMolTabNumber($tabNumber);
                self::getEntityManager()->persist($mol);
            } elseif ($mol->getFio() != $fio) {
                $mol->setFio($fio);
            }
        }
        return $mol;
    }
}
