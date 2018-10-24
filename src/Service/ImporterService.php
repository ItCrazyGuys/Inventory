<?php
namespace App\Service;

/**
 * Interface for importing data
 *
 * @package App\Service
 */
interface ImporterService
{
    /**
     * Import data
     *
     * @return mixed
     */
    public function import();
}
