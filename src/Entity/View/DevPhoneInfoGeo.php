<?php

namespace App\Entity\View;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\View\DevPhoneInfoGeoRepository")
 * @ORM\Table(name="dev_phone_info_geo", schema="view")
 */
class DevPhoneInfoGeo
{

    /**
     * @ORM\Column(name="`lotus_regCenter`", type="string")
     */
    private $lotusRegCenter;

    /**
     * @ORM\Column(name="`region`", type="string")
     */
    private $region;

    /**
     * @ORM\Column(name="`lotus_region`", type="string")
     */
    private $lotusRegion;

    /**
     * @ORM\Column(name="`region_id`", type="bigint")
     */
    private $regionId;

    /**
     * @ORM\Column(name="`city`", type="string")
     */
    private $city;

    /**
     * @ORM\Column(name="`lotus_city`", type="string")
     */
    private $lotusCity;

    /**
     * @ORM\Column(name="`city_id`", type="bigint")
     */
    private $cityId;

    /**
     * @ORM\Column(name="`office`", type="string")
     */
    private $office;

    /**
     * @ORM\Column(name="`lotus_office`", type="string")
     */
    private $lotusOffice;

    /**
     * @ORM\Column(name="`office_id`", type="bigint")
     */
    private $officeId;

    /**
     * @ORM\Column(name="`lotusId`", type="integer")
     */
    private $lotusId;

    /**
     * @ORM\Column(name="`lotus_lotusId`", type="integer")
     */
    private $lotusLotusId;

    /**
     * @ORM\Column(name="`officeComment`", type="string")
     */
    private $officeComment;

    /**
     * @ORM\Column(name="`officeDetails`", type="json")
     */
    private $officeDetails;

    /**
     * @ORM\Column(name="`officeAddress`", type="string")
     */
    private $officeAddress;

    /**
     * @ORM\Column(name="`lotus_officeAddress`", type="string")
     */
    private $lotusOfficeAddress;

    /**
     * @ORM\Column(name="`lotus_employees`", type="integer")
     */
    private $lotusEmployees;

    /**
     * @ORM\Column(name="`lotus_lastRefresh`", type="datetime")
     */
    private $lotusLastRefresh;

    /**
     * @ORM\Id
     * @ORM\Column(name="`appliance_id`", type="bigint")
     */
    private $applianceId;

    /**
     * @ORM\Column(name="`appLastUpdate`", type="datetime")
     */
    private $appLastUpdate;

    /**
     * @ORM\Column(name="`appAge`", type="integer")
     */
    private $appAge;

    /**
     * @ORM\Column(name="`appInUse`", type="boolean")
     */
    private $appInUse;

    /**
     * @ORM\Column(name="`hostname`", type="string")
     */
    private $hostname;

    /**
     * @ORM\Column(name="`appDetails`", type="json")
     */
    private $appDetails;

    /**
     * @ORM\Column(name="`appComment`", type="string")
     */
    private $appComment;

    /**
     * @ORM\Column(name="`appType_id`", type="bigint")
     */
    private $appTypeId;

    /**
     * @ORM\Column(name="`appType`", type="string")
     */
    private $appType;

    /**
     * @ORM\Column(name="`cluster_id`", type="bigint")
     */
    private $clusterId;

    /**
     * @ORM\Column(name="`clusterTitle`", type="string")
     */
    private $clusterTitle;

    /**
     * @ORM\Column(name="`clusterDetails`", type="json")
     */
    private $clusterDetails;

    /**
     * @ORM\Column(name="`clusterComment`", type="string")
     */
    private $clusterComment;

    /**
     * @ORM\Column(name="`platformVendor_id`", type="bigint")
     */
    private $platformVendorId;

    /**
     * @ORM\Column(name="`platformVendor`", type="string")
     */
    private $platformVendor;

    /**
     * @ORM\Column(name="`platformItem_id`", type="bigint")
     */
    private $platformItemId;

    /**
     * @ORM\Column(name="`platformTitle`", type="string")
     */
    private $platformTitle;

    /**
     * @ORM\Column(name="`isHW`", type="boolean")
     */
    private $isHW;

    /**
     * @ORM\Column(name="`platform_id`", type="bigint")
     */
    private $platformId;

    /**
     * @ORM\Column(name="`platformSerial`", type="string")
     */
    private $platformSerial;

    /**
     * @ORM\Column(name="`softwareVendor_id`", type="bigint")
     */
    private $softwareVendorId;

    /**
     * @ORM\Column(name="`softwareVendor`", type="string")
     */
    private $softwareVendor;

    /**
     * @ORM\Column(name="`softwareItem_id`", type="bigint")
     */
    private $softwareItemId;

    /**
     * @ORM\Column(name="`software_id`", type="bigint")
     */
    private $softwareId;

    /**
     * @ORM\Column(name="`softwareTitle`", type="string")
     */
    private $softwareTitle;

    /**
     * @ORM\Column(name="`softwareVersion`", type="string")
     */
    private $softwareVersion;

    /**
     * @ORM\Column(name="`name`", type="string")
     */
    private $name;

    /**
     * @ORM\Column(name="`model`", type="string")
     */
    private $model;

