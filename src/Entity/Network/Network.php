<?php

namespace App\Entity\Network;

use App\Entity\Company\Office;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="networks", schema="network")
 */
class Network
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
    private $address;

    /**
     * @ORM\Column(type="text")
     */
    private $comment;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Equipment\DataPort", mappedBy="network", fetch="EXTRA_LAZY")
     */
    private $hosts;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Network\Vlan", fetch="EXTRA_LAZY")
     * @ORM\JoinColumn(name="__vlan_id", referencedColumnName="__id")
     */
    private $vlan;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Network\Vrf", fetch="EXTRA_LAZY")
     * @ORM\JoinColumn(name="__vrf_id", referencedColumnName="__id")
     */
    private $vrf;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Company\Office", fetch="EXTRA_LAZY")
     * @ORM\JoinColumn(name="__location_id", referencedColumnName="__id")
     */
    private $location;




    public function __construct()
    {
        $this->hosts = new ArrayCollection();
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
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param mixed $address
     */
    public function setAddress($address)
    {
        $this->address = $address;
    }

    /**
     * @return mixed
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * @param mixed $comment
     */
    public function setComment($comment)
    {
        $this->comment = $comment;
    }

    /**
     * @return ArrayCollection
     */
    public function getHosts()
    {
        return $this->hosts;
    }

    /**
     * @return Vlan
     */
    public function getVlan()
    {
        return $this->vlan;
    }

    /**
     * @param Vlan $vlan
     */
    public function setVlan(Vlan $vlan)
    {
        $this->vlan = $vlan;
    }

    /**
     * @return Vrf
     */
    public function getVrf()
    {
        return $this->vrf;
    }

    /**
     * @param Vrf $vrf
     */
    public function setVrf(Vrf $vrf)
    {
        $this->vrf = $vrf;
    }

    /**
     * @return Office
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * @param Office $location
     */
    public function setLocation(Office $location)
    {
        $this->location = $location;
    }

}
