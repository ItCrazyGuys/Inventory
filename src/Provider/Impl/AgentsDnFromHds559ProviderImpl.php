<?php

namespace App\Provider\Impl;

use App\Provider\AgentsDnProvider;

/**
 * Get agentsDn for yesterday from hds559 for all cucms
 *
 * Class AgentsDnFromHds559ProviderImpl
 * @package App\Provider\Impl
 */
class AgentsDnFromHds559ProviderImpl implements AgentsDnProvider
{
    private const PREFIX = '559';

    private $host;
    private $database;
    private $user;
    private $password;
    private $hds559Table;


    /**
     * AgentsDnFromHds559ProviderImpl constructor.
     * @param $hds559Host
     * @param $hds559Database
     * @param $hds559Login
     * @param $hds559Pass
     * @param $hds559Table
     */
    public function __construct($hds559Host, $hds559Database, $hds559Login, $hds559Pass, $hds559Table)
    {
        $this->host = $hds559Host;
        $this->database = $hds559Database;
        $this->user = $hds559Login;
        $this->password = $hds559Pass;
        $this->hds559Table = $hds559Table;
    }

    /**
     * @return array - agentsDn for yesterday from hds for all cucms559
     */
    public function getAgentsDn()
    {
        // Get dbh
        $dbh = $this->getDbh();

        // Get agentsDn for yesterday from cucm
        $query = 'SELECT DISTINCT "Extension" AS dn FROM dbo."'.$this->hds559Table.'" AS agent_dn WHERE agent_dn."LogoutDateTime" BETWEEN ? AND ?';
        $lastDay = (new \DateTime("last day"))->format('Y-m-d 00:00:00');
        $currentDay = (new \DateTime())->format('Y-m-d 00:00:00');
        $params = [$lastDay, $currentDay];

        $stmt = $dbh->prepare($query);
        $agentsDn = ($stmt->execute($params) === true) ? $stmt->fetchAll(\PDO::FETCH_ASSOC) : [];
        foreach ($agentsDn as &$dn) {
            $dn['prefix'] = self::PREFIX;
        }

        // Close resources
        unset($stmt);
        unset($dbh);

        return $agentsDn;
    }

    /**
     * @return \PDO
     */
    private function getDbh()
    {
        try {
            // for linux
            $dsn = 'dblib:host=' . $this->host . ':1433;dbname=' . $this->database;
            $dbh = new \PDO($dsn, $this->user, $this->password);
        } catch (\Throwable $e) {
            // for windows
            $dbh = new \PDO('odbc:Driver={SQL Server Native Client 10.0};Server='.$this->host.';Database='.$this->database.';Uid='.$this->user.';Pwd='.$this->password);
        }
        return $dbh;
    }
}
