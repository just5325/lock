<?php
namespace Lock\Lock;

use Predis\Client;

class Lock
{
    public function __construct()
    {
    }

    public static function lock()
    {
        echo "Hello World";
    }
}
