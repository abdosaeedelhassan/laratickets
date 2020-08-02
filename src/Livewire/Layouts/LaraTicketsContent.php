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
        }
    }
    /**
     * @param $dashboardData
     * for opening selected nav
     */
    public function activeNvTab($dashboardData){
        $this->dashboardData=$dashboardData;
        // close opened form
        $this->dashboardData['form']=['name'=>'','action'=>''];
        $this->dashboardData['active_nav_title']=trans('laratickets::lang.index-my-tickets');
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
