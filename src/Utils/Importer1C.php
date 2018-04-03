<?php

namespace App\Utils;

class Importer1C
{
    private const TEMP_DIRECTORY = 'tmp';
    private const TEMP_FILE = 'temp_inventory.csv';

    private $remoteServerUrl;
    private $ftpLogin;
    private $ftpPass;
    private $projectDir;


    public function __construct($remoteServerUrl, $ftpLogin, $ftpPass, $projectDir)
    {
        $this->remoteServerUrl = $remoteServerUrl;
        $this->ftpLogin = $ftpLogin;
        $this->ftpPass = $ftpPass;
        $this->projectDir = $projectDir;
    }

    public function importCsvFromFTP($importedCsvResource)
    {
        $localResource = $this->projectDir . DIRECTORY_SEPARATOR . self::TEMP_DIRECTORY . DIRECTORY_SEPARATOR . self::TEMP_FILE;

        $urlItems = parse_url($this->remoteServerUrl);
        $remouteServer = $urlItems['host'];
        $rootPath = $urlItems['path'];
        $importedResource = $rootPath . $importedCsvResource;

        $handle = ftp_connect($remouteServer);
        ftp_login($handle, $this->ftpLogin, $this->ftpPass);
        ftp_get($handle, $localResource, $importedResource, FTP_BINARY);
        ftp_close($handle);

        return $localResource;
    }
}
