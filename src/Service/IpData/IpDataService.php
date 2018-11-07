<?php

namespace App\Service\IpData;

interface IpDataService
{
    public function getIpDataByIp($ip);
    public function getAllIpData();
}
