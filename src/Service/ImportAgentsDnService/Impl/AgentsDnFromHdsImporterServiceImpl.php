<?php

namespace App\Service\ImportAgentsDnService\Impl;

use App\Provider\AgentsDnProvider;
use App\Service\ImportAgentsDnService\AgentsDnImporterService;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;

class AgentsDnFromHdsImporterServiceImpl implements AgentsDnImporterService
{
    private $agentsDnProvider;
    private $logger;
    private $em;


    /**
     * AgentsDnFromHdsImporterServiceImpl constructor.
     * @param AgentsDnProvider $agentsDnProvider
     * @param LoggerInterface $logger
     * @param EntityManagerInterface $em
     */
    public function __construct(AgentsDnProvider $agentsDnProvider, LoggerInterface $logger, EntityManagerInterface $em)
    {
        $this->agentsDnProvider = $agentsDnProvider;
        $this->logger = $logger; // todo - сделать в отдельном файле
        $this->em = $em;
    }

    /**
     * @return mixed|void
     */
    public function import()
    {
        try {
            // Get agentsDn
            $agentsDn = $this->agentsDnProvider->getAgentsDn();

            // Import agentsDn statistics
            $this->importStatisticsByAgentsDn($agentsDn);

        } catch (\Throwable $e) {
            $this->logger->error($e->getMessage());
        }
    }

    private function importStatisticsByAgentsDn($agentsDn)
    {
        // Define Phones(AgentsDn) Statistics by Offices as array: [ 'officeId' => [id_1, id_2, ..., id_N]]
        $phonesStatsByOffices = [];

        // Define AgentsDn Statistics by Offices as array: [ 'officeId' => ['prefix1' => amount of AgentsDn in given office by prefix1', 'prefix2' => amount of AgentsDn in given office by prefix2']]
        $agentsDnStatsByOffices = [];

        // Get Phones and AgentsDn Statistics
        foreach ($agentsDn as $agentDn) {
            try {
                $phone = $this->em->getRepository("View:DevPhoneInfoGeo")->getOfficeAndApplianceBy($agentDn['prefix'], $agentDn['extension']);
            } catch (\Throwable $e) {
                $this->logger->warning($e->getMessage());
                continue;
            }
            if (is_null($phone)) {
                continue;
            }
            $office = $phone['officeId'];
            $prefix = $agentDn['prefix'];
            $agentsDnStatsByOffices[$office][$prefix] = isset($agentsDnStatsByOffices[$office][$prefix]) ? ++$agentsDnStatsByOffices[$office][$prefix] : 1;
            $phonesStatsByOffices[$office][] = $phone['applianceId'];
        }

        dump($agentsDnStatsByOffices);
        dump($phonesStatsByOffices);

    }
}
