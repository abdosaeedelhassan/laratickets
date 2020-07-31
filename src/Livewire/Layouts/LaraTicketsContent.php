<?php

namespace AsayDev\LaraTickets\Livewire\Layouts;

use Livewire\Component;

class LaraTicketsContent extends Component
{
    public $active_nav_tab;


    protected $listeners=['active_nav_tab'=>'setActiveTab'];

    public function mount($active_nav_tab){
        $this->active_nav_tab=$active_nav_tab;
    }

    public function setActiveTab($tabName){
        $this->active_nav_tab=$tabName;
    }


    public function render()
    {


        return view('asaydev-lara-tickets::layouts.content');
    }

}
