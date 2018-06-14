<?php

namespace App\Entity\View;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\View\DevAppliance1CRepository")
 * @ORM\Table(name="dev_appliance1c", schema="view")
 */
class DevAppliance1C implements IInventoryItem1C
{
    /**
     * @ORM\Column(name="`appliance1C_id`", type="bigint")
     */
    private $appliance1C_id;

    /**
     * @ORM\Column(name="`appliance_id`", type="bigint")
     */
    private $appliance_id;

    /**
     * @ORM\Column(name="`appliance_serialNumber`", type="string")
     */
    private $appliance_serialNumber;

    /**
     * @ORM\Id
     * @ORM\Column(name="`invItem_id`", type="bigint")
     */
    private $invItem_id;

    /**
     * @ORM\Column(name="`invItem_inventoryNumber`", type="string")
     */
    private $invItem_inventoryNumber;

    /**
     * @ORM\Column(name="`invItem_serialNumber`", type="string")
     */
    private $invItem_serialNumber;

    /**
     * @ORM\Column(name="`invItem_dateOfRegistration`", type="datetime")
     */
    private $invItem_dateOfRegistration;

    /**
     * @ORM\Column(name="`invItem_lastUpdate`", type="datetime")
     */
    private $invItem_lastUpdate;

    /**
     * @ORM\Column(name="`mol_id`", type="bigint")
     */
    private $mol_id;

    /**
     * @ORM\Column(name="`mol_fio`", type="string")
     */
    private $mol_fio;

    /**
     * @ORM\Column(name="`mol_tabNumber`", type="integer")
     */
    private $mol_tabNumber;

    /**
     * @ORM\Column(name="`nomenclature1C_id`", type="bigint")
     */
    private $nomenclature1C_id;

    /**
     * @ORM\Column(name="`nomenclature1C_title`", type="string")
     */
    private $nomenclature1C_title;

    /**
     * @ORM\Column(name="`nomenclatureType_id`", type="bigint")
     */
    private $nomenclatureType_id;

    /**
     * @ORM\Column(name="`nomenclatureType_type`", type="string")
     */
    private $nomenclatureType_type;

    /**
     * @ORM\Column(name="`invItemCategory_id`", type="bigint")
     */
    private $invItemCategory_id;

    /**
     * @ORM\Column(name="`invItemCategory_title`", type="string")
     */
    private $invItemCategory_title;

    /**
     * @ORM\Column(name="`rooms1C_id`", type="bigint")
     */
    private $rooms1C_id;

    /**
     * @ORM\Column(name="`rooms1C_roomsCode`", type="string")
     */
    private $rooms1C_roomsCode;

    /**
     * @ORM\Column(name="`rooms1C_address`", type="string")
     */
    private $rooms1C_address;

    /**
     * @ORM\Column(name="`office_id`", type="bigint")
     */
    private $office_id;

    /**
     * @ORM\Column(name="`office_lotusId`", type="integer")
     */
    private $office_lotusId;

    /**
     * @ORM\Column(name="`roomsTypes_id`", type="bigint")
     */
    private $roomsTypes_id;

    /**
     * @ORM\Column(name="`roomsTypes_type`", type="string")
     */
    private $roomsTypes_type;

    /**
     * @ORM\Column(name="`city1C_id`", type="bigint")
     */
    private $city1C_id;

    /**
     * @ORM\Column(name="`city1C_title`", type="string")
     */
    private $city1C_title;

    /**
     * @ORM\Column(name="`region1C_id`", type="bigint")
     */
    private $region1C_id;

    /**
     * @ORM\Column(name="`region1C_title`", type="string")
     */
    private $region1C_title;




    /**
     * @return mixed
     */
    public function getAppliance1CId()
    {
        return $this->appliance1C_id;
    }

    /**
     * @return mixed
     */
    public function getApplianceId()
    {
        return $this->appliance_id;
    }

    /**
     * @return mixed
     */
    public function getApplianceSerialNumber()
    {
        return $this->appliance_serialNumber;
    }

    /**
     * @return mixed
     */
    public function getInvItemId()
    {
        return $this->invItem_id;
    }

    /**
     * @return mixed
     */
    public function getInvItemInventoryNumber()
    {
        return $this->invItem_inventoryNumber;
    }

    /**
     * @return mixed
     */
    public function getInvItemSerialNumber()
    {
        return $this->invItem_serialNumber;
    }

    /**
     * @return mixed
     */
    public function getInvItemDateOfRegistration()
    {
        return $this->invItem_dateOfRegistration;
    }

    /**
     * @return mixed
     */
    public function getInvItemLastUpdate()
    {
        return $this->invItem_lastUpdate;
    }

    /**
     * @return mixed
     */
    public function getMolId()
    {
        return $this->mol_id;
    }

    /**
     * @return mixed
     */
    public function getMolFio()
    {
        return $this->mol_fio;
    }

    /**
     * @return mixed
     */
    public function getMolTabNumber()
    {
        return $this->mol_tabNumber;
    }

    /**
     * @return mixed
     */
    public function getNomenclature1CId()
    {
        return $this->nomenclature1C_id;
    }

    /**
     * @return mixed
     */
    public function getNomenclature1CTitle()
    {
        return $this->nomenclature1C_title;
    }

    /**
     * @return mixed
     */
    public function getNomenclatureTypeId()
    {
        return $this->nomenclatureType_id;
    }

    /**
     * @return mixed
     */
    public function getNomenclatureTypeType()
    {
        return $this->nomenclatureType_type;
    }

    /**
     * @return mixed
     */
    public function getInvItemCategoryId()
    {
        return $this->invItemCategory_id;
    }

    /**
     * @return mixed
     */
    public function getInvItemCategoryTitle()
    {
        return $this->invItemCategory_title;
    }

    /**
     * @return mixed
     */
    public function getRooms1CId()
    {
        return $this->rooms1C_id;
    }

    /**
     * @return mixed
     */
    public function getRooms1CRoomsCode()
    {
        return $this->rooms1C_roomsCode;
    }

    /**
     * @return mixed
     */
    public function getRooms1CAddress()
    {
        return $this->rooms1C_address;
    }

    /**
     * @return mixed
     */
    public function getOfficeId()
    {
        return $this->office_id;
    }

    /**
     * @return mixed
     */
    public function getOfficeLotusId()
    {
        return $this->office_lotusId;
    }

    /**
     * @return mixed
     */
    public function getRoomsTypesId()
    {
        return $this->roomsTypes_id;
    }

    /**
     * @return mixed
     */
    public function getRoomsTypesType()
    {
        return $this->roomsTypes_type;
    }

    /**
     * @return mixed
     */
    public function getCity1CId()
    {
        return $this->city1C_id;
    }

    /**
     * @return mixed
     */
    public function getCity1CTitle()
    {
        return $this->city1C_title;
    }

    /**
     * @return mixed
     */
    public function getRegion1CId()
    {
        return $this->region1C_id;
    }

    /**
     * @return mixed
     */
    public function getRegion1CTitle()
    {
        return $this->region1C_title;
    }
}
