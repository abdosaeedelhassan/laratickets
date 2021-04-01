<?php


namespace AsayDev\LaraTickets\Tests;


use AsayDev\LaraTickets\AsayDevLaraTicketsServiceProvider;

class TestCase extends \Orchestra\Testbench\TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        // additional setup
    }

    protected function getPackageProviders($app)
    {
        return [
            AsayDevLaraTicketsServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        // perform environment setup
    }

}
