<?php

namespace App\Entity\Equipment;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\Equipment\PlatformItemRepository")
 * @ORM\Table(name="`platformItems`", schema="equipment")
 */
class PlatformItem
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
     * @ORM\Column(name="`serialNumberAlt`", type="string")
     */
    private $serialNumberAlt;

    /**
     * @ORM\Column(name="`inventoryNumber`", type="string")
     */
    private $inventoryNumber;

    /**
     * @ORM\Column(type="string")
     */
    private $version;

    /**
     * @ORM\Column(type="json")
     */
    private $details;

    /**
     * @ORM\Column(type="text")
     */
    private $comment;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Equipment\Platform", fetch="EXTRA_LAZY")
     * @ORM\JoinColumn(name="__platform_id", referencedColumnName="__id")
     */
    private $platform;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Equipment\Appliance", mappedBy="platform", fetch="EXTRA_LAZY")
     */
    private $appliance;




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
     * @return mixed
     */
    public function getSerialNumberAlt()
    {
        return $this->serialNumberAlt;
    }

    /**
     * @param mixed $serialNumberAlt
     */
    public function setSerialNumberAlt($serialNumberAlt): void
    {
        $this->serialNumberAlt = $serialNumberAlt;
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
     * @return string
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * @param string $version
     */
    public function setVersion(string $version)
    {
        $this->version = $version;
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
     * @return Platform
     */
    public function getPlatform()
    {
        return $this->platform;
    }

    /**
     * @param Platform $platform
     */
    public function setPlatform(Platform $platform)
    {
        $this->platform = $platform;
    }

    /**
     * @return Appliance
     */
    public function getAppliance()
    {
        return $this->appliance;
    }
}
