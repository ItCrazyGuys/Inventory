<?php

namespace App\Command;

use App\Service\ImportAgentsDnService\AgentsDnImporterService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class DbHdsImportDailyAgentsDnStatsCommand extends Command
{
    protected static $defaultName = 'db:hds:import-daily-agents-dn-stats';
    private $importerAgentsDnService;


    public function __construct(AgentsDnImporterService $importerAgentsDnService)
    {
        $this->importerAgentsDnService = $importerAgentsDnService;
        parent::__construct();
    }

    /**
     * Method for configuration the command
     */
    protected function configure()
    {
        $this->setDescription('Import HDS daily call statistics by phones who used the agents license');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->importerAgentsDnService->import();

        $io = new SymfonyStyle($input, $output);
        $io->success('Data import completed ');
    }
}
