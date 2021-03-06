<?php
namespace RCaller\Client\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use rcaller\adapter\MagentoAdaptedIOC;
use rcaller\adapter\RCallerAdapterImport;
use rcaller\lib\RCallerImport;

$om = \Magento\Framework\App\ObjectManager::getInstance();
$reader = $om->get('Magento\Framework\Module\Dir\Reader');
$moduleDir = $reader->getModuleDir("", "RCaller_Client");
include_once $moduleDir . "/lib/RCallerImport.php";
include_once $moduleDir . "/adapter/RCallerAdapterImport.php";
RCallerImport::importRCallerLib();
RCallerAdapterImport::importAdapter();
class InstallSchema implements InstallSchemaInterface
{
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        MagentoAdaptedIOC::getIOC()->getPluginManager()->addOptions();
    }
}
