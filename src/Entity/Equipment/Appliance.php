<?php

namespace App\Entity\Equipment;

use App\Entity\Company\Office;
use App\Entity\Storage_1C\Appliance1C;
use App\Entity\Storage_1C\InventoryItem1C;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\DateTime;

/**
 * @ORM\Entity(repositoryClass="App\Repository\Equipment\ApplianceRepository")
 * @ORM\Table(name="appliances", schema="equipment")
 */
class Appliance
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(name="__id", type="bigint")
     */
    private $id;

    /**
     * @ORM\Column(type="json")
     */
    private $details;

    /**
     * @ORM\Column(type="text")
     */
    private $comment;

    /**
     * @ORM\Column(name="`lastUpdate`", type="datetimetz")
     */
    private $lastUpdate;

    /**
     * @ORM\Column(name="`inUse`", type="boolean")
     */
    private $inUse;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Equipment\SoftwareItems", fetch="EXTRA_LAZY")
     * @ORM\JoinColumn(name="__software_item_id", referencedColumnName="__id")
     */
    private $software;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Equipment\PlatformItem", fetch="EXTRA_LAZY")
     * @ORM\JoinColumn(name="__platform_item_id", referencedColumnName="__id")
     */
    private $platform;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Equipment\Vendor", fetch="EXTRA_LAZY")
     * @ORM\JoinColumn(name="__vendor_id", referencedColumnName="__id")
     */
    private $vendor;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Company\Office", fetch="EXTRA_LAZY")
     * @ORM\JoinColumn(name="__location_id", referencedColumnName="__id")
     */
    private $location;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Equipment\ModuleItem", mappedBy="appliance", fetch="EXTRA_LAZY")
     */
    private $modules;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Equipment\ApplianceType", fetch="EXTRA_LAZY")
     * @ORM\JoinColumn(name="__type_id", referencedColumnName="__id")
     */
    private $type;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Equipment\Cluster", fetch="EXTRA_LAZY")
     * @ORM\JoinColumn(name="__cluster_id", referencedColumnName="__id")
     */
    private $cluster;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Equipment\PhoneInfo", mappedBy="phone", fetch="EXTRA_LAZY")
     */
    private $phoneInfo;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Equipment\DataPort", mappedBy="appliance", fetch="EXTRA_LAZY")
     */
    private $dataPorts;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Storage_1C\Appliance1C", mappedBy="voiceAppliance", fetch="EXTRA_LAZY")
     */
    private $appliance1C;




    public function __construct()
    {
        $this->modules = new ArrayCollection();
        $this->dataPorts = new ArrayCollection();
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
    public function getDetails()
    {
        return $this->details;
    }

    /**
     * @param mixed $details
     */
    public function setDetails($details)
    {
        $this->details = $details;
    }

    /**
     * @return mixed
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * @param string $comment
     */
    public function setComment(string  $comment)
    {
        $this->comment = $comment;
    }

    /**
     * @return mixed
     */
    public function getLastUpdate()
    {
        return $this->lastUpdate;
    }

    /**
     * @param DateTime $lastUpdate
     */
    public function setLastUpdate($lastUpdate)
    {
        $this->lastUpdate = $lastUpdate;
    }

    /**
     * @return mixed
     */
    public function getInUse()
    {
        return $this->inUse;
    }

    /**
     * @param boolean $inUse
     */
    public function setInUse($inUse)
    {
        $this->inUse = $inUse;
    }

    /**
     * @return mixed
     */
    public function getSoftware()
    {
        return $this->software;
    }

    /**
     * @param SoftwareItems $software
     */
    public function setSoftware(SoftwareItems $software)
    {
        $this->software = $software;
    }

    /**
     * @return mixed
     */
    public function getPlatform()
    {
        return $this->platform;
    }

    /**
     * @param PlatformItem $platform
     */
    public function setPlatform(PlatformItem $platform)
    {
        $this->platform = $platform;
    }

    /**
     * @return mixed
     */
    public function getVendor()
    {
        return $this->vendor;
    }

    /**
     * @param Vendor $vendor
     */
    public function setVendor(Vendor $vendor)
    {
        $this->vendor = $vendor;
    }

    /**
     * @return ArrayCollection
     */
    public function getModules()
    {
        return $this->modules;
    }

    /**
     * @return mixed
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * @param Office $location
     */
    public function setLocation(Office $location)
    {
        $this->location = $location;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param ApplianceType $type
     */
    public function setType(ApplianceType $type)
    {
        $this->type = $type;
    }

    /**
     * @return mixed
     */
    public function getCluster()
    {
        return $this->cluster;
    }

    /**
     * @param Cluster $cluster
     */
    public function setCluster(Cluster $cluster)
    {
        $this->cluster = $cluster;
    }

    /**
     * @return mixed
     */
    public function getPhoneInfo()
    {
        return $this->phoneInfo;
    }

    /**
     * @return ArrayCollection
     */
    public function getDataPorts()
    {
        return $this->dataPorts;
    }

    /**
     * @return Appliance1C
     */
    public function getAppliance1C()
    {
        return $this->appliance1C;
    }
}
