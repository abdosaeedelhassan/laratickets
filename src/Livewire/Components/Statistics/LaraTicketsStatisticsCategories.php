<?php

namespace AsayDev\LaraTickets\Livewire\Components\Statistics;

use AsayDev\LaraTickets\Models\Category;
use Livewire\Component;

class LaraTicketsStatisticsCategories extends Component
{

    public function mount()
    {
    }

    public function render()
    {
        return view('asaydev-lara-tickets::components.statistics.categories', [
            'categories' => Category::paginate(10, ['*'], 'cat_page'),
        ]);
    }
}
