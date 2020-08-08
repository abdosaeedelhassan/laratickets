<?php

namespace AsayDev\LaraTickets\Livewire\Components\Tickets;

use AsayDev\LaraTickets\Helpers\TicketsHelper;
use AsayDev\LaraTickets\Models\Category;
use AsayDev\LaraTickets\Models\Priority;
use AsayDev\LaraTickets\Models\Setting;
use AsayDev\LaraTickets\Models\Ticket;
use AsayDev\LaraTickets\Traits\SlimNotifierJs;
use Livewire\Component;

class LaraTicketsForm extends Component
{
    public $dashboardData;

    public $priorities = [];

    public $categories = [];

    /**
     * ticket form fields
     */
    public $subject;
    public $content;
    public $priority_id;
    public $category_id;


    public function mount($dashboardData)
    {
        $this->dashboardData = $dashboardData;
        /**
         * step1: check if no category add default one
         */
        $category=\AsayDev\LaraTickets\Models\Category::first();
        if(!$category){
            \AsayDev\LaraTickets\Models\Category::create([
                'name'=>'Default',
                'color'=>'green'
            ]);
        }
        /**
         * step3: check if no priorty add default one
         */
        $priorty=\AsayDev\LaraTickets\Models\Priority::first();
        if(!$priorty){
            \AsayDev\LaraTickets\Models\Priority::create([
                'name'=>'Default',
                'color'=>'green'
            ]);
        }

        $this->priorities = Priority::all()->pluck('id', 'name')->toArray();
        $this->categories = Category::all()->pluck('id', 'name')->toArray();
        if (sizeof($this->priorities) > 0) {
            $this->priority_id = array_values($this->priorities)[0];
        }
        if (sizeof($this->categories) > 0) {
            $this->category_id = array_values($this->categories)[0];
        }
    }

    public function render()
    {
        return view('asaydev-lara-tickets::forms.ticket');
    }

    public function saveData()
    {

        $data = array(
            'subject' => $this->subject,
            'content' => $this->content,
            'priority_id' => $this->priority_id,
            'category_id' => $this->category_id,
        );


        $this->validate([
            'subject' => 'required|min:3',
            'content' => 'required|min:6',
            'priority_id' => 'required|exists:laratickets_priorities,id',
            'category_id' => 'required|exists:laratickets_categories,id',
        ]);

        $ticket = new Ticket();
        $ticket->subject = $this->subject;
        $ticket->content=$this->content;
        $ticket->html=$this->content;
        $ticket->priority_id = $this->priority_id;
        $ticket->category_id = $this->category_id;
        $default_status = TicketsHelper::getDefaultStatusInSetting('default_status_id');
        $ticket->status_id = $default_status->value;
        $ticket->user_id = auth()->user()->id;
        $ticket->agent_id=$ticket->autoSelectAgent();
        $ticket->save();

        $msg = SlimNotifierJs::prepereNotifyData(SlimNotifierJs::$success, trans('laratickets::lang.btn-create-new-ticket'), trans('laratickets::lang.the-ticket-has-been-created'));
        $this->emit('laratickets-flash-message', $msg);
        $this->goback();

    }

    public function goback()
    {
        $this->emit('activeNvTab', $this->dashboardData);
    }

}
