<?php
namespace RCaller\Client\Setup;

use Magento\Framework\App\ObjectManager;
use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Variable\Model\Variable;

class InstallSchema implements InstallSchemaInterface
{
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $this->createRcallerCustomVariables();
    }

    private function createRcallerCustomVariables()
    {
        $this->createVariable("rcaller_username", "RCaller Username", "<CHANGE_ME>");
        $this->createVariable("rcaller_password", "RCaller Password", "<CHANGE_ME>");
    }

    private function createVariable($code, $name, $value)
    {
        $userName = ObjectManager::getInstance()->create(Variable::class);
        $userName->setCode($code);
        $userName->setName($name);
        $userName->setPlainValue($value);
        $userName->save();
    }
}
