<?php

namespace AsayDev\LaraTickets\Livewire\Forms;

use AsayDev\LaraTickets\Helpers\TicketsHelper;
use AsayDev\LaraTickets\Models\Agent;
use AsayDev\LaraTickets\Models\Setting;
use AsayDev\LaraTickets\Models\Ticket;
use AsayDev\LaraTickets\Traits\SlimNotifierJs;
use Livewire\Component;

class LaraTicketsViewer extends Component
{
    public $dashboardData;

    public $user;
    public $ticket;

    public $default_close_status_id;

    public $close_perm;
    public $reopen_perm;

    public function mount($dashboardData)
    {
        $this->dashboardData = $dashboardData;
        $this->user = Agent::where('id', $dashboardData['user_id'])->first();
        $this->ticket = Ticket::where('id', $dashboardData['ticket_id'])->first();

        $setting = TicketsHelper::getDefaultStatusInSetting('default_close_status_id');
        $this->default_close_status_id = $setting->value;

        $this->close_perm = TicketsHelper::permTo($dashboardData['user_id'], $dashboardData['ticket_id'], 'close');
        $this->reopen_perm = TicketsHelper::permTo($dashboardData['user_id'], $dashboardData['ticket_id'], 'reopen');


    }

    public function render()
    {
        return view('asaydev-lara-tickets::forms.ticketviewer');
    }

    public function addAnswer()
    {
       //
    }

    public function editTicket(){
        $this->dashboardData['active_nav_tab']=$this->dashboardData['prev_nav_tab'];
        $this->dashboardData['form']=['name'=>'tickets','action'=>'edit','id'=>$this->ticket->id];
        $this->dashboardData['active_nav_title']=trans('laratickets::lang.index-my-tickets').': '.trans('laratickets::lang.create-new-ticket');
        $this->emit('activeNvTab', $this->dashboardData);
    }
    public function destroyTicket()
    {
        if ($this->user->laratickets_isAdmin()) {
            Ticket::where('id', $this->ticket->id)->delete();
            $msg = SlimNotifierJs::prepereNotifyData(SlimNotifierJs::$success, trans('laratickets::lang.index-my-tickets'), trans('laratickets::lang.the-ticket-has-been-deleted', ['name' => $this->ticket->subject]));
            $this->emit('laratickets-flash-message', $msg);
            $this->goback();
        } else {
            $msg = SlimNotifierJs::prepereNotifyData(SlimNotifierJs::$success, trans('laratickets::lang.index-my-tickets'), 'this operation for admin only');
            $this->emit('laratickets-flash-message', $msg);
        }
    }

    public function goback()
    {
        $this->dashboardData['form'] = ['name' => '', 'action' => ''];
        $this->dashboardData['active_nav_tab'] = $this->dashboardData['prev_nav_tab'];
        $this->emit('activeNvTab', $this->dashboardData);
    }

}
