<?php

namespace marcusvbda\zoop;

use Illuminate\Support\ServiceProvider;

class ZoopServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/config' => config_path(),
        ]);
    }
}
