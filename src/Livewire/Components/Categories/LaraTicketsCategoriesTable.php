<?php

namespace AsayDev\LaraTickets\Livewire\Components\Categories;

use AsayDev\LaraTickets\Livewire\BaseLivewire;
use AsayDev\LaraTickets\Models\Agent;
use AsayDev\LaraTickets\Models\Category;
use AsayDev\LaraTickets\Models\Setting;
use AsayDev\LaraTickets\Models\Ticket;
use Livewire\Component;
use Illuminate\Database\Eloquent\Builder;

use Rappasoft\LaravelLivewireTables\Views\Column;

class LaraTicketsCategoriesTable extends BaseLivewire
{
    public $dashboardData;


    public function mount($dashboardData)
    {
        $this->dashboardData=$dashboardData;
    }

    public function query(): Builder
    {
        return Category::orderBy('id', 'asc');
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
        $this->dashboardData['active_nav_tab']='category-viewer';
        $this->dashboardData['category_id']=$id;
        $this->emit('activeNvTab', $this->dashboardData);
    }



}
