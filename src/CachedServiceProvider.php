<?php

namespace Febalist\Laravel\Cached;

use Illuminate\Support\ServiceProvider;

class CachedServiceProvider extends ServiceProvider
{
    public function boot()
    {

    }

    public function register()
    {
        require_once __DIR__.'/helpers.php';
    }
}
