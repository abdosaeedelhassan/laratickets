<?php

namespace AsayDev\LaraTickets\Tests\Unit;

use AsayDev\LaraTickets\Tests\TestCase;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

class InstallLaraTicketsPackageTest extends TestCase
{
    /** @test */
    function the_install_command_copies_a_the_configuration()
    {
        // make sure we're starting from a clean state
        if (File::exists(config_path('laratickets.php'))) {
            unlink(config_path('laratickets.php'));
        }

        $this->assertFalse(File::exists(config_path('laratickets.php')));

        Artisan::call('laratickets:install');

        $this->assertTrue(File::exists(config_path('laratickets.php')));
    }


}
