<?php

use Febalist\Laravel\Cached\Cached;

if (!function_exists('cached')) {
    function cached($key, $default = null)
    {
        return new Cached($key, $default);
    }
}

if (!function_exists('stored')) {
    function stored($key, $default = null)
    {
        $cached = cached($key, $default);
        $cached->driver = 'database';

        return $cached;
    }
}
