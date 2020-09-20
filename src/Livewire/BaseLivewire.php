<?php

namespace AsayDev\LaraTickets\Livewire;

use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Rappasoft\LaravelLivewireTables\TableComponent;

class BaseLivewire extends TableComponent
{

    public $loadingIndicator;
    public $loadingMessage;
    public $searchEnabled;

    /**
     * next props added by abdosaeed
     */
    //private $isLoading=false;

    public function setIsLoading($status){
        $this->isLoading= $status;
        $this->emit('isLoading',$status);
    }



    public function setTranslationStrings()
    {
        $this->loadingIndicator=true;
        $this->loadingMessage = __('labels.general.loading_message');
        $this->searchEnabled=true;

        $this->offlineMessage = __('labels.ggeneral.offline_message');
        $this->noResultsMessage = __('labels.general.no_results');
        $this->perPageLabel = __('labels.general.per_page');
        $this->searchLabel = __('labels.general.search_her');
        $this->shownLabel= __('labels.general.shown_label');
        $this->resultsLable= __('labels.general.result_label');
        $this->outOfLabel= __('labels.general.outof_label');
        $this->toLabel= __('labels.general.to_label');
        $this->searchDebounce=400;
        $this->searchType='lazy';
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
