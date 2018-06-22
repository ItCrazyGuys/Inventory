<?php

namespace App\Repository\Storage_1C;

use App\Entity\Company\Office;
use App\Entity\Storage_1C\City1C;
use App\Entity\Storage_1C\Region1C;
use App\Entity\Storage_1C\Rooms1C;
use App\Entity\Storage_1C\RoomsType;
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
            $rooms1C->setType($em->getRepository('Storage_1C:RoomsType')->getEmptyType());
            $rooms1C->setCity1C($em->getRepository('Storage_1C:City1C')->getEmptyInstance());
            $em->persist($rooms1C);
        }
        return $rooms1C;
    }

    /**
     * @param string $roomsCode
     * @param string $roomsTitle
     * @param string $regionTitle
     * @param string $cityTitle
     * @param string $addressTitle
     * @return Rooms1C
     */
    public function getInstance(string $roomsCode, string $roomsTitle, string $regionTitle, string $cityTitle, string $addressTitle): Rooms1C
    {
        $region = self::getEntityManager()->getRepository(Region1C::class)->getByTitle($regionTitle);
        $city = self::getEntityManager()->getRepository(City1C::class)->getByTitleAndRegion($cityTitle, $region);
        $roomsType = self::getEntityManager()->getRepository(RoomsType::class)->getByAddress($addressTitle);

        $rooms1C = self::findOneBy(['roomsCode' => $roomsCode]);
        if (is_null($rooms1C)) {
            // create new Rooms1C
            $rooms1C = new Rooms1C();
            $rooms1C->setRoomsCode($roomsCode);
            $rooms1C->setTitle($roomsTitle);
            $rooms1C->setAddress($addressTitle);
            $rooms1C->setType($roomsType);
            $rooms1C->setCity1C($city);
            self::getEntityManager()->persist($rooms1C);
        } else {
            // update exist Rooms1C
            if ($rooms1C->getTitle() != $roomsTitle) {
                $rooms1C->setTitle($roomsTitle);
            }
            if ($rooms1C->getAddress() != $addressTitle) {
                $rooms1C->setAddress($addressTitle);
            }
            if ($rooms1C->getType()->getId() != $roomsType->getId()) {
                $rooms1C->setType($roomsType);
            }
            if ($rooms1C->getCity1C()->getId() != $city->getId()) {
                $rooms1C->setCity1C($city);
            }
        }
        return $rooms1C;
    }
}
