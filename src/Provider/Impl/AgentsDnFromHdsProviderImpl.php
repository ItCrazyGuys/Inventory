<?php

namespace App\Provider\Impl;

use App\Provider\AgentsDnProvider;

/**
 * Get agentsDn for yesterday from hds for all cucms
 *
 * Class AgentsDnFromHdsProviderImpl
 * @package App\Provider\Impl
 */
class AgentsDnFromHdsProviderImpl implements AgentsDnProvider
{
    private const CUCMS = [
        ['prefix' => '559', 'table' => 'Saratov_AgentLogOut']
    ];

    private $host;
    private $database;
    private $user;
    private $password;


    /**
     * ResourceHDSProvider constructor.
     * @param $hdsHost
     * @param $hdsDatabase
     * @param $hdsLogin
     * @param $hdsPass
     */
    public function __construct($hdsHost, $hdsDatabase, $hdsLogin, $hdsPass)
    {
        $this->host = $hdsHost;
        $this->database = $hdsDatabase;
        $this->user = $hdsLogin;
        $this->password = $hdsPass;
    }

    /**
     * @return array - agentsDn for yesterday from hds for all cucms
     */
    public function getAgentsDn()
    {
        // Get agentsDn for yesterday from all cucms
        $agentsDn = [];
        foreach (self::CUCMS as $cucm) {
            $agentsDn = array_merge($agentsDn, $this->getCucmAgentsDn($cucm));
        }
        return $agentsDn;
    }

    /**
     * @param $cucm
     * @return array
     */
    private function getCucmAgentsDn(array $cucm)
    {
        $cucmAgentsDn = [];

        // Get dbh
        $dbh = $this->getDbh();

        // Get agentsDn for yesterday from cucm
        $query = 'SELECT * FROM dbo."'.$cucm['table'].'" AS agent_dn WHERE agent_dn."LogoutDateTime" BETWEEN ? AND ?';
        $lastDay = (new \DateTime("last day"))->format('Y-m-d 00:00:00');
        $currentDay = (new \DateTime())->format('Y-m-d 00:00:00');
        $params = [$lastDay, $currentDay];

        $stmt = $dbh->prepare($query);
        if ($stmt->execute($params) === true) {
            foreach ($stmt->fetchAll() as $item) {
                $agentsDn[] = $item['Extension'];
            }
        }
        $agentsDn = array_unique($agentsDn);

        foreach ($agentsDn as $agentDn) {
            $cucmAgentsDn[] = ['prefix' => $cucm['prefix'], 'extension' => $agentDn];
        }

        // Close resources
        unset($stmt);
        unset($dbh);

        return $cucmAgentsDn;
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
