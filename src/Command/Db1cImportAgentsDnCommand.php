<?php

namespace App\Command;

use App\Service\ImportAgentsDnService\AgentsDnImporterService;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class Db1cImportAgentsDnCommand extends Command
{
    protected static $defaultName = 'db:1c:import-agents-dn';

    private $importerAgentsDnService;
    /**
     * @var LoggerInterface
     */
    private $logger;


    public function __construct(AgentsDnImporterService $importerAgentsDnService, LoggerInterface $logger)
    {
        $this->importerAgentsDnService = $importerAgentsDnService;
        $this->logger = $logger;
        parent::__construct();
    }

    /**
     * Method for configuration the command
     */
    protected function configure()
    {
        $this->setDescription('Import of phones who used the agents license');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->importerAgentsDnService->import();

        $io = new SymfonyStyle($input, $output);
        $io->success('Data import completed ');
    }
}
