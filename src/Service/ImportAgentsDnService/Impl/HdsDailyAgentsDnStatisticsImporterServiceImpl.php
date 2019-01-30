<?php

namespace App\Service\ImportAgentsDnService\Impl;

use App\Provider\Impl\AgentsDnFromHds558ProviderImpl;
use App\Provider\Impl\AgentsDnFromHds559ProviderImpl;
use App\Service\ImportAgentsDnService\AgentsDnImporterService;
use Doctrine\DBAL\DBALException;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;

class HdsDailyAgentsDnStatisticsImporterServiceImpl implements AgentsDnImporterService
{
    private $logger;
    private $em;
    private $agents558DnProvider;
    private $agents559DnProvider;


    /**
     * AgentsDnFromHdsImporterServiceImpl constructor.
     * @param AgentsDnFromHds559ProviderImpl $agents559DnProvider
     * @param AgentsDnFromHds558ProviderImpl $agents558DnProvider
     * @param LoggerInterface $logger
     * @param EntityManagerInterface $em
     */
    public function __construct(AgentsDnFromHds559ProviderImpl $agents559DnProvider, AgentsDnFromHds558ProviderImpl $agents558DnProvider, LoggerInterface $logger, EntityManagerInterface $em)
    {
        $this->agents559DnProvider = $agents559DnProvider;
        $this->agents558DnProvider = $agents558DnProvider;
        $this->logger = $logger; // todo - сделать в отдельном файле
        $this->em = $em;
    }

    /**
     * @return mixed|void
     */
    public function import()
    {
        try {
            // Get agents559Dn
            $agents559Dn = $this->agents559DnProvider->getAgentsDn();

            // Get agents558Dn
            $agents558Dn = $this->agents558DnProvider->getAgentsDn();

            // Merge agentsDn
            $agentsDn = array_merge($agents559Dn, $agents558Dn);
            unset($agents558Dn);
            unset($agents559Dn);

            // Import agentsDn
            $this->importAgentsDn($agentsDn);

        } catch (\Throwable $e) {
            $this->logger->error($e->getMessage());
        }
    }

    private function importAgentsDn($agentsDn)
    {
        $table = 'hds.hds_daily_agents_dn_statistics';
        $dbh = $this->em->getConnection();
        $dbh->beginTransaction();
        try {
            // Delete old data
            $query = 'TRUNCATE ' . $table;
            $stmt = $dbh->prepare($query);
            $stmt->execute();

            // Save import data
            $values = '';
            $params = [];
            foreach ($agentsDn as $dn) {
                if (empty($values)) {
                    $values .= '(?, ?, CURRENT_DATE - INTERVAL \'1 day\')';
                } else {
                    $values .= ', (?, ?, CURRENT_DATE - INTERVAL \'1 day\')';
                }
                $params[] = $dn['prefix'];
                $params[] = $dn['dn'];
            }
            $query = 'INSERT INTO '.$table.' VALUES ' . $values;
            $stmt = $dbh->prepare($query);
            $stmt->execute($params);

            $dbh->commit();
        } catch (DBALException $e) {
            $this->logger->error($e->getMessage());
            $dbh->rollBack();
        }
    }
}
