<?php

namespace AsayDev\LaraTickets\Livewire;

use AsayDev\LaraTickets\Models\Setting;
use Livewire\Component;

class LaraTicketsAssets extends Component
{

    public $editor_enabled;
    public $codemirror_enabled;
    public $codemirror_theme;

    public function render()
    {
        $this->editor_enabled = Setting::grab('editor_enabled');
        $this->codemirror_enabled = Setting::grab('editor_html_highlighter');
        $this->codemirror_theme = Setting::grab('codemirror_theme');
        return view('asaydev-lara-tickets::layouts.assets');
    }

}
