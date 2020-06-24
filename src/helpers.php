<?php

use Febalist\Laravel\Cached\Cached;

if (!function_exists('cached')) {
    function cached($key, $default = null, $driver = null)
    {
        return new Cached($key, $default, $driver);
    }
}

if (!function_exists('stored')) {
    /** @deprecated */
    function stored($key, $default = null)
    {
        return cached($key, $default, 'database');
    }
}
