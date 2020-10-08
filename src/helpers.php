<?php

use Febalist\Laravel\Cached\Cached;

if (!function_exists('cached')) {
    function cached($key, $default = null, $driver = null)
    {
        return new Cached($key, $default, $driver);
    }
}
