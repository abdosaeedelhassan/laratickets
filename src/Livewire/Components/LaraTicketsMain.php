<?php

namespace AsayDev\LaraTickets\Livewire\Components;

use AsayDev\LaraTickets\Models\Agent;
use AsayDev\LaraTickets\Models\Category;
use AsayDev\LaraTickets\Models\Setting;
use AsayDev\LaraTickets\Models\Ticket;
use Carbon\Carbon;
use Livewire\Component;

class LaraTicketsMain extends Component
{

    public $dashboardData;

    public $tickets_count;
    public $open_tickets_count;
    public $closed_tickets_count;

    public $active_tab;

    public $monthly_performance=[];
    public $categories_share=[];
    public $agents_share=[];




    public function mount($dashboardData){
        $dashboardData['active_nav_title']=trans('laratickets::lang.index-title');
        $this->dashboardData=$dashboardData;
        $this->initData(2);
    }


    public function setActiveTab($tab){
        $this->active_tab=$tab;
    }


    public function initData($indicator_period){


        $this->tickets_count = Ticket::where('model',$this->dashboardData['model'])->where('model_id',$this->dashboardData['model_id'])->count();
        $this->open_tickets_count = Ticket::where('model',$this->dashboardData['model'])->where('model_id',$this->dashboardData['model_id'])->whereNull('completed_at')->count();
        $this->closed_tickets_count = $this->tickets_count - $this->open_tickets_count;
        $this->setActiveTab('cat');


        // Total tickets counter per category for google pie chart
        $categories_all = Category::all();
        $this->categories_share = [];
        foreach ($categories_all as $cat) {
            $this->categories_share[$cat->name] = $cat->tickets()->where('model',$this->dashboardData['model'])->where('model_id',$this->dashboardData['model_id'])->count();
        }
        // Total tickets counter per agent for google pie chart
       $model=$this->dashboardData['model'];
        $model_id=$this->dashboardData['model_id'];
        $agents_share_obj = Agent::agents()->with(['agentTotalTickets' => function ($query)use($model,$model_id) {
            $query->where('model',$model);
            $query->where('model_id',$model_id);
            $query->addSelect(['id', 'agent_id']);
        }])->get();

        $this->agents_share = [];
        foreach ($agents_share_obj as $agent_share) {
            $this->agents_share[$agent_share->name] = $agent_share->agentTotalTickets->where('model',$this->dashboardData['model'])->where('model_id',$this->dashboardData['model_id'])->count();
        }

        foreach ($categories_all as $cat) {
            $this->monthly_performance['categories'][] = $cat->name;
        }

        for ($m = $indicator_period; $m >= 0; $m--) {
            $from = Carbon::now();
            $from->day = 1;
            $from->subMonth($m);
            $to = Carbon::now();
            $to->day = 1;
            $to->subMonth($m);
            $to->endOfMonth();
            $this->monthly_performance['interval'][$from->format('F Y')] = [];
            foreach ($categories_all as $cat) {
                $this->monthly_performance['interval'][$from->format('F Y')][] = round($this->intervalPerformance($from, $to, $cat->id), 1);
            }
        }


        $this->emit('periodChanged',$indicator_period);

    }

    public function intervalPerformance($from, $to, $cat_id = false)
    {
        if ($cat_id) {
            $tickets = Ticket::where('model',$this->dashboardData['model'])->where('model_id',$this->dashboardData['model_id'])->where('category_id', $cat_id)->whereBetween('completed_at', [$from, $to])->get();
        } else {
            $tickets = Ticket::where('model',$this->dashboardData['model'])->where('model_id',$this->dashboardData['model_id'])->whereBetween('completed_at', [$from, $to])->get();
        }

        if (empty($tickets->first())) {
            return false;
        }

        $performance_count = 0;
        $counter = 0;
        foreach ($tickets as $ticket) {
            $performance_count += $this->ticketPerformance($ticket);
            $counter++;
        }
        $performance_average = $performance_count / $counter;

        return $performance_average;
    }


    public function render()
    {
        return view('asaydev-lara-tickets::components.main',[
        'categories' => Category::paginate(10, ['*'], 'cat_page'),
        'agents' => Agent::agents(10),
        'users' => Agent::where('laratickets_agent', '0')->paginate(10, ['*'], 'users_page')
        ]);
    }

}
