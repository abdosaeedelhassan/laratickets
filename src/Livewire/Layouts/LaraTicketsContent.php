<?php

namespace AsayDev\LaraTickets\Livewire\Layouts;

use AsayDev\LaraTickets\Traits\SlimNotifierJs;
use Livewire\Component;

class LaraTicketsContent extends Component
{

    public $dashboardData;


    protected $listeners=['activeNvTab','setActionForm'];

    public function mount($dashboardData){
        $this->activeNvTab($dashboardData);
    }
    /**
     * @param $form_name
     * relation to form actions: add, edit, delete
     */
    public function openForm($form_name){
        if($form_name=='new_ticket'){
            $this->setActionForm(['name'=>'tickets','action'=>'add']);
            $this->dashboardData['active_nav_title']=trans('laratickets::lang.index-my-tickets').': '.trans('laratickets::lang.create-new-ticket');
        }else if($form_name=='new_admin'){
            $this->setActionForm(['name'=>'admins','action'=>'add']);
            $this->dashboardData['active_nav_title']=trans('laratickets::admin.administrator-index-title').': '.trans('laratickets::admin.btn-create-new-administrator');
        }else if($form_name=='new_configuration'){
            $this->setActionForm(['name'=>'configuration','action'=>'add']);
            $this->dashboardData['active_nav_title']=trans('laratickets::admin.nav-configuration').': '.trans('laratickets::admin.config-create-title');
        }else if($form_name=='new_category'){
            $this->setActionForm(['name'=>'categories','action'=>'add']);
            $this->dashboardData['active_nav_title']=trans('laratickets::admin.category-index-title').': '.trans('laratickets::admin.btn-create-new-category');
        }else if($form_name=='new_agent'){
            $this->setActionForm(['name'=>'agents','action'=>'add']);
            $this->dashboardData['active_nav_title']=trans('laratickets::admin.agent-index-title').': '.trans('laratickets::admin.btn-create-new-agent');
        }else if($form_name=='new_priority'){
            $this->setActionForm(['name'=>'agents','action'=>'add']);
            $this->dashboardData['active_nav_title']=trans('laratickets::admin.priority-index-title').': '.trans('laratickets::admin.btn-create-new-priority');
        }else if($form_name=='new_status'){
            $this->setActionForm(['name'=>'statues','action'=>'add']);
            $this->dashboardData['active_nav_title']=trans('laratickets::admin.status-index-title').': '.trans('laratickets::admin.btn-create-new-status');
        }

    }
    /**
     * @param $dashboardData
     * for opening selected nav
     */
    public function activeNvTab($dashboardData){

        $this->dashboardData=$dashboardData;
        // close opened form

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
        $this->emit('setDashboardData',$dashboardData);
    }
    /**
     * @param $action
     * for displing crud form
     */
    public function setActionForm($form){
        $this->dashboardData['form']=$form;
        $this->emit('setDashboardData',$this->dashboardData);
    }

    public function render()
    {
        return view('asaydev-lara-tickets::layouts.content');
    }

}
