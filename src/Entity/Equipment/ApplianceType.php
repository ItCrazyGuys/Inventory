<?php

namespace App\Entity\Equipment;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="`applianceTypes`", schema="equipment")
 */
class ApplianceType
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
    private $type;

    /**
     * @ORM\Column(name="`sortOrder`", type="integer")
     */
    private $sortOrder;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Equipment\Appliance", mappedBy="type", fetch="EXTRA_LAZY")
     */
    private $appliances;




    public function __construct()
    {
        $this->appliances = new ArrayCollection();
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
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType(string $type)
    {
        $this->type = $type;
    }

    /**
     * @return mixed
     */
    public function getSortOrder()
    {
        return $this->sortOrder;
    }

    /**
     * @param int $sortOrder
     */
    public function setSortOrder($sortOrder)
    {
        $this->sortOrder = $sortOrder;
    }

    /**
     * @return ArrayCollection
     */
    public function getAppliances()
    {
        return $this->appliances;
    }
}
