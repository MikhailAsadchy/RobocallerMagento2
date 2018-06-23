<?php
namespace RCaller\Client\Setup;

use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\UninstallInterface;
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
class UninstallSchema implements UninstallInterface
{

    /**
     * Invoked when remove-data flag is set during module uninstall.
     *
     * @param SchemaSetupInterface $setup
     * @param ModuleContextInterface $context
     * @return void
     */
    public function uninstall(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        MagentoAdaptedIOC::getIOC()->getPluginManager()->removeOptions();
    }
}
