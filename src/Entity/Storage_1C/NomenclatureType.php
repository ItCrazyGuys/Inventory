<?php

namespace App\Entity\Storage_1C;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\Storage_1C\NomenclatureTypeRepository")
 * @ORM\Table(name="`nomenclatureTypes`", schema="storage_1c")
 * @UniqueEntity("type")
 */
class NomenclatureType
{
    const TYPE_MBP = 'МБП';
    const TYPE_OC = 'ОС';



    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(name="__id", type="bigint")
     */
    private $id;

    /**
     * @ORM\Column(type="string", unique=true)
     * @Assert\NotNull()
     * @Assert\Length(max="255")
     */
    private $type;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Storage_1C\Nomenclature1C", mappedBy="type", fetch="EXTRA_LAZY")
     */
    private $nomenclature;




    public function __construct()
    {
        $this->nomenclature = new ArrayCollection();
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
     * @param mixed $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return ArrayCollection|Nomenclature1C[]
     */
    public function getNomenclature()
    {
        return $this->nomenclature;
    }
}