<?php

namespace AsayDev\LaraTickets\Livewire;

use AsayDev\LaraTickets\Helpers\TicketsHelper;
use AsayDev\LaraTickets\Models\Agent;
use Livewire\Component;
use Livewire\WithPagination;

class LaraTicketsDashboard extends Component
{
    use WithPagination;

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

    protected $listeners = ['setActiveNavTab','activeNvTab','setActionForm','openForm'];


    public function mount($model = '', $modelId = '',$options=[])
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
            'model_id' => $modelId,
            'options' => $options
        );


         $this->user= Agent::find(auth()->user()->id);

         if($this->dashboardData['model']=='all'){
             if ($this->user->laratickets_isAdmin()) {
                 $this->dashboardData['usertype']='admin';
                 $this->dashboardData['active_nav_tab'] = 'main-tab';
             } else {
                 $this->dashboardData['usertype']='agent';
                 $this->dashboardData['active_nav_tab'] = 'active-tickets-tab';
             }
         }else{
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
        if(!isset($dashboardData['form'])){
            $this->dashboardData['form']=['name'=>'','action'=>''];
        }
        if($this->dashboardData['active_nav_tab']=='active-tickets-tab'||$this->dashboardData['active_nav_tab']=='completed-tickets-tab'){
            $this->dashboardData['active_nav_title']=trans('laratickets::lang.index-my-tickets');
        }else if($this->dashboardData['active_nav_tab']=='admin-tab'){
            $this->dashboardData['active_nav_title']=trans('laratickets::admin.administrator-index-title');
        }else if($this->dashboardData['active_nav_tab']=='config-tab'){
            $this->dashboardData['active_nav_title']=trans('laratickets::admin.nav-configuration');
        }else if($this->dashboardData['active_nav_tab']=='category-tab'){
            $this->dashboardData['active_nav_title']=trans('laratickets::admin.category-index-title');
        }else if($this->dashboardData['active_nav_tab']=='agents-tab'){
            $this->dashboardData['active_nav_title']=trans('laratickets::admin.agent-index-title');
        }else if($this->dashboardData['active_nav_tab']=='priorities-tab'){
            $this->dashboardData['active_nav_title']=trans('laratickets::admin.priority-index-title');
        }else if($this->dashboardData['active_nav_tab']=='statuses-tab'){
            $this->dashboardData['active_nav_title']=trans('laratickets::admin.status-index-title');
        }
        // refresh tickets table data
        $this->emit('setDashboardData',$this->dashboardData);
    }

    /**
     * @param $form_name
     * relation to form actions: add, edit, delete
     */
    public function openForm($form_name){
        if($form_name=='new_ticket'){
            $this->dashboardData['active_nav_title']=trans('laratickets::lang.index-my-tickets').': '.trans('laratickets::lang.create-new-ticket');
            $this->setActionForm(['name'=>'tickets','action'=>'add']);
        }else if($form_name=='new_admin'){
            $this->dashboardData['active_nav_title']=trans('laratickets::admin.administrator-index-title').': '.trans('laratickets::admin.btn-create-new-administrator');
            $this->setActionForm(['name'=>'admins','action'=>'add']);
        }else if($form_name=='new_configuration'){
            $this->dashboardData['active_nav_title']=trans('laratickets::admin.nav-configuration').': '.trans('laratickets::admin.config-create-title');
            $this->setActionForm(['name'=>'configuration','action'=>'add']);
        }else if($form_name=='new_category'){
            $this->dashboardData['active_nav_title']=trans('laratickets::admin.category-index-title').': '.trans('laratickets::admin.btn-create-new-category');
            $this->setActionForm(['name'=>'categories','action'=>'add']);
        }else if($form_name=='new_agent'){
            $this->dashboardData['active_nav_title']=trans('laratickets::admin.agent-index-title').': '.trans('laratickets::admin.btn-create-new-agent');
            $this->setActionForm(['name'=>'agents','action'=>'add']);
        }else if($form_name=='new_priority'){
            $this->dashboardData['active_nav_title']=trans('laratickets::admin.priority-index-title').': '.trans('laratickets::admin.btn-create-new-priority');
            $this->setActionForm(['name'=>'priorities','action'=>'add']);
        }else if($form_name=='new_status'){
            $this->dashboardData['active_nav_title']=trans('laratickets::admin.status-index-title').': '.trans('laratickets::admin.btn-create-new-status');
            $this->setActionForm(['name'=>'statuses','action'=>'add']);
        }

    }
    /**
     * @param $dashboardData
     * for opening selected nav
     */
    public function activeNvTab($dashboardData){

        $this->dashboardData=$dashboardData;
        // close opened form
    }
    /**
     * @param $action
     * for displing crud form
     */
    public function setActionForm($form){
        $this->dashboardData['form']=$form;
        $this->emit('setDashboardData',$this->dashboardData);
    }



}
