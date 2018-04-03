<?php

namespace App\Entity\Equipment;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="modules", schema="equipment")
 */
class Module
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
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Equipment\Vendor", fetch="EXTRA_LAZY")
     * @ORM\JoinColumn(name="__vendor_id", referencedColumnName="__id")
     */
    private $vendor;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Equipment\ModuleItem", mappedBy="module", fetch="EXTRA_LAZY")
     */
    private $moduleItems;




    public function __construct()
    {
        $this->moduleItems = new ArrayCollection();
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
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description)
    {
        $this->description = $description;
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
    public function getModuleItems()
    {
        return $this->moduleItems;
    }
}
