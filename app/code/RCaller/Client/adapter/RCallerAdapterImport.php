<?php

namespace rcaller\adapter;
use rcaller\lib\util\StrictImporter;

class RCallerAdapterImport
{
    public static function importAdapter()
    {
        $files = array();

        $currentFileLocation = dirname(__FILE__);
        array_push($files, $currentFileLocation . "/MagentoChannelNameProvider.php");
        array_push($files, $currentFileLocation . "/MagentoEventService.php");
        array_push($files, $currentFileLocation . "/MagentoLogger.php");
        array_push($files, $currentFileLocation . "/MagentoOptionRepository.php");
        array_push($files, $currentFileLocation . "/MagentoOrderEntryFieldResolver.php");

        StrictImporter::importFiles($files);
    }
}
