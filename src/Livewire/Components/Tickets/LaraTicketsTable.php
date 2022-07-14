<?php

namespace AsayDev\LaraTickets\Livewire\Components\Tickets;

use Illuminate\Database\Eloquent\Builder;
use AsayDev\LaraTickets\Helpers\TicketsHelper;
use AsayDev\LaraTickets\Livewire\BaseLivewire;
use AsayDev\LaraTickets\Models\Agent;
use AsayDev\LaraTickets\Models\Ticket;
use Rappasoft\LaravelLivewireTables\Views\Column;

class LaraTicketsTable extends BaseLivewire
{

    public $dashboardData;

    protected $listeners = ['setDashboardData'];

    public function setDashboardData($dashboardData)
    {
        $this->dashboardData = $dashboardData;
    }

    public function closeSelected()
    {
        if ($this->selectedRowsQuery->count() > 0) {
            Ticket::whereIn('id', $this->selectedKeys())->update([
                'status' => TicketsHelper::$tickets_closed_status,
                'completed_at' => date('Y-m-d H:i:s')
            ]);
            $this->emit('setDashboardData', $this->dashboardData);
            $this->resetAll();
        }
    }

    public function mount($dashboardData)
    {
        $this->setDashboardData($dashboardData);
    }

    public function data($selectedTab)
    {

        $collection = TicketsHelper::getTicketsCollection($this->dashboardData['model'], $this->dashboardData['model_id'], $selectedTab);

        return $collection->orderBy('id', 'desc');
    }

    public function query(): Builder
    {
        if (($this->dashboardData['active_nav_tab'])[0] != 'completed') {
            $this->bulkActions = [
                'closeSelected' => __('Close'),
            ];
        }

        return $this->data(explode('-', $this->dashboardData['active_nav_tab'])[0]);
    }

    /**
     * @inheritDoc
     */
    public function columns(): array
    {

        $columns = [
            Column::make(trans('laratickets::lang.table-id'), 'id'),
            Column::make(trans('laratickets::lang.table-subject'))
                ->format(function ($value, $column, $row) {
                    $html = '<a class="btn btn-link" wire:click="viewTicket(' . $row->id . ')">' . $row->subject . '</a>';
                    return $html;
                })->asHtml()
        ];


        if ($this->dashboardData['model'] != 'all') {
            $columns[] = Column::make(trans('laratickets::lang.table-type'))
                ->format(function ($value, $column, $row) {
                    if ($row->completed_at) {
                        return trans('laratickets::lang.nav-completed-tickets');
                    } else {
                        return trans('laratickets::lang.nav-active-tickets');
                    }
                })->asHtml();
        }

        $columns[] = Column::make(trans('laratickets::lang.table-status'))
            ->format(function ($value, $column, $row) {
                $html = '<div>' . TicketsHelper::getTicketStatusLabel($row->status) . '</div>';
                return $html;
            })->asHtml();
        $columns[] = Column::make(trans('laratickets::lang.table-last-updated'))
            ->format(function ($value, $column, $row) {
                return $row->updated_at->diffForHumans();
            })->asHtml();
        $columns[] = Column::make(trans('laratickets::lang.table-agent'))
            ->format(function ($value, $column, $row) {
                $ticket = \AsayDev\LaraTickets\Models\Ticket::find($row->id);
                return e($ticket->agent->name);
            })->asHtml();

        $user = Agent::find(auth()->user()->id);

        if (auth()->user()->hasPermissionTo(config('laratickets.permissions.laratickets_display_all')) || auth()->user()->hasRole(config('laratickets.roles.laratickets_administrator'))) {
            $columns[] = Column::make(trans('laratickets::lang.table-priority'))
                ->format(function ($value, $column, $row) {
                    $html = '<div style="color: ' . $row->priority->color . '">' . e($row->priority->name) . '</div>';
                    return $html;
                })->asHtml();
            $columns[] = Column::make(trans('laratickets::lang.table-category'))
                ->format(function ($value, $column, $row) {
                    $html = '<div style="color: ' . $row->priority->color . '">' . e($row->category->name) . '</div>';
                    return $html;
                })->asHtml();
            $columns[] = Column::make(trans('laratickets::lang.createdby'))
                ->format(function ($value, $column, $row) {
                    //if ($row->createdby) {
                    //    return $row->createdby->name;
                    //}
                    if ($row->user) {
                        return $row->user->name;
                    }
                })->asHtml();
        }

        $columns[] = Column::make(trans('laratickets::lang.created_at'), 'created_at')
            ->format(function ($value, $column, $row) {
                return $row->created_at->format('Y-m-d');
            })->sortable();

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
