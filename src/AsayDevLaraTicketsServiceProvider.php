<?php

namespace Asaydev\LaraTickets;

use Illuminate\Support\ServiceProvider;

/**
 * Class AsayDevTicketsServiceProvider.
 */
class AsayDevLaraTicketsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'asaydev-lara-tickets');
    }
}
