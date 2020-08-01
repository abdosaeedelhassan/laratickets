<?php

namespace AsayDev\LaraTickets\Livewire\Components;

use AsayDev\LaraTickets\Helpers\TicketsHelper;
use AsayDev\LaraTickets\Models\Setting;
use AsayDev\LaraTickets\Models\Ticket;
use Livewire\Component;

class LaraTickets extends Component
{
    protected $tickets_type;
    public function mount($tickets_type){
        $this->tickets_type=$tickets_type;
    }
    public function render()
    {
        $tickets_helper=new TicketsHelper();
        return view('asaydev-lara-tickets::components.tickets',[
            'tickets'=>$tickets_helper->data($this->tickets_type=='completed'?true:false)
        ]);
    }

}
