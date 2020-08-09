<?php

namespace AsayDev\LaraTickets\Livewire\Components\Priorities;

use AsayDev\LaraTickets\Livewire\BaseLivewire;
use AsayDev\LaraTickets\Models\Agent;
use AsayDev\LaraTickets\Models\Setting;
use AsayDev\LaraTickets\Models\Ticket;
use Livewire\Component;
use Illuminate\Database\Eloquent\Builder;

use Rappasoft\LaravelLivewireTables\Views\Column;

class LaraTicketsPrioritiesTable extends BaseLivewire
{
    public $dashboardData;

    protected $listeners=['setDashboardData'];

    public function setDashboardData($dashboardData)
    {
        $this->dashboardData=$dashboardData;
    }

    public function mount($dashboardData)
    {
        $this->setDashboardData($dashboardData);
    }

    public function data($complete = false)
    {
        $user = Agent::find(auth()->user()->id);

        if ($user->laratickets_isAdmin()) {
            if ($complete) {
                $collection = Ticket::complete();
            } else {
                $collection = Ticket::active();
            }
        } elseif ($user->isAgent()) {
            if ($complete) {
                $collection = Ticket::complete()->agentUserTickets($user->id);
            } else {
                $collection = Ticket::active()->agentUserTickets($user->id);
            }
        } else {
            if ($complete) {
                $collection = Ticket::userTickets($user->id)->complete();
            } else {
                $collection = Ticket::userTickets($user->id)->active();
            }
        }
        return $collection
            ->join('users', 'users.id', '=', 'laratickets.user_id')
            ->join('laratickets_statuses', 'laratickets_statuses.id', '=', 'laratickets.status_id')
            ->join('laratickets_priorities', 'laratickets_priorities.id', '=', 'laratickets.priority_id')
            ->join('laratickets_categories', 'laratickets_categories.id', '=', 'laratickets.category_id')
            ->select([
                'laratickets.id',
                'laratickets.subject AS subject',
                'laratickets_statuses.name AS status',
                'laratickets_statuses.color AS color_status',
                'laratickets_priorities.color AS color_priority',
                'laratickets_categories.color AS color_category',
                'laratickets.id AS agent',
                'laratickets.updated_at AS updated_at',
                'laratickets_priorities.name AS priority',
                'users.first_name AS owner',
                'laratickets.agent_id',
                'laratickets_categories.name AS category',
            ]);
    }

    public function query(): Builder
    {
        return $this->data(explode('-',$this->dashboardData['active_nav_tab'])[0] == 'completed' ? true : false);

    }
    /**
     * @inheritDoc
     */
    public function columns(): array
    {
        $columns = [
            Column::make(trans('laratickets::lang.table-id'), 'id')
                ->sortable()
                ->searchable()
            ,
            Column::make(trans('laratickets::lang.table-subject'))
                ->view('asaydev-lara-tickets::components.tickets.subject', 'column')
                ->sortable()
            ,
            Column::make(trans('laratickets::lang.table-status'))
                ->view('asaydev-lara-tickets::components.tickets.status', 'column')
                ->sortable()
            ,
            Column::make(trans('laratickets::lang.table-last-updated'))
                ->view('asaydev-lara-tickets::components.tickets.lastupdate', 'column')
                ->sortable(),
            Column::make(trans('laratickets::lang.table-agent'))
                ->view('asaydev-lara-tickets::components.tickets.agent', 'column')
                ->sortable()
        ];

        $user = Agent::find(auth()->user()->id);

        if ($user) {
            if ($user->isAgent() || $user->laratickets_isAdmin()) {
                array_push($columns,
                        Column::make(trans('laratickets::lang.table-priority'))
                            ->view('asaydev-lara-tickets::components.tickets.priority', 'column')
                            ->sortable());
                array_push($columns,
                        Column::make(trans('laratickets::lang.table-owner'), 'owner')
                            ->sortable()
                            ->searchable());
                array_push($columns,
                        Column::make(trans('laratickets::lang.table-category'))
                            ->view('asaydev-lara-tickets::components.tickets.category', 'column')
                            ->sortable()
                );
            }
        }

        //return $columns;

        return [];
    }

    public function viewTicket($ticket_id){
        $this->dashboardData['prev_nav_tab']=$this->dashboardData['active_nav_tab'];
        $this->dashboardData['active_nav_tab']='ticket-viewer';
        $this->dashboardData['ticket_id']=$ticket_id;
        $this->emit('activeNvTab', $this->dashboardData);
    }


}
