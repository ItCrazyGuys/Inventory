<?php

namespace App\Command;

use App\Service\ImportAgentsDn\ImporterAgentsDnFromHDS;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class Db1cImportAgentsDnCommand extends Command
{
    protected static $defaultName = 'db:1c:import-agents-dn';

    private $importerAgentsDn;
    /**
     * @var LoggerInterface
     */
    private $logger;


    public function __construct(ImporterAgentsDnFromHDS $importerAgentsDn, LoggerInterface $logger)
    {
        $this->importerAgentsDn = $importerAgentsDn;
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
        $io = new SymfonyStyle($input, $output);
        try {
            $this->importerAgentsDn->import();
            $io->success('Data import completed successfully');
        } catch (\Throwable $e) {
            $this->logger->error($e->getMessage());
            $io->error('Data importing failed successfully');
        }
    }
}
