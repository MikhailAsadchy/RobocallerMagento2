<?php

namespace rcaller\adapter;
use rcaller\lib\adapterInterfaces\EventService;

class MagentoEventService implements EventService
{
    public function subscribePlaceOrderEvent($rcallerClient, $logger)
    {
        // events should be defined using xml (so, it is done here RCaller/Client/etc/events.xml)
    }

    public function unsubscribePlaceOrderEvent()
    {
        // events should be defined using xml (so, it is done here RCaller/Client/etc/events.xml)
        // we do not need to unsubscribe
    }
}
