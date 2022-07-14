<?php

namespace AsayDev\LaraTickets\Livewire\Components\Statistics;

use AsayDev\LaraTickets\Models\Agent;
use Livewire\Component;

class LaraTicketsStatisticsUsers extends Component
{

    public function mount()
    {
    }

    public function render()
    {
        return view('asaydev-lara-tickets::components.statistics.users', [
            'users' => Agent::where('laratickets_agent', '0')->paginate(10),
        ]);
    }
}
