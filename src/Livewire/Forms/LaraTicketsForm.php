<?php

namespace AsayDev\LaraTickets\Livewire\Forms;

use Livewire\Component;

class LaraTicketsForm extends Component
{
    public $form;

    public $priorities=[];

    public $categories=[];

    /**
     * ticket form fields
     */
    public $subject;
    public $content;
    public $priority_id;
    public $category_id;



    public function mount($form){
        $this->form=$form;
    }
    public function render()
    {
        return view('asaydev-lara-tickets::forms.ticket');
    }

    public function saveData(){
        $this->emit('laratickets-flash-message',['type'=>'danger','title'=>'title her','message'=>'her we are']);
        $this->goback();
    }
    public function goback(){
        $this->emit('activeNvTab',$this->form['active_nav_tab']);
    }

}
