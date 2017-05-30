<?php

namespace AoContacts;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{

    public function boot()
    {
        $this->publishes([
            __DIR__ . '/Utils/Migrations' => database_path('migrations'),
            __DIR__ . '/Utils/Seeders' => database_path('seeds')
        ]);
    }

    public function register()
    {

    }

}