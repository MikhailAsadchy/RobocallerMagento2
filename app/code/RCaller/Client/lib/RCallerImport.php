<?php

namespace rcaller\lib;
use rcaller\lib\util\StrictImporter;

class RCallerImport
{
    public static function importRCallerLib()
    {
        $files = array();

        $currentFileLocation = dirname(__FILE__);
        array_push($files, $currentFileLocation . "/adapterInterfaces/ChannelNameProvider.php");
        array_push($files, $currentFileLocation . "/adapterInterfaces/EventService.php");
        array_push($files, $currentFileLocation . "/adapterInterfaces/Logger.php");
        array_push($files, $currentFileLocation . "/adapterInterfaces/OptionRepository.php");
        array_push($files, $currentFileLocation . "/adapterInterfaces/OrderEntryFieldResolver.php");
        array_push($files, $currentFileLocation . "/client/RCallerClient.php");
        array_push($files, $currentFileLocation . "/constants/RCallerConstants.php");
        array_push($files, $currentFileLocation . "/constants/RCallerLoggerLevel.php");
        array_push($files, $currentFileLocation . "/dao/credentials/CredentialsManager.php");
        array_push($files, $currentFileLocation . "/dto/formatter/EntryAsStringFormatter.php");
        array_push($files, $currentFileLocation . "/dto/RCallerOrderDtoBuilder.php");
        array_push($files, $currentFileLocation . "/ioc/RCallerDependencyContainer.php");
        array_push($files, $currentFileLocation . "/plugin/RCallerPluginManager.php");
        array_push($files, $currentFileLocation . "/settings/RCallerSettingsPageRenderer.php");
        array_push($files, $currentFileLocation . "/validation/ValidationError.php");
        array_push($files, $currentFileLocation . "/validation/ValidationResult.php");
        array_push($files, $currentFileLocation . "/ui/RCallerFormHelper.php");

        include_once ($currentFileLocation . "/util/StrictImporter.php");
        StrictImporter::importFiles($files);
    }
}
