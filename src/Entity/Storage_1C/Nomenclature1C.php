<?php

namespace App\Entity\Storage_1C;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\Storage_1C\Nomenclature1CRepository")
 * @ORM\Table(name="`nomenclature1C`", schema="storage_1c")
 * @UniqueEntity("title")
 */
class Nomenclature1C
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(name="__id", type="bigint")
     */
    private $id;

    /**
     * @ORM\Column(type="text", unique=true)
     * @Assert\NotNull()
     */
    private $title;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Storage_1C\NomenclatureType", fetch="EXTRA_LAZY")
     * @ORM\JoinColumn(name="__type_id", referencedColumnName="__id")
     */
    private $type;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Storage_1C\InventoryItem1C", mappedBy="nomenclature", fetch="EXTRA_LAZY")
     */
    private $inventoryItems1C;




    public function __construct()
    {
        $this->inventoryItems1C = new ArrayCollection();
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

    /**
     * @return NomenclatureType
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param NomenclatureType $type
     */
    public function setType(NomenclatureType $type)
    {
        $this->type = $type;
    }

    /**
     * @return ArrayCollection|InventoryItem1C[]
     */
    public function getInventoryItems1C()
    {
        return $this->inventoryItems1C;
    }
}
