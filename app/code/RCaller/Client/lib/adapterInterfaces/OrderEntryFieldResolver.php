<?php

namespace rcaller\lib\adapterInterfaces;
interface OrderEntryFieldResolver
{
    public function getName($item);
    public function getQuantity($item);
    public function getUnit($item);
}
