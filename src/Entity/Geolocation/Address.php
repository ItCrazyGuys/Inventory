<?php

namespace App\Entity\Geolocation;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\Geolocation\AddressRepository")
 * @ORM\Table(name="addresses", schema="geolocation")
 */
class Address
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(name="__id", type="bigint")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $address;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Company\Office", mappedBy="address", fetch="EXTRA_LAZY")
     */
    private $office;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Geolocation\City", fetch="EXTRA_LAZY")
     * @ORM\JoinColumn(name="__city_id", referencedColumnName="__id")
     */
    private $city;




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
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param string $address
     */
    public function setAddress(string $address)
    {
        $this->address = $address;
    }

    /**
     * @return mixed
     */
    public function getOffice()
    {
        return $this->office;
    }

    /**
     * @return mixed
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param City $city
     */
    public function setCity(City $city)
    {
        $this->city = $city;
    }

}
