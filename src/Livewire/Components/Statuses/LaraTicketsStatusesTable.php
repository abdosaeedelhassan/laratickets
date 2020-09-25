<?php

namespace AsayDev\LaraTickets\Livewire\Components\Statuses;

use AsayDev\LaraTickets\Livewire\BaseLivewire;
use AsayDev\LaraTickets\Models\Agent;
use AsayDev\LaraTickets\Models\Setting;
use AsayDev\LaraTickets\Models\Status;
use AsayDev\LaraTickets\Models\Ticket;
use AsayDev\LaraTickets\Traits\SlimNotifierJs;
use Livewire\Component;
use Illuminate\Database\Eloquent\Builder;

use Rappasoft\LaravelLivewireTables\Views\Column;

class LaraTicketsStatusesTable extends BaseLivewire
{
    public $dashboardData;


    public function mount($dashboardData)
    {
        $this->dashboardData=$dashboardData;
    }

    public function query(): Builder
    {
        return Status::orderBy('id', 'asc');
    }
    /**
     * @inheritDoc
     */
    public function columns(): array
    {

        $columns = [
            Column::make(trans('laratickets::admin.table-id'), 'id')
                ->sortable()
                ->searchable()
            ,
            Column::make(trans('laratickets::admin.table-name'))
                ->format(function(Status $model) {
                    return view('asaydev-lara-tickets::components.statuses.name', ['column' => $model]);
                })
                ->sortable()
            ,
            Column::make(trans('laratickets::admin.category-create-color'),'color')
                ->sortable(),
            Column::make(trans('laratickets::admin.table-action'))
                ->format(function(Status $model) {
                    return view('asaydev-lara-tickets::components.admins.actions', ['column' => $model]);
                })
                ->sortable()
            ,
        ];


        return $columns;
    }


    public function delete($id){
        try {
            Status::where('id',$id)->delete();
            $msg = SlimNotifierJs::prepereNotifyData(SlimNotifierJs::$success,$this->dashboardData['active_nav_title'], trans('laratickets::lang.table-deleted-success'));
            $this->emit('laratickets-flash-message', $msg);
        }catch (\Exception $e){
            //
        }
    }

    public function viewStatus($id){
        $this->dashboardData['form']=['name'=>'statuses','action'=>'edit','id'=>$id];
        $this->dashboardData['active_nav_title']=trans('laratickets::admin.status-index-title').': '.trans('laratickets::lang.table-edit-title');
        $this->emit('activeNvTab', $this->dashboardData);
    }


}
