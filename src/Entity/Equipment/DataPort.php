<?php

namespace App\Entity\Equipment;

use App\Entity\Network\Network;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="`dataPorts`", schema="equipment")
 */
class DataPort
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(name="__id", type="bigint")
     */
    private $id;

    /**
     * @ORM\Column(name="`ipAddress`", type="string")
     */
    private $ipAddress;

    /**
     * @ORM\Column(type="integer")
     */
    private $masklen;

    /**
     * @ORM\Column(name="`macAddress`", type="string")
     */
    private $macAddress;

    /**
     * @ORM\Column(type="json")
     */
    private $details;

    /**
     * @ORM\Column(type="text")
     */
    private $comment;

    /**
     * @ORM\Column(name="`lastUpdate`", type="datetimetz")
     */
    private $lastUpdate;

    /**
     * @ORM\Column(name="`isManagement`", type="boolean")
     */
    private $isManagement;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Equipment\Appliance", fetch="EXTRA_LAZY")
     * @ORM\JoinColumn(name="__appliance_id", referencedColumnName="__id")
     */
    private $appliance;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Equipment\DPortType", fetch="EXTRA_LAZY")
     * @ORM\JoinColumn(name="__type_port_id", referencedColumnName="__id")
     */
    private $portType;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Network\Network", fetch="EXTRA_LAZY")
     * @ORM\JoinColumn(name="__network_id", referencedColumnName="__id")
     */
    private $network;




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
    public function getIpAddress()
    {
        return $this->ipAddress;
    }

    /**
     * @param mixed $ipAddress
     */
    public function setIpAddress($ipAddress)
    {
        $this->ipAddress = $ipAddress;
    }

    /**
     * @return mixed
     */
    public function getMasklen()
    {
        return $this->masklen;
    }

    /**
     * @param mixed $masklen
     */
    public function setMasklen($masklen)
    {
        $this->masklen = $masklen;
    }

    /**
     * @return mixed
     */
    public function getMacAddress()
    {
        return $this->macAddress;
    }

    /**
     * @param mixed $macAddress
     */
    public function setMacAddress($macAddress)
    {
        $this->macAddress = $macAddress;
    }

    /**
     * @return mixed
     */
    public function getDetails()
    {
        return $this->details;
    }

    /**
     * @param mixed $details
     */
    public function setDetails($details)
    {
        $this->details = $details;
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
     * @return mixed
     */
    public function getLastUpdate()
    {
        return $this->lastUpdate;
    }

    /**
     * @param mixed $lastUpdate
     */
    public function setLastUpdate($lastUpdate)
    {
        $this->lastUpdate = $lastUpdate;
    }

    /**
     * @return mixed
     */
    public function getisManagement()
    {
        return $this->isManagement;
    }

    /**
     * @param mixed $isManagement
     */
    public function setIsManagement($isManagement)
    {
        $this->isManagement = $isManagement;
    }

    /**
     * @return Appliance
     */
    public function getAppliance()
    {
        return $this->appliance;
    }

    /**
     * @param Appliance $appliance
     */
    public function setAppliance(Appliance $appliance)
    {
        $this->appliance = $appliance;
    }

    /**
     * @return DPortType
     */
    public function getPortType()
    {
        return $this->portType;
    }

    /**
     * @param DPortType $portType
     */
    public function setPortType(DPortType $portType)
    {
        $this->portType = $portType;
    }

    /**
     * @return Network
     */
    public function getNetwork()
    {
        return $this->network;
    }

    /**
     * @param Network $network
     */
    public function setNetwork(Network $network)
    {
        $this->network = $network;
    }
}
