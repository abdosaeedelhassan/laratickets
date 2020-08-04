<?php

namespace AsayDev\LaraTickets\Livewire;

use AsayDev\LaraTickets\Helpers\TicketsHelper;
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
    public $include_font_awesome;
    public $editor_locale;
    public $editor_options;
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
        $this->editor_enabled = TicketsHelper::getDefaultSetting('editor_enabled', '1')->value;
        $this->codemirror_enabled = TicketsHelper::getDefaultSetting('codemirror_enabled', '1')->value;
        $this->codemirror_theme = TicketsHelper::getDefaultSetting('codemirror_theme', 'monokai')->value;
        $this->include_font_awesome = TicketsHelper::getDefaultSetting('include_font_awesome', '1')->value;
        $this->editor_locale = TicketsHelper::getDefaultSetting('editor_locale', 'en')->value;
        $this->editor_options = file_get_contents(base_path(TicketsHelper::getDefaultSetting('editor_options', 'vendor/asaydev/laratickets/resources/json/summernote_init.json')->value));


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
        } else {
            $this->dashboardData['usertype']='agent';
            $this->dashboardData['active_nav_tab'] = 'active-tickets-tab';
        }

        $this->dashboardData['user_id']=$this->user->id;

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
