<?php

namespace App\Provider\Impl;

use App\Provider\AgentsDnProvider;

/**
 * Get agentsDn for yesterday from cucm
 *
 * Class AgentsDnFromHdsProviderImpl
 * @package App\Provider\Impl
 */
class AgentsDnFromHdsProviderImpl implements AgentsDnProvider
{
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
     * @return array
     */
    public function getAgentsDn($cucm)
    {
        $agentsDn = [];

        // Map "Cucm -> Table"
        $table = [
            'cc-559' => 'Saratov_AgentLogOut',
        ];

        // for windows
        $dbh = new \PDO('odbc:Driver={SQL Server Native Client 10.0};Server='.$this->host.';Database='.$this->database.';Uid='.$this->user.';Pwd='.$this->password);

        // todo - uncomment before commit and push
        // for linux
//        $dsn = 'dblib:host='.$this->host.':1433;dbname='.$this->database;
//        $dbh = new \PDO($dsn, $this->user, $this->password);

        // Get agentsDn for yesterday from cucm
        $query = 'SELECT * FROM dbo."'.$table[$cucm].'" AS agent_dn WHERE agent_dn."LogoutDateTime" BETWEEN ? AND ?';
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

        // Close resources
        unset($stmt);
        unset($dbh);

        return $agentsDn;
    }
}
