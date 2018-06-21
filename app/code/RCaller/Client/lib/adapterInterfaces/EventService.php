<?php

namespace rcaller\lib\adapterInterfaces;
interface EventService
{
    public function subscribePlaceOrderEvent($rcallerClient, $logger);

    public function unsubscribePlaceOrderEvent();
}
