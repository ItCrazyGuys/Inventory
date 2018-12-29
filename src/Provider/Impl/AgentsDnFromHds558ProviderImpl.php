<?php

namespace App\Provider\Impl;

use App\Provider\AgentsDnProvider;

/**
 * Get agentsDn for yesterday from hds558 for all cucms
 *
 * Class AgentsDnFromHds558ProviderImpl
 * @package App\Provider\Impl
 */
class AgentsDnFromHds558ProviderImpl implements AgentsDnProvider
{
    private const PREFIX = '558';

    private $host;
    private $database;
    private $user;
    private $password;
    private $hds558Table;


    /**
     * AgentsDnFromHds558ProviderImpl constructor.
     * @param $hds558Host
     * @param $hds558Database
     * @param $hds558Login
     * @param $hds558Pass
     * @param $hds558Table
     */
    public function __construct($hds558Host, $hds558Database, $hds558Login, $hds558Pass, $hds558Table)
    {
        $this->host = $hds558Host;
        $this->database = $hds558Database;
        $this->user = $hds558Login;
        $this->password = $hds558Pass;
        $this->hds558Table = $hds558Table;
    }

    /**
     * @return array - agentsDn for yesterday from hds for all cucms558
     */
    public function getAgentsDn()
    {
        // Get dbh
        $dbh = $this->getDbh();

        // Get agentsDn for yesterday from cucm
        $query = 'SELECT DISTINCT "Extension" AS dn FROM dbo."'.$this->hds558Table.'" AS agent_dn WHERE agent_dn."LogoutDateTime" BETWEEN ? AND ?';
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
