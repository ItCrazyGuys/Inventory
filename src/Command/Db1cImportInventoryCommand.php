<?php

namespace App\Command;

use App\Service\Cleaner\CleanerService;
use App\Service\Import1C\Appliance1cImporterService;
use App\Service\Import1C\InventoryItems1cImporterService;
use App\Service\Import1C\Module1cImporterService;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class Db1cImportInventoryCommand extends ContainerAwareCommand
{
    protected static $defaultName = 'db:1c:import-inventory';

    private const MEMORY_LIMIT = '1024M';
    private const ENV_DEV = 'dev';

    private $importerInventoryItems;
    private $cleanerService;
    private $importerAppliance1C;
    private $importerModule1C;
    private $logger;


    /**
     * Db1cImportInventoryCommand constructor.
     * @param InventoryItems1cImporterService $importerInventoryItems
     * @param CleanerService $cleanerService
     * @param Appliance1cImporterService $importerAppliance1C
     * @param Module1cImporterService $importerModule1C
     * @param LoggerInterface $inventoryLogger
     */
    public function __construct(InventoryItems1cImporterService $importerInventoryItems, CleanerService $cleanerService, Appliance1cImporterService $importerAppliance1C, Module1cImporterService $importerModule1C, LoggerInterface $inventoryLogger)
    {
        $this->importerInventoryItems = $importerInventoryItems;
        $this->cleanerService = $cleanerService;
        $this->importerAppliance1C = $importerAppliance1C;
        $this->importerModule1C = $importerModule1C;
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
            $this->importerInventoryItems->import();
            $this->cleanerService->clean();
            $this->importerAppliance1C->import();
            $this->importerModule1C->import();

            $io->success('Data import completed successfully');
        } catch (\Throwable $e) {
            $this->logger->error($e->getMessage());
            $io->error('Data importing failed successfully');
        }
    }
}
