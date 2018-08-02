<?php

namespace App\Entity\Storage_1C;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\Storage_1C\InventoryItem1CRepository")
 * @ORM\Table(name="`inventoryItem1C`", schema="storage_1c")
 * @UniqueEntity("`inventoryNumber`")
 */
class InventoryItem1C
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(name="__id", type="bigint")
     */
    private $id;

    /**
     * @ORM\Column(name="`inventoryNumber`", type="string")
     * @Assert\NotNull()
     * @Assert\Length(max="255")
     */
    private $inventoryNumber;

    /**
     * @ORM\Column(name="`serialNumber`", type="string")
     * @Assert\Length(max="255")
     */
    private $serialNumber;

    /**
     * @ORM\Column(name="`dateOfRegistration`", type="datetime", nullable=true)
     * @Assert\DateTime()
     */
    private $dateOfRegistration;

    /**
     * @ORM\Column(name="`lastUpdate`", type="datetime")
     * @Assert\DateTime()
     */
    private $lastUpdate;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Storage_1C\InventoryItemCategory", fetch="EXTRA_LAZY")
     * @ORM\JoinColumn(name="__category_id", referencedColumnName="__id")
     */
    private $category;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Storage_1C\Nomenclature1C", fetch="EXTRA_LAZY")
     * @ORM\JoinColumn(name="__nomenclature_id", referencedColumnName="__id")
     */
    private $nomenclature;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Storage_1C\Mol", fetch="EXTRA_LAZY")
     * @ORM\JoinColumn(name="__mol_id", referencedColumnName="__id")
     */
    private $mol;

    /**
     * Офис в котором находилось данное оборудование на момент даты его регистрации
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Storage_1C\Rooms1C", fetch="EXTRA_LAZY")
     * @ORM\JoinColumn(name="__rooms_1c_id", referencedColumnName="__id")
     */
    private $rooms1C;




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
     * @param string $inventoryNumber
     */
    public function setInventoryNumber($inventoryNumber)
    {
        $this->inventoryNumber = $inventoryNumber;
    }

    /**
     * @return mixed
     */
    public function getSerialNumber()
    {
        return $this->serialNumber;
    }

    /**
     * @param string $serialNumber
     */
    public function setSerialNumber($serialNumber)
    {
        $this->serialNumber = $serialNumber;
    }

    /**
     * @return mixed
     */
    public function getDateOfRegistration()
    {
        return $this->dateOfRegistration;
    }

    /**
     * @param \DateTime $dateOfRegistration
     */
    public function setDateOfRegistration(\DateTime $dateOfRegistration)
    {
        $this->dateOfRegistration = $dateOfRegistration;
    }

    /**
     * @return mixed
     */
    public function getLastUpdate()
    {
        return $this->lastUpdate;
    }

    /**
     * @param \DateTime $lastUpdate
     */
    public function setLastUpdate(\DateTime $lastUpdate)
    {
        $this->lastUpdate = $lastUpdate;
    }

    /**
     * @return Nomenclature1C
     */
    public function getNomenclature()
    {
        return $this->nomenclature;
    }

    /**
     * @param Nomenclature1C $nomenclature
     */
    public function setNomenclature(Nomenclature1C $nomenclature)
    {
        $this->nomenclature = $nomenclature;
    }

    /**
     * @return Mol
     */
    public function getMol()
    {
        return $this->mol;
    }

    /**
     * @param Mol $mol
     */
    public function setMol(Mol $mol)
    {
        $this->mol = $mol;
    }

    /**
     * @return Rooms1C
     */
    public function getRooms1C()
    {
        return $this->rooms1C;
    }

    /**
     * @param Rooms1C $rooms1C
     */
    public function setRooms1C(Rooms1C $rooms1C)
    {
        $this->rooms1C = $rooms1C;
    }

    /**
     * @return InventoryItemCategory
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param InventoryItemCategory $category
     */
    public function setCategory(InventoryItemCategory $category)
    {
        $this->category = $category;
    }
}
