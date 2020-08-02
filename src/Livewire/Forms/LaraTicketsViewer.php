<?php

namespace AsayDev\LaraTickets\Livewire\Forms;

use Livewire\Component;

class LaraTicketsViewer extends Component
{
    public $dashboardData;


    public function mount($dashboardData)
    {
        //
    }

    public function render()
    {
        return view('asaydev-lara-tickets::forms.ticketviewer');
    }

    public function addAnswer()
    {
        //
    }

    public function goback()
    {
        //
    }

}
