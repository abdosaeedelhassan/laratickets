<?php

namespace AsayDev\LaraTickets\Livewire\Components\Tickets;

use AsayDev\LaraTickets\Helpers\GlobalHelper;
use AsayDev\LaraTickets\Helpers\TicketsHelper;
use AsayDev\LaraTickets\Models\Agent;
use AsayDev\LaraTickets\Models\Category;
use AsayDev\LaraTickets\Models\Priority;
use AsayDev\LaraTickets\Models\Setting;
use AsayDev\LaraTickets\Models\Ticket;
use AsayDev\LaraTickets\Traits\SlimNotifierJs;
use Illuminate\Support\Facades\Schema;
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

    // this for edit operation
    public $ticket_id;
    public $agent_id;

    public $users;
    public $user_id;

    protected $listeners = ['selectedUser','setContent'];



    public function setContent($content)
    {
        $this->content = $content;
    }

    public function mount($dashboardData)
    {
        $this->dashboardData = $dashboardData;
        /**
         * step1: check if no category add default one
         */
        $category = \AsayDev\LaraTickets\Models\Category::first();
        if (!$category) {
            \AsayDev\LaraTickets\Models\Category::create([
                'name' => 'Default',
                'color' => 'green'
            ]);
        }
        /**
         * step3: check if no priorty add default one
         */
        $priorty = \AsayDev\LaraTickets\Models\Priority::first();
        if (!$priorty) {
            \AsayDev\LaraTickets\Models\Priority::create([
                'name' => 'Default',
                'color' => 'green'
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

        if ($this->dashboardData['model'] == 'all') {
            $this->users = Agent::all()->pluck(GlobalHelper::getUsersNameField(), 'id')->toArray();
        }

        /**
         * next fired in edit action only
         */
        if ($this->dashboardData['form']['action'] == 'edit') {
            $ticket = Ticket::where('id', $this->dashboardData['form']['id'])->first();
            if ($ticket) {
                $this->ticket_id = $ticket->id;
                $this->subject = $ticket->subject;
                $this->content = $ticket->content;
                $this->priority_id = $ticket->priority_id;
                $this->category_id = $ticket->category_id;
                $this->agent_id = $ticket->agent_id;
            }
        }


    }



    public function initData()
    {
        $this->emit('usersList', '');
        $this->emit('renderContentEditor', '');
    }

    public function selectedUser($id)
    {
        $this->user_id = $id;
    }

    public function updated()
    {
        $this->emit('usersList', '');

    }

    public function render()
    {
        $agents = [];
        if ($this->dashboardData['form']['action'] == 'edit') {
            $agents = Agent::where('laratickets_agent', 1)->get()->pluck('id', 'full_name');
        }
        return view('asaydev-lara-tickets::forms.ticket', ['agents' => $agents]);
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

        if ($this->dashboardData['model'] == 'all') {
            $this->validate([
                'user_id' => 'required',
            ]);
            $this->dashboardData['model_id'] = $this->user_id;
        }

        if ($this->dashboardData['form']['action'] == 'add') {
            $ticket = new Ticket();
            $ticket->subject = $this->subject;
            $ticket->content = $this->content;
            $ticket->model = $this->dashboardData['model'] == 'all' ? 'general' : $this->dashboardData['model'];
            $ticket->model_id = $this->dashboardData['model_id'];
            $ticket->html = $this->content;
            $ticket->code = TicketsHelper::generateCode(4);
            $ticket->priority_id = $this->priority_id;
            $ticket->category_id = $this->category_id;
            $ticket->status = TicketsHelper::$tickets_new_status;
            $ticket->user_id = $this->dashboardData['model'] == 'all' ? $this->user_id : auth()->user()->id;
            $ticket->agent_id = $ticket->autoSelectAgent();
            $ticket->created_by = auth()->user()->id;
            $ticket->save();
        } else {
            $data = array(
                'subject' => $this->subject,
                'content' => $this->content,
                'priority_id' => $this->priority_id,
                'category_id' => $this->category_id,
                'agent_id' => $this->agent_id,
                'status' => TicketsHelper::$tickets_opened_status
            );
            Ticket::where('id', $this->ticket_id)->update($data);
        }
        $msg = SlimNotifierJs::prepereNotifyData(SlimNotifierJs::$success, trans('laratickets::lang.btn-create-new-ticket'), trans('laratickets::lang.the-ticket-has-been-created'));
        $this->emit('laratickets-flash-message', $msg);
        $this->goback();

    }

    public function goback()
    {
        $this->dashboardData['form'] = ['name' => '', 'action' => '', 'id' => ''];
        $this->emit('activeNvTab', $this->dashboardData);
    }

}
