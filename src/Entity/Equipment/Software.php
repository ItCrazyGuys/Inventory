<?php

namespace App\Entity\Equipment;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="software", schema="equipment")
 */
class Software
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
     * @ORM\ManyToOne(targetEntity="App\Entity\Equipment\Vendor", fetch="EXTRA_LAZY")
     * @ORM\JoinColumn(name="__vendor_id", referencedColumnName="__id")
     */
    private $vendor;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Equipment\SoftwareItems", mappedBy="software", fetch="EXTRA_LAZY")
     */
    private $softwareItems;




    public function __construct()
    {
        $this->softwareItems = new ArrayCollection();
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
    public function setTitle($title)
    {
        $this->title = $title;
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
    public function getSoftwareItems()
    {
        return $this->softwareItems;
    }
}
