<?php

namespace App\Service\ImportAgentsDnService\Impl;

use App\Entity\Hds\WeeklyAgentsDnStats;
use App\Service\ImportAgentsDnService\AgentsDnImporterService;
use Doctrine\DBAL\DBALException;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;

class HdsWeeklyAgentsDnStatisticsImporterServiceImpl implements AgentsDnImporterService
{
    private $logger;
    private $em;


    /**
     * HdsWeeklyAgentsDnStatisticsImporterServiceImpl constructor.
     * @param LoggerInterface $logger
     * @param EntityManagerInterface $em
     */
    public function __construct(LoggerInterface $logger, EntityManagerInterface $em)
    {
        $this->logger = $logger; // todo - сделать в отдельном файле
        $this->em = $em;
    }

    /**
     * @return mixed|void
     * @throws DBALException
     */
    public function import()
    {
        // Get Hds daily agents dn statistics
        $dailyAgentsDnStats = $this->importDailyAgentsDnStats();

        // Add Daily Stats to Week Stats
        $this->addDailyStatsToWeekStats($dailyAgentsDnStats);

        // Update Weekly Agents Dn Stats Views
        $this->updateHdsWeeklyStatsViews();
    }

    /**
     * @param $dailyAgentsDnStats
     */
    private function addDailyStatsToWeekStats($dailyAgentsDnStats)
    {
        foreach ($dailyAgentsDnStats as $agentsDnStats) {
            try {

                // Validate input fields
                if (!isset($agentsDnStats['lotusId'])) {
                    $this->logger->error('Not found LotusId for [prefix]='.$agentsDnStats['prefix'].' and [dn]='.$agentsDnStats['dn']);
                    continue;
                }

                // Get Hds weekly agents dn statistics
                $stats = $this->em->getRepository(WeeklyAgentsDnStats::class)->findOneBy(['year' => $agentsDnStats['year'], 'week' => $agentsDnStats['week'], 'lotusId' =>  $agentsDnStats['lotusId'], 'prefix' => $agentsDnStats['prefix'], 'dn' => $agentsDnStats['dn']]);

                // Create Hds weekly agents dn statistics
                if (is_null($stats)) {
                    $this->createWeeklyStats($agentsDnStats);
                }
            } catch (\Throwable $e) {
                $this->logger->error($e->getMessage());
            }
        }
    }

    /**
     * @param array $agentsDnStats
     */
    private function createWeeklyStats(array $agentsDnStats)
    {
        // Create Hds weekly agents dn statistics
        $weeklyStats = new WeeklyAgentsDnStats();
        $weeklyStats->setYear($agentsDnStats['year']);
        $weeklyStats->setWeek($agentsDnStats['week']);
        $weeklyStats->setDate(new \DateTime($agentsDnStats['date']));
        $weeklyStats->setLotusId($agentsDnStats['lotusId']);
        $weeklyStats->setPrefix($agentsDnStats['prefix']);
        $weeklyStats->setDn($agentsDnStats['dn']);
        $this->em->persist($weeklyStats);
        $this->em->flush();
    }

    /**
     * @return array
     */
    private function importDailyAgentsDnStats()
    {
        try {
            // Get dbh
            $dbh = $this->em->getConnection();

            // Get daily agents dn statistics
            $query = '
                WITH
                  phones AS (
                    WITH
                      appliance AS (
                        WITH office AS (SELECT __id, "lotusId" FROM company.offices)
                        SELECT
                         appliance.__id,
                         appliance."lastUpdate",
                         office."lotusId"
                        FROM equipment.appliances AS appliance
                        LEFT JOIN office ON appliance.__location_id = office.__id
                      )
                    SELECT
                     appliance."lotusId",
                     phone.prefix,
                     phone."phoneDN" AS dn,
                     appliance."lastUpdate"
                    FROM equipment."phoneInfo" AS phone
                    JOIN appliance ON phone.__appliance_id = appliance.__id
                    WHERE (((date_part(\'epoch\' :: TEXT, age(now(), "appliance"."lastUpdate")) / (3600) :: DOUBLE PRECISION)) :: INTEGER) < 73
                  ),
                
                  hds_stats_phones AS (
                    SELECT
                     stats.day_of_statistics,
                     stats.prefix,
                     stats.dn,
                     max(phones."lastUpdate") AS "lastUpdate"
                    FROM hds.hds_daily_agents_dn_statistics AS stats
                    JOIN phones ON stats.prefix = phones.prefix AND stats.dn = phones.dn
                    GROUP BY stats.prefix, stats.dn, stats.day_of_statistics
                  )
                
                SELECT
                  date_part(\'year\', stats.day_of_statistics) AS year,
                  date_part(\'week\', stats.day_of_statistics) AS week,
                  stats.day_of_statistics AS date,
                  phones."lotusId",
                  stats.prefix,
                  stats.dn
                FROM hds_stats_phones AS stats
                JOIN phones ON stats.prefix = phones.prefix AND stats.dn = phones.dn AND stats."lastUpdate" = phones."lastUpdate"
            ';
            $params = [];

            $stmt = $dbh->prepare($query);
            $dailyAgentsDnStats = ($stmt->execute($params) === true) ? $stmt->fetchAll(\PDO::FETCH_ASSOC) : [];

            // Close resources
            unset($stmt);
            unset($dbh);

        } catch (\Throwable $e) {
            $this->logger->error($e->getMessage());
            if (isset($stmt)) {
                unset($stmt);
            }
            if (isset($dbh)) {
                unset($dbh);
            }
        }

        return $dailyAgentsDnStats ?? [];
    }

    private function updateHdsWeeklyStatsViews()
    {
        try {
            // Get dbh
            $dbh = $this->em->getConnection();

            // Update Weekly Agents Dn Stats Views
            $query = 'SELECT hds.update_hds_weekly_stats()';
            $params = [];

            $stmt = $dbh->prepare($query);
            $stmt->execute($params);

            // Close resources
            unset($stmt);
            unset($dbh);

        } catch (\Throwable $e) {
            $this->logger->error($e->getMessage());
            if (isset($stmt)) {
                unset($stmt);
            }
            if (isset($dbh)) {
                unset($dbh);
            }
        }
    }
}
