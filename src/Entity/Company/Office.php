<?php

namespace App\Entity\Company;

use App\Entity\Geolocation\Address;
use App\Entity\Network\Network;
use App\Entity\Storage_1C\Rooms1C;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="offices", schema="company")
 */
class Office
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(name="__id", type="bigint")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     */
    private $title;

    /**
     * @ORM\Column(name="`lotusId`", type="integer")
     */
    private $lotusId;

    /**
     * @ORM\Column(type="json")
     */
    private $details;

    /**
     * @ORM\Column(type="text")
     */
    private $comment;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Equipment\ModuleItem", mappedBy="location", fetch="EXTRA_LAZY")
     */
    private $modules;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Equipment\Appliance", mappedBy="location", fetch="EXTRA_LAZY")
     */
    private $appliances;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Company\OfficeStatus", fetch="LAZY")
     * @ORM\JoinColumn(name="__office_status_id", referencedColumnName="__id")
     */
    private $status;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Geolocation\Address", fetch="LAZY")
     * @ORM\JoinColumn(name="__address_id", referencedColumnName="__id")
     */
    private $address;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Network\Network", mappedBy="location", fetch="EXTRA_LAZY")
     */
    private $networks;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Storage_1C\Rooms1C", mappedBy="voiceOffice", fetch="EXTRA_LAZY")
     */
    private $rooms1C;




    public function __construct()
    {
        $this->modules = new ArrayCollection();
        $this->appliances = new ArrayCollection();
        $this->networks = new ArrayCollection();
        $this->rooms1C = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title)
    {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getLotusId()
    {
        return $this->lotusId;
    }

    /**
     * @param int $lotusId
     */
    public function setLotusId($lotusId)
    {
        $this->lotusId = $lotusId;
    }

    /**
     * @return mixed
     */
    public function getDetails()
    {
        return $this->details;
    }

    /**
     * @param $details
     */
    public function setDetails($details)
    {
        $this->details = $details;
    }

    /**
     * @return string
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * @param string $comment
     */
    public function setComment(string $comment)
    {
        $this->comment = $comment;
    }

    /**
     * @return ArrayCollection
     */
    public function getModules()
    {
        return $this->modules;
    }

    /**
     * @return ArrayCollection
     */
    public function getAppliances()
    {
        return $this->appliances;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param OfficeStatus $status
     */
    public function setStatus(OfficeStatus $status)
    {
        $this->status = $status;
    }

    /**
     * @return mixed
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param Address $address
     */
    public function setAddress(Address $address)
    {
        $this->address = $address;
    }

    /**
     * @return ArrayCollection|Network[]
     */
    public function getNetworks()
    {
        return $this->networks;
    }

    /**
     * @return ArrayCollection|Rooms1C[]
     */
    public function getRooms1C()
    {
        return $this->rooms1C;
    }

    public function addRooms1C(Rooms1C $rooms1C)
    {
        if ($this->rooms1C->contains($rooms1C)) {
            return;
        }
        $this->rooms1C[] = $rooms1C;
    }

    public function removeRooms1C(Rooms1C $rooms1C)
    {
        if (!$this->rooms1C->contains($rooms1C)) {
            return;
        }
        $this->rooms1C->removeElement($rooms1C);
    }
}
