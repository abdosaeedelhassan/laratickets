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
    public $dashboardData = [];

    protected $listeners = ['setActiveNavTab'];


    public function mount($model = '', $model_id = '')
    {
        /**
         * init assets vars
         */
        $this->editor_enabled = Setting::grab('editor_enabled');
        $this->codemirror_enabled = Setting::grab('editor_html_highlighter');
        $this->codemirror_theme = Setting::grab('codemirror_theme');
        /**
         * init dashbaord vars
         */
        $this->dashboardData = array(
            'model' => $model,
            'model_id' => $model_id,
        );

         $this->user= Agent::find(auth()->user()->id);

        if ($this->user->laratickets_isAdmin()) {
            $this->dashboardData['usertype']='admin';
            $this->dashboardData['active_nav_tab'] = 'main-tab';
            $this->dashboardData['active_nav_title']=trans('laratickets::lang.index-title');
        } else {
            $this->dashboardData['usertype']='agent';
            $this->dashboardData['active_nav_tab'] = 'active-tickets-tab';
            $this->dashboardData['active_nav_title']=trans('laratickets::lang.index-my-tickets');
        }

        $this->dashboardData['user']=Agent::find(auth()->user()->id);

        $this->setActiveNavTab($this->dashboardData['active_nav_tab']);


    }

    public function render()
    {
        return view('asaydev-lara-tickets::dashboard');
    }


    /**
     * for changing active nav data from outside
     */
    public function setActiveNavTab($active_nav_tab)
    {
        $this->dashboardData['active_nav_tab']=$active_nav_tab;
        $this->emit('activeNvTab',$this->dashboardData);
    }


}
