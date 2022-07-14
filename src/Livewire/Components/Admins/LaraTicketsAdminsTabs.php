<?php

namespace AsayDev\LaraTickets\Livewire\Components\Admins;


use Livewire\Component;

class LaraTicketsAdminsTabs extends Component
{

    public $dashboardData;

    protected $listeners = ['setDashboardData'];

    public function mount($dashboardData)
    {
        $this->setDashboardData($dashboardData);
    }

    public function setDashboardData($dashboardData)
    {
        $this->dashboardData = $dashboardData;
    }

    public function openForm($formName)
    {
        $this->emit('openForm', $formName);
    }

    public function render()
    {
        return view('asaydev-lara-tickets::components.admins.tabs');
    }
}
