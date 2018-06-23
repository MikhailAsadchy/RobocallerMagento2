<?php

namespace rcaller\adapter;
use rcaller\lib\adapterInterfaces\ChannelNameProvider;

class MagentoChannelNameProvider implements ChannelNameProvider
{
    public function getChannelName()
    {
        return "MAGENTO";
    }
}
