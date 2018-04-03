<?php

namespace App\Entity\Equipment;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\Equipment\VendorRepository")
 * @ORM\Table(name="vendors", schema="equipment")
 */
class Vendor
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
     * @ORM\OneToMany(targetEntity="App\Entity\Equipment\Software", mappedBy="vendor", fetch="EXTRA_LAZY")
     */
    private $software;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Equipment\Platform", mappedBy="vendor", fetch="EXTRA_LAZY")
     */
    private $platforms;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Equipment\Appliance", mappedBy="vendor", fetch="EXTRA_LAZY")
     */
    private $appliances;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Equipment\Module", mappedBy="vendor", fetch="EXTRA_LAZY")
     */
    private $modules;




    public function __construct()
    {
        $this->software = new ArrayCollection();
        $this->platforms = new ArrayCollection();
        $this->appliances = new ArrayCollection();
        $this->modules = new ArrayCollection();
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
     * @return ArrayCollection
     */
    public function getSoftware()
    {
        return $this->software;
    }

    /**
     * @return ArrayCollection
     */
    public function getPlatforms()
    {
        return $this->platforms;
    }

    /**
     * @return ArrayCollection
     */
    public function getAppliances()
    {
        return $this->appliances;
    }

    /**
     * @return ArrayCollection
     */
    public function getModules()
    {
        return $this->modules;
    }
}
