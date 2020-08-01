<?php

namespace AsayDev\LaraTickets\Livewire\Forms;

use Livewire\Component;

class LaraTicketsForm extends Component
{
    public $form;

    public $priorities=[];

    public $categories=[];



    public function mount($form){
        $this->form=$form;
    }
    public function render()
    {
        return view('asaydev-lara-tickets::forms.ticket');
    }

    public function goback(){
        $this->emit('activeNvTab',$this->form['active_nav_tab']);
    }

}
