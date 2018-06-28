<?php

namespace App\Repository\Storage_1C;

use App\Entity\Company\Office;
use App\Entity\Storage_1C\Rooms1C;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class Rooms1CRepository extends ServiceEntityRepository
{
    private const EMPTY = '';


    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Rooms1C::class);
    }

    /**
     * @return Rooms1C
     */
    public function getEmptyInstance(): Rooms1C
    {
        $rooms1C = self::findOneBy(['roomsCode' => self::EMPTY]);
        if (is_null($rooms1C)) {
            $em = self::getEntityManager();
            $rooms1C = new Rooms1C();
            $rooms1C->setRoomsCode(self::EMPTY);
            $rooms1C->setAddress(self::EMPTY);
            $em->persist($rooms1C);
        }
        return $rooms1C;
    }

    /**
     * @param string $roomsCode
     * @param string $title
     * @param string $address
     * @return Rooms1C
     */
    public function getInstance(string $roomsCode, string $title, string $address): Rooms1C
    {
        $rooms1C = self::findOneBy(['roomsCode' => $roomsCode]);
        if (is_null($rooms1C)) {
            // create new Rooms1C
            $rooms1C = new Rooms1C();
            $rooms1C->setRoomsCode($roomsCode);
            $rooms1C->setTitle($title);
            $rooms1C->setAddress($address);
            self::getEntityManager()->persist($rooms1C);
        } else {
            // update exist Rooms1C
            if ($rooms1C->getTitle() != $title) {
                $rooms1C->setTitle($title);
            }
            if ($rooms1C->getAddress() != $address) {
                $rooms1C->setAddress($address);
            }
        }
        return $rooms1C;
    }
}
