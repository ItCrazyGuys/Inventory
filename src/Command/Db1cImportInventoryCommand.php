<?php

namespace App\Command;

use App\InventoryImporter;
use App\Utils\Importer1C;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class Db1cImportInventoryCommand extends ContainerAwareCommand
{
    protected static $defaultName = 'db:1c:import-inventory';

    private $inventoryImporter;
    private $importedCsvResource;
    private $importer1C;
    private $logger;



    public function __construct(InventoryImporter $inventoryImporter, Importer1C $importer1C, $importedCsvResource, LoggerInterface $inventoryLogger)
    {
        $this->inventoryImporter = $inventoryImporter;
        $this->importer1C = $importer1C;
        $this->importedCsvResource = $importedCsvResource;
        $this->logger = $inventoryLogger;
        parent::__construct();
    }

    protected function configure()
    {
        $this->setDescription('Import 1C\'s data of inventorization');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $isSuccess = true;

        try {
            // Get tmp csv file
            $importedCsvResource = $this->importer1C->importCsvFromFTP($this->importedCsvResource);

            // Open tmp csv file
            $resource = fopen($importedCsvResource, 'r');
            while (!feof($resource)) {
                if (!$this->getContainer()->get('doctrine.orm.entity_manager')->isOpen()) {
                    throw new \Exception('Entity manager close');
                }

                // read line from file and import csv
                $this->inventoryImporter->importFromCsv(fgets($resource));
            }
            // Close tmp csv file
            fclose($resource);

            // Delete tmp csv file
            unlink($importedCsvResource);
        } catch (\Throwable $e) {
            $this->logger->error($e->getMessage());
            $isSuccess = false;
        }

        if ($isSuccess) {
            $io->success('Data import completed successfully');
        } else {
            $io->error('Data importing failed successfully');
        }
    }
}
