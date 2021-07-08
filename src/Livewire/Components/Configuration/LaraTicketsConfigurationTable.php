<?php

namespace AsayDev\LaraTickets\Livewire\Components\Configuration;

use AsayDev\LaraTickets\Livewire\BaseLivewire;
use AsayDev\LaraTickets\Models\Agent;
use AsayDev\LaraTickets\Models\Category;
use AsayDev\LaraTickets\Models\Priority;
use AsayDev\LaraTickets\Models\Setting;
use AsayDev\LaraTickets\Models\Ticket;
use AsayDev\LaraTickets\Traits\SlimNotifierJs;
use Livewire\Component;
use Illuminate\Database\Eloquent\Builder;

use Rappasoft\LaravelLivewireTables\Views\Column;

class LaraTicketsConfigurationTable extends BaseLivewire
{


    public $dashboardData;



    public function mount($dashboardData)
    {
        $this->dashboardData=$dashboardData;
    }

    public function query(): Builder
    {
        return Setting::orderBy('id', 'asc');
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
            Column::make(trans('laratickets::admin.table-name'),'slug')
                ->sortable()
                ->searchable()
            ,
            Column::make(trans('laratickets::admin.table-value'))
                ->format(function ($value, $column, $row) {
                    return view('asaydev-lara-tickets::components.configuration.value', ['column' => $row]);
                })
                ->sortable()
                ->searchable()
            ,

            /**
             * curently no need for delete action in configurations
             */

//            Column::make(trans('laratickets::admin.table-action'))
//                ->view('asaydev-lara-tickets::components.configuration.actions', 'column')
//                ->sortable()
//            ,
        ];


        return $columns;
    }


    public function delete($id){
        try {
            Setting::where('id',$id)->delete();
            $msg = SlimNotifierJs::prepereNotifyData(SlimNotifierJs::$success,$this->dashboardData['active_nav_title'], trans('laratickets::lang.table-deleted-success'));
            $this->emit('laratickets-flash-message', $msg);
        }catch (\Exception $e){
            //
        }
    }

    public function viewConfig($id){
        $this->dashboardData['form']=['name'=>'configuration','action'=>'edit','id'=>$id];
        $this->dashboardData['active_nav_title']=trans('laratickets::admin.configuration-index-title').': '.trans('laratickets::lang.table-edit-title');
        $this->emit('activeNvTab', $this->dashboardData);
    }




}
