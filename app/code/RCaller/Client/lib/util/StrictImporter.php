<?php

namespace rcaller\lib\util;
class StrictImporter
{
    public static function importFiles($files)
    {
        foreach ($files as $file) {
//            echo "importing file: " . $file . "\r\n<br/>";
            require_once($file);
//            echo "imported file: " . $file . "\r\n<br/>";
        }
    }
}
