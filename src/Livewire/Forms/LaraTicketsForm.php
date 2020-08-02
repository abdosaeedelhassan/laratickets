<?php

namespace AsayDev\LaraTickets\Livewire\Forms;

use AsayDev\LaraTickets\Models\Category;
use AsayDev\LaraTickets\Models\Priority;
use AsayDev\LaraTickets\Models\Setting;
use AsayDev\LaraTickets\Models\Ticket;
use AsayDev\LaraTickets\Traits\SlimNotifierJs;
use Livewire\Component;

class LaraTicketsForm extends Component
{
    public $dashboardData;

    public $priorities=[];

    public $categories=[];

    /**
     * ticket form fields
     */
    public $subject;
    public $content;
    public $priority_id;
    public $category_id;



    public function mount($dashboardData){
        $this->dashboardData=$dashboardData;
        $this->priorities=Priority::all()->pluck('id','name')->toArray();
        $this->categories=Category::all()->pluck('id','name')->toArray();
        if(sizeof($this->priorities)>0){
            $this->priority_id=array_values($this->priorities)[0];
        }
        if(sizeof($this->categories)>0) {
            $this->category_id = array_values($this->categories)[0];
        }
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
            'subject'     => 'required|min:3',
            'content'     => 'required|min:6',
            'priority_id' => 'required|exists:laratickets_priorities,id',
            'category_id' => 'required|exists:laratickets_categories,id',
        ]);

        $ticket = new Ticket();

        $ticket->subject = $this->subject;
        $ticket->setPurifiedContent($this->content);
        $ticket->priority_id =$this->priority_id;
        $ticket->category_id = $this->category_id;

        $setting=Setting::where('slug','default_status_id')->first();
        if($setting){
            $ticket->status_id = $setting->value;
        }else{
            $msg=SlimNotifierJs::prepereNotifyData(SlimNotifierJs::$error,trans('laratickets::lang.btn-create-new-ticket'),'No tickets default status found,must be configured firtly');
            $this->emit('laratickets-flash-message',$msg);
            return;
        }

        $ticket->user_id = auth()->user()->id;
        $ticket=$ticket->autoSelectAgent();

        if(is_array($ticket)&&isset($ticket['error'])){
            $msg=SlimNotifierJs::prepereNotifyData(SlimNotifierJs::$error,trans('laratickets::lang.btn-create-new-ticket'),$ticket['error']);
            $this->emit('laratickets-flash-message',$msg);
        }else{
            $ticket->save();
            $msg=SlimNotifierJs::prepereNotifyData(SlimNotifierJs::$success,trans('laratickets::lang.btn-create-new-ticket'),trans('laratickets::lang.the-ticket-has-been-created'));
            $this->emit('laratickets-flash-message',$msg);
            $this->goback();
        }

    }
    public function goback(){
        $this->emit('activeNvTab',$this->dashboardData);
    }

}
