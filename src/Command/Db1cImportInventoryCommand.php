<?php

namespace App\Command;

use App\Service\Import1C\ImporterAppliance1CFrom1C;
use App\Service\Import1C\ImporterInventoryItemsFrom1Ccsv;
use App\Service\Import1C\ImporterModule1CFrom1C;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class Db1cImportInventoryCommand extends ContainerAwareCommand
{
    protected static $defaultName = 'db:1c:import-inventory';

    private const MEMORY_LIMIT = '512M';
    private const ENV_DEV = 'dev';

    private $importerInventoryItemsFrom1C;
    private $importerAppliance1CFrom1C;
    private $importerModule1CFrom1C;
    private $logger;


    /**
     * Db1cImportInventoryCommand constructor.
     * @param ImporterInventoryItemsFrom1Ccsv $importerInventoryItemsFrom1Ccsv
     * @param ImporterAppliance1CFrom1C $importerAppliance1CFrom1C
     * @param ImporterModule1CFrom1C $importerModule1CFrom1C
     * @param LoggerInterface $inventoryLogger
     */
    public function __construct(ImporterInventoryItemsFrom1Ccsv $importerInventoryItemsFrom1Ccsv, ImporterAppliance1CFrom1C $importerAppliance1CFrom1C, ImporterModule1CFrom1C $importerModule1CFrom1C, LoggerInterface $inventoryLogger)
    {
        $this->importerInventoryItemsFrom1C = $importerInventoryItemsFrom1Ccsv;
        $this->importerAppliance1CFrom1C = $importerAppliance1CFrom1C;
        $this->importerModule1CFrom1C = $importerModule1CFrom1C;
        $this->logger = $inventoryLogger;
        parent::__construct();
    }

    /**
     * Method for configuration the command
     */
    protected function configure()
    {
        $this->setDescription('Import 1C\'s data of inventorization');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|null|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if (self::ENV_DEV == getenv('APP_ENV')) {
            ini_set('memory_limit', self::MEMORY_LIMIT);
        }

        $io = new SymfonyStyle($input, $output);

        try {

            $this->importerInventoryItemsFrom1C->import();
            $this->importerAppliance1CFrom1C->import();
            $this->importerModule1CFrom1C->import();

            $io->success('Data import completed successfully');
        } catch (\Throwable $e) {
            $this->logger->error($e->getMessage());
            $io->error('Data importing failed successfully');
        }
    }
}
