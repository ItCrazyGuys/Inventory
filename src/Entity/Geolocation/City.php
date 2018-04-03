<?php

namespace App\Entity\Geolocation;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\Geolocation\CityRepository")
 * @ORM\Table(name="cities", schema="geolocation")
 */
class City
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
     * @ORM\Column(name="`diallingCode`", type="string")
     */
    private $diallingCode;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Geolocation\Address", mappedBy="city", fetch="EXTRA_LAZY")
     */
    private $addresses;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Geolocation\Region", fetch="EXTRA_LAZY")
     * @ORM\JoinColumn(name="__region_id", referencedColumnName="__id")
     */
    private $region;




    public function __construct()
    {
        $this->addresses = new ArrayCollection();
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
     * @param string $title
     */
    public function setTitle(string $title)
    {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getDiallingCode()
    {
        return $this->diallingCode;
    }

    /**
     * @param string $diallingCode
     */
    public function setDiallingCode(string $diallingCode)
    {
        $this->diallingCode = $diallingCode;
    }

    /**
     * @return ArrayCollection
     */
    public function getAddresses()
    {
        return $this->addresses;
    }

    /**
     * @return mixed
     */
    public function getRegion()
    {
        return $this->region;
    }

    /**
     * @param Region $region
     */
    public function setRegion(Region $region)
    {
        $this->region = $region;
    }
}
