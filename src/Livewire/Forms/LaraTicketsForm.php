<?php

namespace AsayDev\LaraTickets\Livewire\Forms;

use AsayDev\LaraTickets\Traits\SlimNotifierJs;
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

        $data=array(
          'subject'=>$this->subject,
          'content'=>$this->content,
          'priority_id'=>$this->priority_id,
          'category_id'=>$this->category_id,
        );

        $this->validate([
            'subject' => 'required',
            'content' => 'required',
        ]);

        $msg=SlimNotifierJs::prepereNotifyData(SlimNotifierJs::$success,'title her','message her');
        $this->emit('laratickets-flash-message',$msg);
        
        $this->goback();
    }
    public function goback(){
        $this->emit('activeNvTab',$this->form['active_nav_tab']);
    }

}
