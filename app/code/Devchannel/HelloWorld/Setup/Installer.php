<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Devchannel\Helloworld\Setup;

use Magento\Framework\Setup;
use Magento\CatalogSampleData\Model\Category;
use Magento\CatalogSampleData\Model\Attribute;
use Magento\DownloadableSampleData\Model\Product;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Store\Model\Store;

class Installer implements Setup\SampleData\InstallerInterface
{
    /**
     * {@inheritdoc}
     */
    public function install()
    {
        print "------------------------------------------------------------------------------------------";
        print "run Installer";
        print "------------------------------------------------------------------------------------------";
    }
}
