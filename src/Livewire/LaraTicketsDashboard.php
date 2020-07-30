<?php

namespace AsayDev\LaraTickets\Livewire;

use Livewire\Component;

class LaraTicketsDashboard extends Component
{
    public $testedValue='her we are';

    public function render()
    {
        return view('asaydev-lara-tickets::dashboard');
    }

}