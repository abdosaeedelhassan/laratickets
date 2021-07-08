<?php

namespace AsayDev\LaraTickets\Livewire\Components\Tickets;

use AsayDev\LaraTickets\Helpers\TicketsHelper;
use AsayDev\LaraTickets\Livewire\BaseLivewire;
use AsayDev\LaraTickets\Models\Agent;
use AsayDev\LaraTickets\Models\Ticket;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\Builder;

use Livewire\WithPagination;
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
        if ($this->dashboardData['model'] == 'all') {
            if ($complete) {
                $collection = $collection->whereNotNull('completed_at');
            } else {
                $collection = $collection->whereNull('completed_at');
            }
        }

        return $collection;
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
            Column::make(trans('laratickets::lang.table-subject'))
                ->format(function ($value, $column, $row) {
                    $html = '<a class="btn btn-link" wire:click="viewTicket(' . $row->id . ')">' . $row->subject . '</a>';
                    return $html;
                })->asHtml()
        ];


        if ($this->dashboardData['model'] != 'all') {
            array_push($columns, Column::make(trans('laratickets::lang.table-type'))
                ->format(function ($value, $column, $row) {
                    if ($row->completed_at) {
                        return trans('laratickets::lang.nav-completed-tickets');
                    } else {
                        return trans('laratickets::lang.nav-active-tickets');
                    }
                })->asHtml()
            );
        }

        array_push($columns, Column::make(trans('laratickets::lang.table-status'))
            ->format(function ($value, $column, $row) {
                $html = '<div>' . TicketsHelper::getTicketStatusLabel($row->status) . '</div>';
                return $html;
            })->asHtml()
        );
        array_push($columns, Column::make(trans('laratickets::lang.table-last-updated'))
            ->format(function ($value, $column, $row) {
                return $row->updated_at->diffForHumans();
            })->asHtml()
        );
        array_push($columns, Column::make(trans('laratickets::lang.table-agent'))
            ->format(function ($value, $column, $row) {
                $ticket = \AsayDev\LaraTickets\Models\Ticket::find($row->id);
                return e($ticket->agent->name);
            })->asHtml()
        );

        $user = Agent::find(auth()->user()->id);

        if ($user) {
            if ($user->isAgent() || $user->laratickets_isAdmin()) {
                array_push($columns,
                    Column::make(trans('laratickets::lang.table-priority'))
                        ->format(function ($value, $column, $row) {
                            $html = '<div style="color: ' . $row->priority->color . '">' . e($row->priority->name) . '</div>';
                            return $html;
                        })->asHtml()
                );
                array_push($columns,
                    Column::make(trans('laratickets::lang.table-category'))
                        ->format(function ($value, $column, $row) {
                            $html = '<div style="color: ' . $row->priority->color . '">' . e($row->category->name) . '</div>';
                            return $html;
                        })->asHtml()
                );
                array_push($columns,
                    Column::make(trans('laratickets::lang.createdby'))
                        ->format(function ($value, $column, $row) {
                            if ($row->createdby) {
                                return $row->createdby->name;
                            }
                        })->asHtml()
                );
            }
        }

        array_push($columns, Column::make(trans('laratickets::lang.created_at'), 'created_at')
            ->format(function ($value, $column, $row) {
              return $row->created_at->format('Y-m-d');
            })->sortable()

        );

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
