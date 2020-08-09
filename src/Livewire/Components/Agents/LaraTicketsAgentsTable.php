<?php

namespace AsayDev\LaraTickets\Livewire\Components\Agents;

use AsayDev\LaraTickets\Livewire\BaseLivewire;
use AsayDev\LaraTickets\Models\Agent;
use Livewire\Component;
use Illuminate\Database\Eloquent\Builder;

use Rappasoft\LaravelLivewireTables\Views\Column;

class LaraTicketsAgentsTable extends BaseLivewire
{
    public $dashboardData;


    public function mount($dashboardData)
    {
        $this->dashboardData=$dashboardData;
    }

    public function query(): Builder
    {
        return Agent::orderBy('id', 'asc');
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

    public function viewStatus($id){
        $this->dashboardData['prev_nav_tab']=$this->dashboardData['active_nav_tab'];
        $this->dashboardData['active_nav_tab']='agent-viewer';
        $this->dashboardData['agent_id']=$id;
        $this->emit('activeNvTab', $this->dashboardData);
    }


}
