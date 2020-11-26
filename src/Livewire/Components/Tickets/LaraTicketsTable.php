<?php

namespace AsayDev\LaraTickets\Livewire\Components\Tickets;

use AsayDev\LaraTickets\Helpers\TicketsHelper;
use AsayDev\LaraTickets\Livewire\BaseLivewire;
use AsayDev\LaraTickets\Models\Agent;
use AsayDev\LaraTickets\Models\Setting;
use AsayDev\LaraTickets\Models\Ticket;
use Livewire\Component;
use Illuminate\Database\Eloquent\Builder;

use Rappasoft\LaravelLivewireTables\Views\Column;

class LaraTicketsTable extends BaseLivewire
{
    public $dashboardData;

    protected $listeners = ['setDashboardData'];

    public function setDashboardData($dashboardData)
    {
        $this->dashboardData = $dashboardData;
    }

    public function mount($dashboardData)
    {
        $this->setDashboardData($dashboardData);
    }

    public function data($complete = false)
    {

        $collection = TicketsHelper::getTicketsCollection($this->dashboardData['model'], $this->dashboardData['model_id']);

        if($this->dashboardData['model']=='all'){
            if ($complete) {
                $collection = $collection->whereNotNull('completed_at');
            } else {
                $collection = $collection->whereNull('completed_at');
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
                'laratickets.completed_at',
                'laratickets_statuses.name AS status',
                'laratickets_statuses.color AS color_status',
                'laratickets_priorities.color AS color_priority',
                'laratickets_categories.color AS color_category',
                'laratickets.id AS agent',
                'laratickets.updated_at AS updated_at',
                'laratickets_priorities.name AS priority',
                'users.name AS owner',
                'laratickets.agent_id',
                'laratickets.created_by',
                'laratickets_categories.name AS category',
            ]);
    }

    public function query(): Builder
    {
        return $this->data(explode('-', $this->dashboardData['active_nav_tab'])[0] == 'completed' ? true : false);

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
                ->format(function(Ticket $model) {
                    return view('asaydev-lara-tickets::components.tickets.subject', ['column' => $model]);
                })
                ->sortable()
            ];


        if($this->dashboardData['model']!='all'){
            array_push($columns,Column::make(trans('laratickets::lang.table-type'))
                ->format(function(Ticket $model) {
                    if ($model->completed_at){
                        return  trans('laratickets::lang.nav-completed-tickets');
                    }else{
                        return trans('laratickets::lang.nav-active-tickets') ;
                    }
                })
                ->sortable());
        }

        array_push($columns, Column::make(trans('laratickets::lang.table-status'))
            ->format(function(Ticket $model) {
                return view('asaydev-lara-tickets::components.tickets.status', ['column' => $model]);
            })
            ->sortable());
        array_push($columns,  Column::make(trans('laratickets::lang.table-last-updated'))
            ->format(function(Ticket $model) {
                return $model->updated_at->diffForHumans();
            })
            ->sortable());
        array_push($columns, Column::make(trans('laratickets::lang.table-agent'))
            ->format(function(Ticket $model) {
                $ticket=\AsayDev\LaraTickets\Models\Ticket::find($model->id);
                return e($ticket->agent->name);
            })
            ->sortable());

        $user = Agent::find(auth()->user()->id);

        if ($user) {
            if ($user->isAgent() || $user->laratickets_isAdmin()) {
                array_push($columns,
                    Column::make(trans('laratickets::lang.table-priority'))
                        ->format(function(Ticket $model) {
                            return view('asaydev-lara-tickets::components.tickets.priority', ['column' => $model]);
                        })
                        ->sortable());
                array_push($columns,
                    Column::make(trans('laratickets::lang.table-owner'), 'owner')
                        ->sortable()
                        ->searchable());
                array_push($columns,
                    Column::make(trans('laratickets::lang.table-category'))
                        ->format(function(Ticket $model) {
                            return view('asaydev-lara-tickets::components.tickets.category', ['column' => $model]);
                        })
                        ->sortable()
                );
                array_push($columns,
                    Column::make(trans('laratickets::lang.createdby'))
                        ->format(function(Ticket $model) {
                            return $model->createdby->name;
                        })
                        ->sortable()
                );
            }
        }

        return $columns;
    }

    public function viewTicket($ticket_id)
    {
        $this->dashboardData['prev_nav_tab'] = $this->dashboardData['active_nav_tab'];
        $this->dashboardData['active_nav_tab'] = 'ticket-viewer';
        $this->dashboardData['ticket_id'] = $ticket_id;
        $this->emit('activeNvTab', $this->dashboardData);
    }


}
