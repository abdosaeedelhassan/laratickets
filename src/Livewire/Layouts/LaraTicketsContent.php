<?php

namespace AsayDev\LaraTickets\Livewire\Layouts;

use Livewire\Component;

class LaraTicketsContent extends Component
{

    /**
     * @var
     * main title
     */
    public $active_nav_title;
    /**
     * @var
     * her in tickets: will be active-tickets-tab or completed-tickets-tab
     */
    public $active_nav_tab;


    public $show_form;


    protected $listeners=['activeNvTab','setActionForm'];

    public function mount($active_nav_tab){
        $this->activeNvTab($active_nav_tab);
    }
    /**
     * @param $form_name
     * relation to form actions: add, edit, delete
     */
    public function openForm($form_name){
        if($form_name=='new_ticket'){
            $this->setActionForm(['name'=>'tickets','action'=>'add']);
            $this->active_nav_title=trans('laratickets::lang.index-my-tickets').': '.trans('laratickets::lang.create-new-ticket');
        }
    }
    /**
     * @param $tabName
     * for opening selected nav
     */
    public function activeNvTab($tabName){
        $this->active_nav_tab=$tabName;
        // close opened form
        $this->setActionForm(['name'=>'','action'=>'']);
        $this->active_nav_title=trans('laratickets::lang.index-my-tickets');
        // refresh tickets table data
        $this->emit('setTicketsType',explode('-',$tabName)[0]);
    }
    /**
     * @param $action
     * for displing crud form
     */
    public function setActionForm($form){
        $this->show_form=$form;
        $this->show_form['active_nav_tab']=$this->active_nav_tab;
    }
    public function render()
    {
        return view('asaydev-lara-tickets::layouts.content');
    }

}
