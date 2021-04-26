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
