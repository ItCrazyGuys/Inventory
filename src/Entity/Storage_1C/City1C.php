<?php

namespace App\Entity\Storage_1C;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\Storage_1C\City1CRepository")
 * @ORM\Table(name="`cities1C`", schema="storage_1c")
 * @UniqueEntity(fields={"title", "region1C"})
 */
class City1C
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(name="__id", type="bigint")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     * @Assert\Length(max="255")
     */
    private $title;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Storage_1C\Region1C", fetch="EXTRA_LAZY")
     * @ORM\JoinColumn(name="__region_1c_id", referencedColumnName="__id")
     */
    private $region1C;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Storage_1C\Rooms1C", mappedBy="city1C", fetch="EXTRA_LAZY")
     */
    private $rooms1C;




    public function __construct()
    {
        $this->rooms1C = new ArrayCollection();
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
     * @return Region1C
     */
    public function getRegion1C()
    {
        return $this->region1C;
    }

    /**
     * @param Region1C $region1C
     */
    public function setRegion1C(Region1C $region1C)
    {
        $this->region1C = $region1C;
    }

    /**
     * @return ArrayCollection|Rooms1C[]
     */
    public function getRooms1C()
    {
        return $this->rooms1C;
    }
}
