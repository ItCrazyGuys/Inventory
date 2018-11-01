<?php
namespace App\Service\ImportAgentsDn;

use App\Service\ImportAgentsDn\Provider\ResourceHDSProvider;
use App\Service\Importer;
use Psr\Log\LoggerInterface;

class ImporterAgentsDnFromHDS implements Importer
{


    private $resourceHDS;
    private $logger;


    /**
     * ImporterAgentsDnFromHDS constructor.
     * @param ResourceHDSProvider $resourceHDS
     */
    public function __construct(ResourceHDSProvider $resourceHDS, LoggerInterface $logger)
    {
        $this->resourceHDS = $resourceHDS;
        $this->logger = $logger;
    }


    public function import()
    {
        // Processing cucms
        $cucms = [
            ['name' => 'cc-559', 'prefix' => '559']
        ];

        // For each cucms
        foreach ($cucms as $cucm) {
            try {
                // Get agentsDn for yesterday from cucm
                $agentsDn = $this->resourceHDS->getAgentsDn($cucm['name']);
                var_dump($agentsDn);




            } catch (\Throwable $e) {
                $this->logger->error($e->getMessage());
            }
        }

    }
}
