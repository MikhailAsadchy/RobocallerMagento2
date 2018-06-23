<?php

namespace rcaller\adapter;
use rcaller\lib\adapterInterfaces\Logger;
use rcaller\lib\constants\RCallerLoggerLevel;

class MagentoLogger implements Logger
{
    public function log($severity, $message)
    {
        if ($severity === RCallerLoggerLevel::ERROR) {
            error_log($message);
        }
    }
}
