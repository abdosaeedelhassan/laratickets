<?php

namespace AsayDev\LaraTickets\Livewire\Components\Statistics;

use AsayDev\LaraTickets\Models\Agent;
use Livewire\Component;

class LaraTicketsStatisticsAgents extends Component
{

    public function mount()
    {
    }

    public function render()
    {
        return view('asaydev-lara-tickets::components.statistics.agents', [
            'agents' => Agent::agents(10),
        ]);
    }
}
