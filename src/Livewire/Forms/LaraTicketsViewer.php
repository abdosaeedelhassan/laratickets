<?php

namespace AsayDev\LaraTickets\Livewire\Forms;

use AsayDev\LaraTickets\Helpers\TicketsHelper;
use AsayDev\LaraTickets\Models\Agent;
use AsayDev\LaraTickets\Models\Setting;
use AsayDev\LaraTickets\Models\Ticket;
use Livewire\Component;

class LaraTicketsViewer extends Component
{
    public $dashboardData;

    public $user;
    public $ticket;

    public $default_close_status_id;


    public function mount($dashboardData)
    {
        $this->dashboardData=$dashboardData;
        $this->user=Agent::where('id',$dashboardData['user_id'])->first();
        $this->ticket=Ticket::where('id',$dashboardData['ticket_id'])->first();

        $setting=Setting::where('slug','default_close_status_id')->first();
        if($setting){
            $this->default_close_status_id=$setting->value;
        }else{
            $helper=new TicketsHelper();
            $setting=$helper->initDefaultStatus('default_close_status_id');
            $this->default_close_status_id=$setting->value;
        }

    }

    public function render()
    {
        return view('asaydev-lara-tickets::forms.ticketviewer');
    }

    public function addAnswer()
    {
        //
    }

    public function goback()
    {
        //
    }

}
