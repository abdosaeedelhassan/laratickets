<?php

namespace AsayDev\LaraTickets\Livewire\Components\Configuration;

use AsayDev\LaraTickets\Helpers\TicketsHelper;
use AsayDev\LaraTickets\Models\Category;
use AsayDev\LaraTickets\Models\Priority;
use AsayDev\LaraTickets\Models\Setting;
use AsayDev\LaraTickets\Models\Ticket;
use AsayDev\LaraTickets\Traits\SlimNotifierJs;
use Livewire\Component;

class LaraTicketsConfigurationForm extends Component
{

    public $dashboardData;

    public $lang;
    public $slug;
    public $value;
    public $default=''; // init value

    public $sett_id; // for edit action

    public function mount($dashboardData)
    {
        $this->dashboardData = $dashboardData;
        if ($this->dashboardData['form']['action'] == 'edit') {
            $sett=Setting::where('id',$this->dashboardData['form']['id'])->first();
            if($sett){
                $this->sett_id=$sett->id;
                $this->lang=$sett->lang;
                $this->value=$sett->value;
                $this->slug=$sett->slug;
                $this->default=$sett->default;
            }
        }
    }

    public function render()
    {
        return view('asaydev-lara-tickets::components.configuration.form');
    }

    public function saveData()
    {

        $data = array(
            'lang' => $this->lang,
            'slug' => $this->slug,
            'value' => $this->value,
            'default' => $this->default,
        );

        $this->validate([
            'lang' => 'required|min:2',
            'slug' => 'required|min:3',
            'value' => 'required|min:1',
            'default' => 'required|min:1',
        ]);
        if ($this->dashboardData['form']['action'] == 'add') {
            Setting::create($data);
        }else{ // edit
            Setting::where('id',$this->sett_id)->update($data);
        }

        $msg = SlimNotifierJs::prepereNotifyData(SlimNotifierJs::$success,$this->dashboardData['active_nav_title'], trans('laratickets::lang.table-saved-success'));
        $this->emit('laratickets-flash-message', $msg);
        $this->goback();

    }

    public function goback()
    {
        $this->dashboardData['form']=['name'=>'','action'=>'','id'=>''];
        $this->emit('activeNvTab', $this->dashboardData);
    }



}
