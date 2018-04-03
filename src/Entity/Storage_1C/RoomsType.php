<?php

namespace App\Entity\Storage_1C;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\Storage_1C\RoomsTypeRepository")
 * @ORM\Table(name="`roomsTypes`", schema="storage_1c")
 * @UniqueEntity("type")
 */
class RoomsType
{
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
     * @ORM\OneToMany(targetEntity="App\Entity\Storage_1C\Rooms1C", mappedBy="type", fetch="EXTRA_LAZY")
     */
    private $rooms;




    public function __construct()
    {
        $this->rooms = new ArrayCollection();
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
     * @return ArrayCollection|Rooms1C[]
     */
    public function getRooms()
    {
        return $this->rooms;
    }
}
