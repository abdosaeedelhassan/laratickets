<?php

namespace AsayDev\LaraTickets\Console;

use Illuminate\Console\Command;

class InstallLaraTicketsPackage extends Command
{
    protected $signature = 'laratickets:install';

    protected $description = 'Install the LaraTickets';

    public function handle()
    {
        $this->info('Installing LaraTickets...');

        $this->info('Publishing configuration...');

        $this->call('vendor:publish', [
            '--provider' => "AsayDev\LaraTickets\AsayDevLaraTicketsServiceProvider",
            '--tag' => "config"
        ]);

        $this->info('Installed LaraTickets');
    }



}
