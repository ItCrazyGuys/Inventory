<?php
namespace App\Entity\Storage_1C;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table(name="foreing_1c", schema="storage_1c")
 */
class Foreing1C
{
    /**
     * @ORM\Id()
     * @ORM\Column(name="__id", type="bigint")
     */
    private $id;

    /**
     * @ORM\Column(name="inventory_number", type="string")
     */
    private $inventoryNumber;

    /**
     * @ORM\Column(name="serial_number", type="string")
     */
    private $serialNumber;

    /**
     * @ORM\Column(name="type_of_nomenclature", type="string")
     */
    private $nomenclatureType;

    /**
     * @ORM\Column(name="nomenclature", type="string")
     */
    private $nomenclature;

    /**
     * @ORM\Column(name="date_of_registration", type="string")
     */
    private $dateOfRegistration;

    /**
     * @ORM\Column(name="rooms_code", type="string")
     */
    private $roomsCode;

    /**
     * @ORM\Column(name="rooms_address", type="string")
     */
    private $roomsAddress;

    /**
     * @ORM\Column(name="mol", type="string")
     */
    private $mol;

    /**
     * @ORM\Column(name="mol_tab_number", type="string")
     */
    private $molTabNumber;

    /**
     * @ORM\Column(name="inventory_user", type="string")
     */
    private $inventoryUser;

    /**
     * @ORM\Column(name="inventory_user_tab_number", type="string")
     */
    private $inventoryUserTabNumber;

    /**
     * @ORM\Column(name="last_update", type="string")
     */
    private $lastUpdate;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getInventoryNumber()
    {
        return $this->inventoryNumber;
    }

    /**
     * @return mixed
     */
    public function getSerialNumber()
    {
        return $this->serialNumber;
    }

    /**
     * @return mixed
     */
    public function getNomenclatureType()
    {
        return $this->nomenclatureType;
    }

    /**
     * @return mixed
     */
    public function getNomenclature()
    {
        return $this->nomenclature;
    }

    /**
     * @return mixed
     */
    public function getDateOfRegistration()
    {
        return $this->dateOfRegistration;
    }

    /**
     * @return mixed
     */
    public function getRoomsCode()
    {
        return $this->roomsCode;
    }

    /**
     * @return mixed
     */
    public function getRoomsAddress()
    {
        return $this->roomsAddress;
    }

    /**
     * @return mixed
     */
    public function getMol()
    {
        return $this->mol;
    }

    /**
     * @return mixed
     */
    public function getMolTabNumber()
    {
        return $this->molTabNumber;
    }

    /**
     * @return mixed
     */
    public function getInventoryUser()
    {
        return $this->inventoryUser;
    }

    /**
     * @return mixed
     */
    public function getInventoryUserTabNumber()
    {
        return $this->inventoryUserTabNumber;
    }

    /**
     * @return mixed
     */
    public function getLastUpdate()
    {
        return $this->lastUpdate;
    }
}