    /**
     * @ORM\Column(name="`prefix`", type="integer")
     */
    private $prefix;

    /**
     * @ORM\Column(name="`phoneDN`", type="integer")
     */
    private $phoneDN;

    /**
     * @ORM\Column(name="`status`", type="string")
     */
    private $status;

    /**
     * @ORM\Column(name="`phoneDescription`", type="string")
     */
    private $phoneDescription;

    /**
     * @ORM\Column(name="`css`", type="string")
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
     * @ORM\Column(name="`partition`", type="string")
     */
    private $partition;

    /**
     * @ORM\Column(name="`timezone`", type="string")
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
     * @ORM\Column(name="`managementIp`", type="string")
     */
    private $managementIp;

    /**
     * @ORM\Column(name="`inventoryNumber`", type="string")
     */
    private $inventoryNumber;

    /**
     * @ORM\Column(name="`last_call_day`", type="string")
     */
    private $lastCallDay;

    /**
     * @ORM\Column(name="`d0_calls_amount`", type="integer")
     */
    private $d0callsAmount;

    /**
     * @ORM\Column(name="`m0_calls_amount`", type="integer")
     */
    private $m0callsAmount;

    /**
     * @ORM\Column(name="`m1_calls_amount`", type="integer")
     */
    private $m1callsAmount;

    /**
     * @ORM\Column(name="`m2_calls_amount`", type="integer")
     */
    private $m2callsAmount;

    /**
     * @ORM\Column(name="`responsiblePerson`", type="string")
     */
    private $responsiblePerson;


    /**
     * @return mixed
     */
    public function getLotusRegCenter()
    {
        return $this->lotusRegCenter;
    }

    /**
     * @return mixed
     */
    public function getRegion()
    {
        return $this->region;
    }

    /**
     * @return mixed
     */
    public function getLotusRegion()
    {
        return $this->lotusRegion;
    }

    /**
     * @return mixed
     */
    public function getRegionId()
    {
        return $this->regionId;
    }

    /**
     * @return mixed
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @return mixed
     */
    public function getLotusCity()
    {
        return $this->lotusCity;
    }

