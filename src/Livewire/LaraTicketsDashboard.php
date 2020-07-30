<?php

namespace AsayDev\LaraTickets\Livewire;

use AsayDev\LaraTickets\Models\Agent;
use AsayDev\LaraTickets\Models\Setting;
use Livewire\Component;

class LaraTicketsDashboard extends Component
{

    /**
     * @var
     * assets vars
     */
    public $editor_enabled;
    public $codemirror_enabled;
    public $codemirror_theme;
    /**
     * @var
     * dashoard vars
     */
    public $user;
    public $active_nav_tab;


    public function mount($user_id){

        /**
         * init assets vars
         */
        $this->editor_enabled = Setting::grab('editor_enabled');
        $this->codemirror_enabled = Setting::grab('editor_html_highlighter');
        $this->codemirror_theme = Setting::grab('codemirror_theme');
        /**
         * init dashbaord vars
         */
        $this->user=Agent::find($user_id);
        if($this->user->laratickets_isAdmin()){
            $this->active_nav_tab='dashboard-tab';
        }

    }
    public function render()
    {
        return view('asaydev-lara-tickets::dashboard');
    }


    public function setActiveNavTab($tabName){
        $this->active_nav_tab=$tabName;
    }

}
