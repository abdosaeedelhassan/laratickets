<?php

namespace AsayDev\LaraTickets\Livewire\Layouts;

use Livewire\Component;

class LaraTicketsContent extends Component
{
    public $active_nav_title;
    public $active_nav_tab;

    protected $listeners=['activeNvTab'];

    public function mount($active_nav_tab){
        $this->active_nav_tab=$active_nav_tab;
        $this->setActiveNaveTitle();
    }

    public function activeNvTab($tabName){
        $this->active_nav_tab=$tabName;
        $this->setActiveNaveTitle();
    }

    public function setActiveNaveTitle(){
        if($this->active_nav_tab=='main-tab'){
            $this->active_nav_title='sdsdsd';
        }else if($this->active_nav_tab=='active-tickets-tab'){
            $this->active_nav_title='sdsdsd';
        }
    }

    public function render()
    {
        return view('asaydev-lara-tickets::layouts.content');
    }

}
