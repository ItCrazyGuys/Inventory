<?php

namespace App\Repository\Storage_1C;

use App\Entity\Storage_1C\RoomsType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class RoomsTypeRepository extends ServiceEntityRepository
{
    private const EMPTY = '';
    private const OFFICE = 'office';
    private const STOREHOUSE = 'storehouse';


    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, RoomsType::class);
    }

    /**
     * @return RoomsType
     */
    public function getEmptyType(): RoomsType
    {
        $roomsType = self::findOneBy(['type' => self::EMPTY]);
        if (is_null($roomsType)) {
            $roomsType = new RoomsType();
            $roomsType->setType(self::EMPTY);
            self::getEntityManager()->persist($roomsType);
        }
        return $roomsType;
    }

    /**
     * @return RoomsType
     */
    public function getOfficeType(): RoomsType
    {
        $roomsType = self::findOneBy(['type' => self::OFFICE]);
        if (is_null($roomsType)) {
            $roomsType = new RoomsType();
            $roomsType->setType(self::OFFICE);
            self::getEntityManager()->persist($roomsType);
        }
        return $roomsType;
    }

    /**
     * @return RoomsType
     */
    public function getStorehouseType(): RoomsType
    {
        $roomsType = self::findOneBy(['type' => self::STOREHOUSE]);
        if (is_null($roomsType)) {
            $roomsType = new RoomsType();
            $roomsType->setType(self::STOREHOUSE);
            self::getEntityManager()->persist($roomsType);
        }
        return $roomsType;
    }

    /**
     * @param string $address
     * @return RoomsType
     */
    public function getByAddress(string $address): RoomsType
    {
        $storeHousePattern = 'склад';

        $roomsType = null;
        if ($address == self::EMPTY) {
            $roomsType = $this->getEmptyType();
        } else {
            $result = preg_match('~' . $storeHousePattern . '~', mb_strtolower($address));
            if ($result == 1) {
                $roomsType = $this->getStorehouseType();
            } else {
                $roomsType = $this->getOfficeType();
            }
        }
        return $roomsType;
    }
}
