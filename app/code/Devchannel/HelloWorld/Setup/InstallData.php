<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Devchannel\Helloworld\Setup;

use Magento\Framework\Setup;

class InstallData implements Setup\InstallDataInterface
{

    /**
     * {@inheritdoc}
     */
    public function install(Setup\ModuleDataSetupInterface $setup, Setup\ModuleContextInterface $moduleContext)
    {
        print "------------------------------------------------------------------------------------------";
        print "run InstallData";
        print "------------------------------------------------------------------------------------------";
    }
}
