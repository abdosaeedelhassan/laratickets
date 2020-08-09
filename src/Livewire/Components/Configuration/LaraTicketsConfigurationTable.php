<?php

namespace AsayDev\LaraTickets\Livewire\Components\Configuration;

use AsayDev\LaraTickets\Livewire\BaseLivewire;
use AsayDev\LaraTickets\Models\Agent;
use AsayDev\LaraTickets\Models\Category;
use AsayDev\LaraTickets\Models\Setting;
use AsayDev\LaraTickets\Models\Ticket;
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

    public function viewStatus($id){
        $this->dashboardData['prev_nav_tab']=$this->dashboardData['active_nav_tab'];
        $this->dashboardData['active_nav_tab']='configuration-viewer';
        $this->dashboardData['configuration_id']=$id;
        $this->emit('activeNvTab', $this->dashboardData);
    }




}
