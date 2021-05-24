<?php

namespace AsayDev\LaraTickets\Livewire;

use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\TableComponent;

class BaseLivewire extends TableComponent
{


    public $loadingIndicator=true;
    public $searchEnabled=true;
    public $paginationTheme='bootstrap';
    public $searchDebounce=400;

    public $primaryKey='id';

    public array $bulkActions = [
        'exportSelected' => 'Export',
    ];


    public function exportSelected()
    {
        //if ($this->selectedRowsQuery->count() > 0) {
            return (new UserExport($this->selectedRowsQuery))->download($this->tableName.'.xlsx');
        //}

        // Not included in package, just an example.
        //$this->notify(__('You did not select any users to export.'), 'danger');
    }


    /**
     * @inheritDoc
     */
    public function query(): Builder
    {
        // TODO: Implement query() method.
    }

    /**
     * @inheritDoc
     */
    public function columns(): array
    {
        // TODO: Implement columns() method.
    }

}
