<?php

namespace AsayDev\LaraTickets\Livewire\Components\Agents;

use AsayDev\LaraTickets\Helpers\TicketsHelper;
use AsayDev\LaraTickets\Models\Agent;
use AsayDev\LaraTickets\Models\Category;
use AsayDev\LaraTickets\Models\Priority;
use AsayDev\LaraTickets\Models\Setting;
use AsayDev\LaraTickets\Models\Ticket;
use AsayDev\LaraTickets\Traits\SlimNotifierJs;
use Livewire\Component;
use Livewire\WithPagination;

class LaraTicketsAgentsForm extends Component
{
    use WithPagination;

    public $dashboardData;

    public $selectedUsers;

    protected $listeners =['renderAgentsList'];

    public function renderAgentsList($parm){
        $this->emit('renderAgentsList',$parm);
    }

    public function mount($dashboardData)
    {
        $this->dashboardData = $dashboardData;
    }

    public function render()
    {
        return view('asaydev-lara-tickets::components.agents.form',[
            'users'=>Agent::where('laratickets_agent',0)->paginate(10)
        ]);
    }

    public function saveData()
    {

        try {
            $this->selectedUsers = array_filter( $this->selectedUsers, function($e) {
                return ($e !== false);
            });
            Agent::whereIn('id',$this->selectedUsers)->update(['laratickets_agent'=>1]);
            $msg = SlimNotifierJs::prepereNotifyData(SlimNotifierJs::$success,$this->dashboardData['active_nav_title'], trans('laratickets::lang.table-saved-success'));
            $this->emit('laratickets-flash-message', $msg);
            $this->goback();
        }catch (\Exception $e){
            //
        }
    }

    public function goback()
    {
        $this->emit('activeNvTab', $this->dashboardData);
    }

}
