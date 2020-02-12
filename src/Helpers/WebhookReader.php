<?php


namespace Smsc\Helpers;


class WebhookReader
{
    public static function read(array $values):bool {
        
    }

    public static function readFromGet(): bool {
        return self::read($_GET);
    }
}
