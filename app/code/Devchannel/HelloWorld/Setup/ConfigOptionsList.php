<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Devchannel\Helloworld\Setup;

use Magento\Framework\Config\ConfigOptionsListConstants;
use Magento\Framework\Setup\ConfigOptionsListInterface;
use Magento\Framework\App\DeploymentConfig;
use Magento\Framework\Config\Data\ConfigData;
use Magento\Framework\Config\File\ConfigFilePool;
use Magento\Framework\Setup\Option;
use Magento\Framework\Setup\Option\SelectConfigOption;
use Magento\Framework\Setup\Option\TextConfigOption;
use Magento\Setup\Validator\RedisConnectionValidator;

/**
 * Deployment configuration options for the default cache
 */
class ConfigOptionsList implements ConfigOptionsListInterface
{

    /**
     * Gets a list of input options so that user can provide required
     * information that will be used in deployment config file
     *
     * @return Option\AbstractConfigOption[]
     */
    public function getOptions()
    {
        print "------------------------------------------------------------------------------------------";
        print "run ConfigOptionsList::getOptions()";
        print "------------------------------------------------------------------------------------------";
        $options = [];
        return $options;
    }

    /**
     * Creates array of ConfigData objects from user input data.
     * Data in these objects will be stored in array form in deployment config file.
     *
     * @param array $options
     * @param DeploymentConfig $deploymentConfig
     * @return \Magento\Framework\Config\Data\ConfigData[]
     */
    public function createConfig(array $options, DeploymentConfig $deploymentConfig)
    {
        print "------------------------------------------------------------------------------------------";
        print "run ConfigOptionsList::createConfig()";
        print "------------------------------------------------------------------------------------------";
        $configData = [];
        return $configData;
    }

    /**
     * Validates user input option values and returns error messages
     *
     * @param array $options
     * @param DeploymentConfig $deploymentConfig
     * @return string[]
     */
    public function validate(array $options, DeploymentConfig $deploymentConfig)
    {
        print "------------------------------------------------------------------------------------------";
        print "run ConfigOptionsList::createConfig()";
        print "------------------------------------------------------------------------------------------";
        $errors = [];
        return $errors;
    }
}
