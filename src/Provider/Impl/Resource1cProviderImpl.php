<?php

namespace App\Provider\Impl;

use App\Provider\Resource1cProvider;

class Resource1cProviderImpl implements Resource1cProvider
{
    private const TEMP_DIRECTORY = 'tmp';
    private const TEMP_FILE = 'temp_inventory.csv';

    private $remoteServerUrl;
    private $ftpLogin;
    private $ftpPass;
    private $projectDir;
    private $importedCsvResource;


    /**
     * Resource1cProviderImpl constructor.
     * @param $importedCsvResource
     * @param $remoteServerUrl
     * @param $ftpLogin
     * @param $ftpPass
     * @param $projectDir
     */
    public function __construct($importedCsvResource, $remoteServerUrl, $ftpLogin, $ftpPass, $projectDir)
    {
        $this->importedCsvResource = $importedCsvResource;
        $this->remoteServerUrl = $remoteServerUrl;
        $this->ftpLogin = $ftpLogin;
        $this->ftpPass = $ftpPass;
        $this->projectDir = $projectDir;
    }

    /**
     * @return string - local resource name
     */
    public function getResource()
    {
        $localResource = $this->projectDir . DIRECTORY_SEPARATOR . self::TEMP_DIRECTORY . DIRECTORY_SEPARATOR . self::TEMP_FILE;

        $urlItems = parse_url($this->remoteServerUrl);
        $remouteServer = $urlItems['host'];
        $rootPath = $urlItems['path'];
        $importedResource = $rootPath . $this->importedCsvResource;

        $handle = ftp_connect($remouteServer);
        ftp_login($handle, $this->ftpLogin, $this->ftpPass);
        ftp_get($handle, $localResource, $importedResource, FTP_BINARY);
        ftp_close($handle);

        return $localResource;
    }
}
