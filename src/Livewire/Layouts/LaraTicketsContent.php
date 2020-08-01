<?php

namespace AsayDev\LaraTickets\Livewire\Layouts;

use Livewire\Component;

class LaraTicketsContent extends Component
{
    public $active_nav_title;
    public $active_nav_tab;

    public $show_form;

    public $card_title;


    protected $listeners=['activeNvTab','setActionForm'];

    public function mount($active_nav_tab){
        $this->activeNvTab($active_nav_tab);
    }

    public function openForm($form_name){
        if($form_name=='new_ticket'){
            $this->setActionForm(['name'=>'tickets','action'=>'add']);
            $this->card_title=trans('laratickets::lang.index-my-tickets').': '.trans('laratickets::lang.create-new-ticket');
        }
    }
    /**
     * @param $tabName
     * for opening selected nav
     */
    public function activeNvTab($tabName){
        $this->active_nav_tab=$tabName;
        $this->setActionForm(['name'=>'','action'=>'']); // close opened form
        $this->card_title=trans('laratickets::lang.index-my-tickets');
    }
    /**
     * @param $action
     * for displing crud form
     */
    public function setActionForm($form){
        $this->show_form=$form;
    }
    public function render()
    {
        return view('asaydev-lara-tickets::layouts.content');
    }

}
