<?php

namespace AsayDev\LaraTickets\Livewire\Components;

use AsayDev\LaraTickets\Models\Setting;
use Livewire\Component;

class LaraTicketsMain extends Component
{

    public $dashboardData;

    public function mount($dashboardData){
        $dashboardData['active_nav_title']=trans('laratickets::lang.index-title');
        $this->dashboardData=$dashboardData;
    }
    public function render()
    {
        return view('asaydev-lara-tickets::components.main');
    }

}
