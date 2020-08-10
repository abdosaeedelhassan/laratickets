<?php

namespace AsayDev\LaraTickets\Livewire\Components\Admins;

use AsayDev\LaraTickets\Helpers\TicketsHelper;
use AsayDev\LaraTickets\Models\Agent;
use AsayDev\LaraTickets\Models\Category;
use AsayDev\LaraTickets\Models\Priority;
use AsayDev\LaraTickets\Models\Setting;
use AsayDev\LaraTickets\Models\Ticket;
use AsayDev\LaraTickets\Traits\SlimNotifierJs;
use Livewire\Component;

class LaraTicketsAdminsForm extends Component
{
    public $dashboardData;

    public $agent_id;



    public function mount($dashboardData)
    {
        $this->dashboardData = $dashboardData;
    }

    public function render()
    {
        return view('asaydev-lara-tickets::components.admins.form',[
            'admins'=>Agent::where('laratickets_admin',0)->where('laratickets_agent', '1')->get()->pluck('id', 'full_name')->toArray()
        ]);
    }

    public function saveData()
    {

        $data = array(
            'agent_id' => $this->agent_id,
        );


        $this->validate([
            'agent_id' => 'required|exists:laratickets_agents,id',
        ]);



        $msg = SlimNotifierJs::prepereNotifyData(SlimNotifierJs::$success, trans('laratickets::lang.btn-create-new-ticket'), trans('laratickets::lang.the-ticket-has-been-created'));
        $this->emit('laratickets-flash-message', $msg);
        $this->goback();

    }

    public function goback()
    {
        $this->emit('activeNvTab', $this->dashboardData);
    }

}
