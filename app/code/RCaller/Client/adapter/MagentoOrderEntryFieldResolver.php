<?php

namespace rcaller\adapter;
use rcaller\lib\adapterInterfaces\OrderEntryFieldResolver;

class MagentoOrderEntryFieldResolver implements OrderEntryFieldResolver
{
    public function getName($item)
    {
        return $item->getName();
    }

    public function getQuantity($item)
    {
        return $item->getQtyOrdered();
    }

    public function getUnit($item)
    {
        return "шт.";
    }
}
