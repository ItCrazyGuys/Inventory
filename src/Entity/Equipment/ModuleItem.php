<?php

namespace App\Entity\Equipment;

use App\Entity\Company\Office;
use App\Entity\Storage_1C\InventoryItem1C;
use App\Entity\Storage_1C\Module1C;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\Equipment\ModuleItemRepository")
 * @ORM\Table(name="`moduleItems`", schema="equipment")
 */
class ModuleItem
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(name="__id", type="bigint")
     */
    private $id;

    /**
     * @ORM\Column(name="`serialNumber`", type="string")
     */
    private $serialNumber;

    /**
     * @ORM\Column(name="`inventoryNumber`", type="string")
     */
    private $inventoryNumber;

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
     * @ORM\Column(name="`notFound`", type="boolean")
     */
    private $notFound;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Equipment\Module", fetch="EXTRA_LAZY")
     * @ORM\JoinColumn(name="__module_id", referencedColumnName="__id")
     */
    private $module;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Equipment\Appliance", fetch="EXTRA_LAZY")
     * @ORM\JoinColumn(name="__appliance_id", referencedColumnName="__id")
     */
    private $appliance;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Company\Office", fetch="EXTRA_LAZY")
     * @ORM\JoinColumn(name="__location_id", referencedColumnName="__id")
     */
    private $location;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Storage_1C\Module1C", mappedBy="voiceModule", fetch="EXTRA_LAZY")
     */
    private $module1C;




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
    public function getSerialNumber()
    {
        return $this->serialNumber;
    }

    /**
     * @param string $serialNumber
     */
    public function setSerialNumber(string $serialNumber)
    {
        $this->serialNumber = $serialNumber;
    }

    /**
     * @return string
     */
    public function getInventoryNumber()
    {
        return $this->inventoryNumber;
    }

    /**
     * @param string $inventoryNumber
     */
    public function setInventoryNumber(string $inventoryNumber)
    {
        $this->inventoryNumber = $inventoryNumber;
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
     * @return mixed
     */
    public function getLastUpdate()
    {
        return $this->lastUpdate;
    }

    /**
     * @param mixed $lastUpdate
     */
    public function setLastUpdate($lastUpdate)
    {
        $this->lastUpdate = $lastUpdate;
    }

    /**
     * @return bool
     */
    public function getInUse()
    {
        return $this->inUse;
    }

    /**
     * @param bool $inUse
     */
    public function setInUse(bool $inUse)
    {
        $this->inUse = $inUse;
    }

    /**
     * @return bool
     */
    public function getNotFound()
    {
        return $this->notFound;
    }

    /**
     * @param bool $notFound
     */
    public function setNotFound(bool $notFound)
    {
        $this->notFound = $notFound;
    }

    /**
     * @return Module
     */
    public function getModule()
    {
        return $this->module;
    }

    /**
     * @param Module $module
     */
    public function setModule(Module $module)
    {
        $this->module = $module;
    }

    /**
     * @return Appliance
     */
    public function getAppliance()
    {
        return $this->appliance;
    }

    /**
     * @param Appliance $appliance
     */
    public function setAppliance(Appliance $appliance)
    {
        $this->appliance = $appliance;
    }

    /**
     * @return Office
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
     * @return Module1C
     */
    public function getModule1C()
    {
        return $this->module1C;
    }
}
