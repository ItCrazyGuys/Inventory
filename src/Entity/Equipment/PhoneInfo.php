<?php

namespace App\Entity\Equipment;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="`phoneInfo`", schema="equipment")
 */
class PhoneInfo
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
    private $name;

    /**
     * @ORM\Column(type="string")
     */
    private $model;

    /**
     * @ORM\Column(type="integer")
     */
    private $prefix;

    /**
     * @ORM\Column(name="`phoneDN`", type="integer")
     */
    private $phoneDN;

    /**
     * @ORM\Column(type="string")
     */
    private $status;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="string")
     */
    private $css;

    /**
     * @ORM\Column(name="`devicePool`", type="string")
     */
    private $devicePool;

    /**
     * @ORM\Column(name="`alertingName`", type="string")
     */
    private $alertingName;

    /**
     * @ORM\Column(type="string")
     */
    private $partition;

    /**
     * @ORM\Column(type="string")
     */
    private $timezone;

    /**
     * @ORM\Column(name="`dhcpEnabled`", type="boolean")
     */
    private $dhcpEnabled;

    /**
     * @ORM\Column(name="`dhcpServer`", type="string")
     */
    private $dhcpServer;

    /**
     * @ORM\Column(name="`domainName`", type="string")
     */
    private $domainName;

    /**
     * @ORM\Column(name="`tftpServer1`", type="string")
     */
    private $tftpServer1;

    /**
     * @ORM\Column(name="`tftpServer2`", type="string")
     */
    private $tftpServer2;

    /**
     * @ORM\Column(name="`defaultRouter`", type="string")
     */
    private $defaultRouter;

    /**
     * @ORM\Column(name="`dnsServer1`", type="string")
     */
    private $dnsServer1;

    /**
     * @ORM\Column(name="`dnsServer2`", type="string")
     */
    private $dnsServer2;

    /**
     * @ORM\Column(name="`callManager1`", type="string")
     */
    private $callManager1;

    /**
     * @ORM\Column(name="`callManager2`", type="string")
     */
    private $callManager2;

    /**
     * @ORM\Column(name="`callManager3`", type="string")
     */
    private $callManager3;

    /**
     * @ORM\Column(name="`callManager4`", type="string")
     */
    private $callManager4;

    /**
     * @ORM\Column(name="`vlanId`", type="integer")
     */
    private $vlanId;

    /**
     * @ORM\Column(name="`userLocale`", type="string")
     */
    private $userLocale;

    /**
     * @ORM\Column(name="`cdpNeighborDeviceId`", type="string")
     */
    private $cdpNeighborDeviceId;

    /**
     * @ORM\Column(name="`cdpNeighborIP`", type="string")
     */
    private $cdpNeighborIP;

    /**
     * @ORM\Column(name="`cdpNeighborPort`", type="string")
     */
    private $cdpNeighborPort;

    /**
     * @ORM\Column(name="`publisherIp`", type="string")
     */
    private $publisherIp;

    /**
     * @ORM\Column(name="`unknownLocation`", type="boolean")
     */
    private $unknownLocation;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Equipment\Appliance", fetch="EXTRA_LAZY")
     * @ORM\JoinColumn(name="__appliance_id", referencedColumnName="__id")
     */
    private $phone;




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
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * @param mixed $model
     */
    public function setModel($model)
    {
        $this->model = $model;
    }

    /**
     * @return mixed
     */
    public function getPrefix()
    {
        return $this->prefix;
    }

    /**
     * @param mixed $prefix
     */
    public function setPrefix($prefix)
    {
        $this->prefix = $prefix;
    }

    /**
     * @return mixed
     */
    public function getPhoneDN()
    {
        return $this->phoneDN;
    }

    /**
     * @param mixed $phoneDN
     */
    public function setPhoneDN($phoneDN)
    {
        $this->phoneDN = $phoneDN;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getCss()
    {
        return $this->css;
    }

    /**
     * @param mixed $css
     */
    public function setCss($css)
    {
        $this->css = $css;
    }

    /**
     * @return mixed
     */
    public function getDevicePool()
    {
        return $this->devicePool;
    }

    /**
     * @param mixed $devicePool
     */
    public function setDevicePool($devicePool)
    {
        $this->devicePool = $devicePool;
    }

    /**
     * @return mixed
     */
    public function getAlertingName()
    {
        return $this->alertingName;
    }

    /**
     * @param mixed $alertingName
     */
    public function setAlertingName($alertingName)
    {
        $this->alertingName = $alertingName;
    }

    /**
     * @return mixed
     */
    public function getPartition()
    {
        return $this->partition;
    }

    /**
     * @param mixed $partition
     */
    public function setPartition($partition)
    {
        $this->partition = $partition;
    }

    /**
     * @return mixed
     */
    public function getTimezone()
    {
        return $this->timezone;
    }

    /**
     * @param mixed $timezone
     */
    public function setTimezone($timezone)
    {
        $this->timezone = $timezone;
    }

    /**
     * @return mixed
     */
    public function getDhcpEnabled()
    {
        return $this->dhcpEnabled;
    }

    /**
     * @param mixed $dhcpEnabled
     */
    public function setDhcpEnabled($dhcpEnabled)
    {
        $this->dhcpEnabled = $dhcpEnabled;
    }

    /**
     * @return mixed
     */
    public function getDhcpServer()
    {
        return $this->dhcpServer;
    }

    /**
     * @param mixed $dhcpServer
     */
    public function setDhcpServer($dhcpServer)
    {
        $this->dhcpServer = $dhcpServer;
    }

    /**
     * @return mixed
     */
    public function getDomainName()
    {
        return $this->domainName;
    }

    /**
     * @param mixed $domainName
     */
    public function setDomainName($domainName)
    {
        $this->domainName = $domainName;
    }

    /**
     * @return mixed
     */
    public function getTftpServer1()
    {
        return $this->tftpServer1;
    }

    /**
     * @param mixed $tftpServer1
     */
    public function setTftpServer1($tftpServer1)
    {
        $this->tftpServer1 = $tftpServer1;
    }

    /**
     * @return mixed
     */
    public function getTftpServer2()
    {
        return $this->tftpServer2;
    }

    /**
     * @param mixed $tftpServer2
     */
    public function setTftpServer2($tftpServer2)
    {
        $this->tftpServer2 = $tftpServer2;
    }

    /**
     * @return mixed
     */
    public function getDefaultRouter()
    {
        return $this->defaultRouter;
    }

    /**
     * @param mixed $defaultRouter
     */
    public function setDefaultRouter($defaultRouter)
    {
        $this->defaultRouter = $defaultRouter;
    }

    /**
     * @return mixed
     */
    public function getDnsServer1()
    {
        return $this->dnsServer1;
    }

    /**
     * @param mixed $dnsServer1
     */
    public function setDnsServer1($dnsServer1)
    {
        $this->dnsServer1 = $dnsServer1;
    }

    /**
     * @return mixed
     */
    public function getDnsServer2()
    {
        return $this->dnsServer2;
    }

    /**
     * @param mixed $dnsServer2
     */
    public function setDnsServer2($dnsServer2)
    {
        $this->dnsServer2 = $dnsServer2;
    }

    /**
     * @return mixed
     */
    public function getCallManager1()
    {
        return $this->callManager1;
    }

    /**
     * @param mixed $callManager1
     */
    public function setCallManager1($callManager1)
    {
        $this->callManager1 = $callManager1;
    }

    /**
     * @return mixed
     */
    public function getCallManager2()
    {
        return $this->callManager2;
    }

    /**
     * @param mixed $callManager2
     */
    public function setCallManager2($callManager2)
    {
        $this->callManager2 = $callManager2;
    }

    /**
     * @return mixed
     */
    public function getCallManager3()
    {
        return $this->callManager3;
    }

    /**
     * @param mixed $callManager3
     */
    public function setCallManager3($callManager3)
    {
        $this->callManager3 = $callManager3;
    }

    /**
     * @return mixed
     */
    public function getCallManager4()
    {
        return $this->callManager4;
    }

    /**
     * @param mixed $callManager4
     */
    public function setCallManager4($callManager4)
    {
        $this->callManager4 = $callManager4;
    }

    /**
     * @return mixed
     */
    public function getVlanId()
    {
        return $this->vlanId;
    }

    /**
     * @param mixed $vlanId
     */
    public function setVlanId($vlanId)
    {
        $this->vlanId = $vlanId;
    }

    /**
     * @return mixed
     */
    public function getUserLocale()
    {
        return $this->userLocale;
    }

    /**
     * @param mixed $userLocale
     */
    public function setUserLocale($userLocale)
    {
        $this->userLocale = $userLocale;
    }

    /**
     * @return mixed
     */
    public function getCdpNeighborDeviceId()
    {
        return $this->cdpNeighborDeviceId;
    }

    /**
     * @param mixed $cdpNeighborDeviceId
     */
    public function setCdpNeighborDeviceId($cdpNeighborDeviceId)
    {
        $this->cdpNeighborDeviceId = $cdpNeighborDeviceId;
    }

    /**
     * @return mixed
     */
    public function getCdpNeighborIP()
    {
        return $this->cdpNeighborIP;
    }

    /**
     * @param mixed $cdpNeighborIP
     */
    public function setCdpNeighborIP($cdpNeighborIP)
    {
        $this->cdpNeighborIP = $cdpNeighborIP;
    }

    /**
     * @return mixed
     */
    public function getCdpNeighborPort()
    {
        return $this->cdpNeighborPort;
    }

    /**
     * @param mixed $cdpNeighborPort
     */
    public function setCdpNeighborPort($cdpNeighborPort)
    {
        $this->cdpNeighborPort = $cdpNeighborPort;
    }

    /**
     * @return mixed
     */
    public function getPublisherIp()
    {
        return $this->publisherIp;
    }

    /**
     * @param mixed $publisherIp
     */
    public function setPublisherIp($publisherIp)
    {
        $this->publisherIp = $publisherIp;
    }

    /**
     * @return mixed
     */
    public function getUnknownLocation()
    {
        return $this->unknownLocation;
    }

    /**
     * @param mixed $unknownLocation
     */
    public function setUnknownLocation($unknownLocation)
    {
        $this->unknownLocation = $unknownLocation;
    }

    /**
     * @return mixed
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param Appliance $phone
     */
    public function setPhone(Appliance $phone)
    {
        $this->phone = $phone;
    }
}
