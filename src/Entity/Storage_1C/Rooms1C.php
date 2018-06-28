<?php

namespace App\Entity\Storage_1C;

use App\Entity\Company\Office;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\Storage_1C\Rooms1CRepository")
 * @ORM\Table(name="`rooms1C`", schema="storage_1c")
 * @UniqueEntity("roomsCode")
 */
class Rooms1C
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(name="__id", type="bigint")
     */
    private $id;

    /**
     * @ORM\Column(name="`roomsCode`", type="string", unique=true)
     * @Assert\NotNull()
     * @Assert\Length(max="255")
     */
    private $roomsCode;

    /**
     * @ORM\Column(type="text")
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     */
    private $address;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Storage_1C\InventoryItem1C", mappedBy="rooms1C", fetch="EXTRA_LAZY")
     */
    private $inventoryItems1C;

    /**
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Company\Office", fetch="EXTRA_LAZY")
     * @ORM\JoinColumn(name="__voice_office_id", referencedColumnName="__id", nullable=true)
     */
    private $voiceOffice;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Storage_1C\Mol", mappedBy="rooms1C", fetch="EXTRA_LAZY")
     */
    private $mols;




    public function __construct()
    {
        $this->inventoryItems1C = new ArrayCollection();
        $this->mols = new ArrayCollection();
    }

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
    public function getRoomsCode()
    {
        return $this->roomsCode;
    }

    /**
     * @param mixed $roomsCode
     */
    public function setRoomsCode($roomsCode)
    {
        $this->roomsCode = $roomsCode;
    }

    /**
     * @return mixed
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param mixed $address
     */
    public function setAddress($address)
    {
        $this->address = $address;
    }

    /**
     * @return ArrayCollection|InventoryItem1C[]
     */
    public function getInventoryItems1C()
    {
        return $this->inventoryItems1C;
    }

    /**
     * @return ArrayCollection|Mol[]
     */
    public function getMols()
    {
        return $this->mols;
    }

    public function addMol(Mol $mol)
    {
        if ($this->mols->contains($mol)) {
            return;
        }
        $this->mols[] = $mol;
        $mol->addOffice1C($this);
    }

    public function removeMol(Mol $mol)
    {
        if (!$this->mols->contains($mol)) {
            return;
        }
        $this->mols->removeElement($mol);
        $mol->removeOffice1C($this);
    }

    /**
     * @return Office
     */
    public function getVoiceOffice()
    {
        return $this->voiceOffice;
    }

    /**
     * @param Office $voiceOffice
     */
    public function setVoiceOffice($voiceOffice)
    {
        $this->voiceOffice = $voiceOffice;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }
}

