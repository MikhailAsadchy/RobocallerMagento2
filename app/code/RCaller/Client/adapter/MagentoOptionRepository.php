<?php

namespace rcaller\adapter;
use rcaller\lib\adapterInterfaces\OptionRepository;
use Magento\Framework\App\ObjectManager;
use Magento\Variable\Model\Variable;

class MagentoOptionRepository implements OptionRepository
{
    public function addOrUpdateOption($name, $value)
    {
        $option = $this->getOptionInternal($name);
        if ($this->doesOptionExist($option)) {
            $this->updateOption($option, $value);
        } else {
            $this->createOption($name, $name, $value);
        }
    }

    public function removeOption($name)
    {
        $option = $this->getOptionInternal($name);
        if ($this->doesOptionExist($option)) {
            $variableResourceManager = ObjectManager::getInstance()->get(Variable::class);
            $variableResourceManager->delete($option);
        }
    }

    public function getOption($name)
    {
        $option = $this->getOptionInternal($name);
        return $option->getValue('plain');
    }

    private function createOption($code, $name, $value)
    {
        $option = ObjectManager::getInstance()->create(Variable::class);
        $option->setCode($code);
        $option->setName($name);
        $option->setPlainValue($value);
        $option->save();
    }

    /**
     * @param $name
     * @return Variable
     */
    private function getOptionInternal($name)
    {
        $variable = ObjectManager::getInstance()->get(Variable::class);
        $option = $variable->loadByCode($name);
        return $option;
    }

    /**
     * @param Variable $option
     * @param mixed $value
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    private function updateOption($option, $value)
    {
        $option->setPlainValue($value);
        $variableResourceManager = ObjectManager::getInstance()->get(Variable::class);
        $variableResourceManager->save($option);

    }

    /**
     * @param $option
     * @return bool
     */
    private function doesOptionExist($option)
    {
        $data = $option->getData();
        return $data != null && $data["variable_id"] != null;
    }
}