    /**
     * @return mixed
     */
    public function getCityId()
    {
        return $this->cityId;
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
    public function getLotusOffice()
    {
        return $this->lotusOffice;
    }

    /**
     * @return mixed
     */
    public function getOfficeId()
    {
        return $this->officeId;
    }

    /**
     * @return mixed
     */
    public function getLotusId()
    {
        return $this->lotusId;
    }

    /**
     * @return mixed
     */
    public function getLotusLotusId()
    {
        return $this->lotusLotusId;
    }

    /**
     * @return mixed
     */
    public function getOfficeComment()
    {
        return $this->officeComment;
    }

    /**
     * @return mixed
     */
    public function getOfficeDetails()
    {
        return $this->officeDetails;
    }

    /**
     * @return mixed
     */
    public function getOfficeAddress()
    {
        return $this->officeAddress;
    }

    /**
     * @return mixed
     */
    public function getLotusOfficeAddress()
    {
        return $this->lotusOfficeAddress;
    }

    /**
     * @return mixed
     */
    public function getLotusEmployees()
    {
        return $this->lotusEmployees;
    }

    /**
     * @return mixed
     */
    public function getLotusLastRefresh()
    {
        return $this->lotusLastRefresh;
    }

    /**
     * @return mixed
     */
    public function getApplianceId()
    {
        return $this->applianceId;
    }

    /**
     * @return mixed
     */
    public function getAppLastUpdate()
    {
        return $this->appLastUpdate;
    }

    /**
     * @return mixed
     */
    public function getAppAge()
    {
        return $this->appAge;
    }

    /**
     * @return mixed
     */
    public function getAppInUse()
    {
        return $this->appInUse;
    }

    /**
     * @return mixed
     */
    public function getHostname()
    {
        return $this->hostname;
    }

    /**
     * @return mixed
     */
    public function getAppDetails()
    {
        return $this->appDetails;
    }

    /**
     * @return mixed
     */
    public function getAppComment()
    {
        return $this->appComment;
    }

    /**
     * @return mixed
     */
    public function getAppTypeId()
    {
        return $this->appTypeId;
    }

    /**
     * @return mixed
     */
    public function getAppType()
    {
        return $this->appType;
    }

    /**
     * @return mixed
     */
    public function getClusterId()
    {
        return $this->clusterId;
    }

    /**
     * @return mixed
     */
    public function getClusterTitle()
    {
        return $this->clusterTitle;
    }

    /**
     * @return mixed
     */
    public function getClusterDetails()
    {
        return $this->clusterDetails;
    }

    /**
     * @return mixed
     */
    public function getClusterComment()
    {
        return $this->clusterComment;
    }

    /**
     * @return mixed
     */
    public function getPlatformVendorId()
    {
        return $this->platformVendorId;
    }

    /**
     * @return mixed
     */
    public function getPlatformVendor()
    {
        return $this->platformVendor;
    }

    /**
     * @return mixed
     */
    public function getPlatformItemId()
    {
        return $this->platformItemId;
    }

    /**
     * @return mixed
     */
    public function getPlatformTitle()
    {
        return $this->platformTitle;
    }

    /**
     * @return mixed
     */
    public function getisHW()
    {
        return $this->isHW;
    }

    /**
     * @return mixed
     */
    public function getPlatformId()
    {
        return $this->platformId;
    }

    /**
     * @return mixed
     */
    public function getPlatformSerial()
    {
        return $this->platformSerial;
    }

    /**
     * @return mixed
     */
    public function getSoftwareVendorId()
    {
        return $this->softwareVendorId;
    }

    /**
     * @return mixed
     */
    public function getSoftwareVendor()
    {
        return $this->softwareVendor;
    }

    /**
     * @return mixed
     */
    public function getSoftwareItemId()
    {
        return $this->softwareItemId;
    }

    /**
     * @return mixed
     */
    public function getSoftwareId()
    {
        return $this->softwareId;
    }

    /**
     * @return mixed
     */
    public function getSoftwareTitle()
    {
        return $this->softwareTitle;
    }

    /**
     * @return mixed
     */
    public function getSoftwareVersion()
    {
        return $this->softwareVersion;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * @return mixed
     */
    public function getPrefix()
    {
        return $this->prefix;
    }

    /**
     * @return mixed
     */
    public function getPhoneDN()
    {
        return $this->phoneDN;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @return mixed
     */
    public function getPhoneDescription()
    {
        return $this->phoneDescription;
    }

    /**
     * @return mixed
     */
    public function getCss()
    {
        return $this->css;
    }

    /**
     * @return mixed
     */
    public function getDevicePool()
    {
        return $this->devicePool;
    }

    /**
     * @return mixed
     */
    public function getAlertingName()
    {
        return $this->alertingName;
    }

    /**
     * @return mixed
     */
    public function getPartition()
    {
        return $this->partition;
    }

    /**
     * @return mixed
     */
    public function getTimezone()
    {
        return $this->timezone;
    }

    /**
     * @return mixed
     */
    public function getDhcpEnabled()
    {
        return $this->dhcpEnabled;
    }

    /**
     * @return mixed
     */
    public function getDhcpServer()
    {
        return $this->dhcpServer;
    }

    /**
     * @return mixed
     */
    public function getDomainName()
    {
        return $this->domainName;
    }

    /**
     * @return mixed
     */
    public function getTftpServer1()
    {
        return $this->tftpServer1;
    }

    /**
     * @return mixed
     */
    public function getTftpServer2()
    {
        return $this->tftpServer2;
    }

    /**
     * @return mixed
     */
    public function getDefaultRouter()
    {
        return $this->defaultRouter;
    }

    /**
     * @return mixed
     */
    public function getDnsServer1()
    {
        return $this->dnsServer1;
    }

    /**
     * @return mixed
     */
    public function getDnsServer2()
    {
        return $this->dnsServer2;
    }

    /**
     * @return mixed
     */
    public function getCallManager1()
    {
        return $this->callManager1;
    }

    /**
     * @return mixed
     */
    public function getCallManager2()
    {
        return $this->callManager2;
    }

    /**
     * @return mixed
     */
    public function getCallManager3()
    {
        return $this->callManager3;
    }

    /**
     * @return mixed
     */
    public function getCallManager4()
    {
        return $this->callManager4;
    }

    /**
     * @return mixed
     */
    public function getVlanId()
    {
        return $this->vlanId;
    }

    /**
     * @return mixed
     */
    public function getUserLocale()
    {
        return $this->userLocale;
    }

    /**
     * @return mixed
     */
    public function getCdpNeighborDeviceId()
    {
        return $this->cdpNeighborDeviceId;
    }

    /**
     * @return mixed
     */
    public function getCdpNeighborIP()
    {
        return $this->cdpNeighborIP;
    }

    /**
     * @return mixed
     */
    public function getCdpNeighborPort()
    {
        return $this->cdpNeighborPort;
    }

    /**
     * @return mixed
     */
    public function getPublisherIp()
    {
        return $this->publisherIp;
    }

    /**
     * @return mixed
     */
    public function getUnknownLocation()
    {
        return $this->unknownLocation;
    }

    /**
     * @return mixed
     */
    public function getManagementIp()
    {
        return $this->managementIp;
    }

    /**
     * @return mixed
     */
    public function getInventoryNumber()
    {
        return $this->inventoryNumber;
    }

    /**
     * @return mixed
     */
    public function getLastCallDay()
    {
        return $this->lastCallDay;
    }

    /**
     * @return mixed
     */
    public function getD0callsAmount()
    {
        return $this->d0callsAmount;
    }

    /**
     * @return mixed
     */
    public function getM0callsAmount()
    {
        return $this->m0callsAmount;
    }

    /**
     * @return mixed
     */
    public function getM1callsAmount()
    {
        return $this->m1callsAmount;
    }

    /**
     * @return mixed
     */
    public function getM2callsAmount()
    {
        return $this->m2callsAmount;
    }

    /**
     * @return mixed
     */
    public function getResponsiblePerson()
    {
        return $this->responsiblePerson;
    }
}
