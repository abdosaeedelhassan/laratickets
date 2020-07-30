<?php

namespace AsayDev\LaraTickets\Livewire;

use Livewire\Component;

class LaraTicketsNav extends Component
{
    public $user;

    public function mount($user_id){

    }
    public function render()
    {
        return view('asaydev-lara-tickets::layouts.nav');
    }

}
