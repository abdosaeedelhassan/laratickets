<?php

namespace AsayDev\LaraTickets\Livewire\Components\Configuration;

use AsayDev\LaraTickets\Helpers\TicketsHelper;
use AsayDev\LaraTickets\Models\Setting;
use AsayDev\LaraTickets\Traits\SlimNotifierJs;
use Livewire\Component;

class LaraTicketsConfigurationForm extends Component
{

    public $auto_closing_ticket_period;
    public $number_of_tickets_open_to_user;


    public function initSettings()
    {
        $this->auto_closing_ticket_period = TicketsHelper::getSetting('auto_closing_ticket_period', 72);
        $this->number_of_tickets_open_to_user = TicketsHelper::getSetting('number_of_tickets_open_to_user', 3);
    }

    public function render()
    {
        return view('asaydev-lara-tickets::components.configuration');
    }

    public function saveData()
    {

        TicketsHelper::saveSetting('auto_closing_ticket_period', $this->auto_closing_ticket_period);
        TicketsHelper::saveSetting('number_of_tickets_open_to_user', $this->number_of_tickets_open_to_user);

        $msg = SlimNotifierJs::prepereNotifyData(SlimNotifierJs::$success, __('Configurations'), trans('laratickets::lang.table-saved-success'));
        $this->emit('laratickets-flash-message', $msg);
    }
}
