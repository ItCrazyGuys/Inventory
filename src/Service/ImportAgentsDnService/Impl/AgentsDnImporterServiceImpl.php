<?php

namespace App\Service\ImportAgentsDnService\Impl;

use App\Provider\AgentsDnProvider;
use App\Service\ImportAgentsDnService\AgentsDnImporterService;
use Psr\Log\LoggerInterface;

class AgentsDnImporterServiceImpl implements AgentsDnImporterService
{
    private $agentsDnProvider;
    private $logger;


    /**
     * AgentsDnImporterServiceImpl constructor.
     * @param AgentsDnProvider $agentsDnProvider
     * @param LoggerInterface $logger
     */
    public function __construct(AgentsDnProvider $agentsDnProvider, LoggerInterface $logger)
    {
        $this->agentsDnProvider = $agentsDnProvider;
        $this->logger = $logger;
    }


    public function import()
    {
        try {
            // Get agentsDn
            $agentsDn = $this->agentsDnProvider->getAgentsDn();
            var_dump($agentsDn);




        } catch (\Throwable $e) {
            $this->logger->error($e->getMessage());
        }

    }
}
