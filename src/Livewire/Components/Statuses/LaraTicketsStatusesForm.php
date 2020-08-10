<?php

namespace AsayDev\LaraTickets\Livewire\Components\Statuses;

use AsayDev\LaraTickets\Helpers\TicketsHelper;
use AsayDev\LaraTickets\Models\Category;
use AsayDev\LaraTickets\Models\Priority;
use AsayDev\LaraTickets\Models\Setting;
use AsayDev\LaraTickets\Models\Status;
use AsayDev\LaraTickets\Models\Ticket;
use AsayDev\LaraTickets\Traits\SlimNotifierJs;
use Livewire\Component;

class LaraTicketsStatusesForm extends Component
{
    public $dashboardData;

    public $name;
    public $color;

    public $status_id; // for edit action

    public function mount($dashboardData)
    {
        $this->dashboardData = $dashboardData;
        if ($this->dashboardData['form']['action'] == 'edit') {
         $status=Status::where('id',$this->dashboardData['form']['id'])->first();
         if($status){
             $this->status_id=$status->id;
             $this->name=$status->name;
             $this->color=$status->color;
         }
        }
    }

    public function render()
    {
        return view('asaydev-lara-tickets::components.statuses.form');
    }

    public function saveData()
    {

        $data = array(
            'name' => $this->name,
            'color' => $this->color,
        );

        $this->validate([
            'name' => 'required|min:3',
            'color' => 'required|min:3',
        ]);
        if ($this->dashboardData['form']['action'] == 'add') {
            Status::create($data);
        }else{ // edit
            Status::where('id',$this->status_id)->update($data);
        }

        $msg = SlimNotifierJs::prepereNotifyData(SlimNotifierJs::$success,$this->dashboardData['active_nav_title'], trans('laratickets::lang.table-saved-success'));
        $this->emit('laratickets-flash-message', $msg);
        $this->goback();

    }

    public function goback()
    {
        $this->dashboardData['form']=['name'=>'','action'=>'','id'=>''];
        $this->emit('activeNvTab', $this->dashboardData);
    }

}
