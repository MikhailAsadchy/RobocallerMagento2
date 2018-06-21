<?php

namespace rcaller\lib\adapterInterfaces;
interface OptionRepository
{
    public function addOrUpdateOption($name, $value);

    public function removeOption($name);

    public function getOption($name);
}
