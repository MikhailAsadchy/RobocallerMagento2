<?php
namespace Devchannel\HelloWorld\Setup;

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
        print "------------------------------------------------------------------------------------------";
        print "run InstallSchema::install()";
        print "------------------------------------------------------------------------------------------";

        $userName = ObjectManager::getInstance()->create(Variable::class);
        $userName->setCode("rcaller_username");
        $userName->setName("RCaller Username");
        $userName->setPlainValue("<CHANGE_ME>");
        $userName->save();

        $password = ObjectManager::getInstance()->create(Variable::class);
        $password->setCode("rcaller_password");
        $password->setName("RCaller Password");
        $password->setPlainValue("<CHANGE_ME>");
        $password->save();
    }
}
