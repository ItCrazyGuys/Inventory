<?php
namespace App\Service;

/**
 * Interface for importing data
 *
 * @package App\Service
 */
interface Importer
{
    /**
     * Import data
     *
     * @return mixed
     */
    public function import();
}
