<?php

namespace AsayDev\LaraTickets\Livewire\Components\Admins;

use AsayDev\LaraTickets\Livewire\BaseLivewire;
use AsayDev\LaraTickets\Models\Agent;
use Livewire\Component;
use Illuminate\Database\Eloquent\Builder;

class LaraTicketsAdminsTable extends BaseLivewire
{


    public function mount($dashboardData){
        $this->dashboardData=$dashboardData;
    }

    public function query(): Builder
    {
        return  Agent::where('laratickets_admin', '1');
    }
    /**
     * @inheritDoc
     */
    public function columns(): array
    {
        $columns=[];


//            <table class="table table-hover mb-0">
//                <thead>
//                <tr>
//                    <th>{{ trans('laratickets::admin.table-id') }}</th>
//                    <th>{{ trans('laratickets::admin.table-name') }}</th>
//                    <th>{{ trans('laratickets::admin.table-remove-administrator') }}</th>
//                </tr>
//                </thead>
//                <tbody>
//    @foreach($administrators as $administrator)
//                    <tr>
//                        <td>
//                            {{ $administrator->id }}
//                        </td>
//                        <td>
//                            {{ $administrator->name }}
//                        </td>
//                        <td>
//                            {!! CollectiveForm::open([
//                                'method' => 'DELETE',
//                                'route' => [
//                                    $setting->grab('admin_route').'.administrator.destroy',
//                                    $administrator->id
//                                ],
//                                'id' => "delete-$administrator->id"
//                            ]) !!}
//                            {!! CollectiveForm::submit(trans('ticketit::admin.btn-remove'), ['class' => 'btn btn-danger']) !!}
//                            {!! CollectiveForm::close() !!}
//                        </td>
//                    </tr>
//    @endforeach
//                </tbody>
//            </table>

//        $columns = [
//            Column::make(trans('laratickets::lang.table-id'), 'id')
//                ->sortable()
//                ->searchable()
//            ,
//            Column::make(trans('laratickets::lang.table-subject'))
//                ->view('asaydev-lara-tickets::components.tickets.subject', 'column')
//                ->sortable()
//            ,
//            Column::make(trans('laratickets::lang.table-status'))
//                ->view('asaydev-lara-tickets::components.tickets.status', 'column')
//                ->sortable()
//            ,
//            Column::make(trans('laratickets::lang.table-last-updated'))
//                ->view('asaydev-lara-tickets::components.tickets.lastupdate', 'column')
//                ->sortable(),
//            Column::make(trans('laratickets::lang.table-agent'))
//                ->view('asaydev-lara-tickets::components.tickets.agent', 'column')
//                ->sortable()
//        ];
//
//        $user = Agent::find(auth()->user()->id);
//
//        if ($user) {
//            if ($user->isAgent() || $user->laratickets_isAdmin()) {
//                array_push($columns,
//                    Column::make(trans('laratickets::lang.table-priority'))
//                        ->view('asaydev-lara-tickets::components.tickets.priority', 'column')
//                        ->sortable());
//                array_push($columns,
//                    Column::make(trans('laratickets::lang.table-owner'), 'owner')
//                        ->sortable()
//                        ->searchable());
//                array_push($columns,
//                    Column::make(trans('laratickets::lang.table-category'))
//                        ->view('asaydev-lara-tickets::components.tickets.category', 'column')
//                        ->sortable()
//                );
//            }
//        }

        return $columns;
    }

}
