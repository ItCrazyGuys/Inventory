<?php

namespace App\Entity\Equipment;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="platforms", schema="equipment")
 */
class Platform
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
     * @ORM\Column(name="`isHW`", type="boolean")
     */
    private $isHW;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Equipment\Vendor", fetch="EXTRA_LAZY")
     * @ORM\JoinColumn(name="__vendor_id", referencedColumnName="__id")
     */
    private $vendor;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Equipment\PlatformItem", mappedBy="platform", fetch="EXTRA_LAZY")
     */
    private $platformItems;




    public function __construct()
    {
        $this->platformItems = new ArrayCollection();
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
     * @return boolean
     */
    public function getisHW()
    {
        return $this->isHW;
    }

    /**
     * @param boolean $isHW
     */
    public function setIsHW(bool $isHW)
    {
        $this->isHW = $isHW;
    }

    /**
     * @return Vendor
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
    public function getPlatformItems()
    {
        return $this->platformItems;
    }
}
