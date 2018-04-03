<?php

namespace App\Entity\Storage_1C;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\Storage_1C\Region1CRepository")
 * @ORM\Table(name="`regions1C`", schema="storage_1c")
 * @UniqueEntity("title")
 */
class Region1C
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(name="__id", type="bigint")
     */
    private $id;

    /**
     * @ORM\Column(type="string", unique=true)
     * @Assert\NotNull();
     * @Assert\Length(max="255")
     */
    private $title;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Storage_1C\City1C", mappedBy="region1C", fetch="EXTRA_LAZY")
     */
    private $cities1C;




    public function __construct()
    {
        $this->cities1C = new ArrayCollection();
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
     * @return ArrayCollection|City1C[]
     */
    public function getCities1C()
    {
        return $this->cities1C;
    }
}
