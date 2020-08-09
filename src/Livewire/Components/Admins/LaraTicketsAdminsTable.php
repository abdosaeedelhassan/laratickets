<?php

namespace AsayDev\LaraTickets\Livewire\Components\Admins;

use AsayDev\LaraTickets\Livewire\BaseLivewire;
use AsayDev\LaraTickets\Models\Agent;
use Livewire\Component;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\Views\Column;

class LaraTicketsAdminsTable extends BaseLivewire
{


    public function mount($dashboardData){
        $this->dashboardData=$dashboardData;
    }

    public function query(): Builder
    {
        return  Agent::where('laratickets_admin', '1');
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
                ->view('asaydev-lara-tickets::components.admins.fullname', 'column')
                ->sortable()
            ,
            Column::make(trans('laratickets::admin.table-action'))
                ->view('asaydev-lara-tickets::components.admins.actions', 'column')
                ->sortable()
            ,
        ];


        return $columns;
    }


    public function delete($id){
        //
    }

}
