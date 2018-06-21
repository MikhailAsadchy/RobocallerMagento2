<?php

namespace rcaller\adapter;
use rcaller\lib\ioc\RCallerDependencyContainer;

class MagentoAdaptedIOC
{
    /**
     * @var RCallerDependencyContainer
     */
    private static $ioc;

    public static function getIOC()
    {
        if (self::$ioc == null) {
            self::$ioc = new RCallerDependencyContainer(new MagentoEventService(), new MagentoLogger(), new MagentoOptionRepository(), new MagentoChannelNameProvider(), new MagentoOrderEntryFieldResolver());
        }
        return self::$ioc;
    }
}
