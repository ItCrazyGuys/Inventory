<?php

namespace App\Service\IpData\Impl;

use App\Service\IpData\IpDataService;
use Doctrine\ORM\EntityManagerInterface;

class IpDataServiceImpl implements IpDataService
{
    private const ROUTER = 'router';
    private const SWITCH = 'switch';
    private const VG = 'vg';

    private $em;


    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @param $ip
     * @return array
     * @throws \Doctrine\DBAL\DBALException
     */
    public function getIpDataByIp($ip)
    {
        $query = 'SELECT dev.hostname, dev."managementIp", dev."lotusId" FROM view.dev_module_port_geo AS dev WHERE dev."managementIp" = :ip AND dev."appType" IN (:switch, :router, :vg)';
        $params = [
            'ip' => $ip,
            ':switch' => self::SWITCH,
            ':router' => self::ROUTER,
            ':vg' => self::VG,
        ];

        $stmt = $this->em->getConnection()->prepare($query);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    /**
     * @return array
     * @throws \Doctrine\DBAL\DBALException
     */
    public function getAllIpData()
    {
        $query = 'SELECT dev.hostname, dev."managementIp", dev."lotusId" FROM view.dev_module_port_geo AS dev WHERE dev."appType" IN (:switch, :router, :vg)';
        $params = [
            ':switch' => self::SWITCH,
            ':router' => self::ROUTER,
            ':vg' => self::VG,
        ];

        $stmt = $this->em->getConnection()->prepare($query);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }
}
