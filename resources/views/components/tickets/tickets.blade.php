<div>
    <div class="row">
        <div class="col-sm-5">
            <h4 class="card-title mb-0">
                {{$dashboardData['active_nav_title']}}
            </h4>
        </div>
        <div class="col-sm-7 pull-right">
            <div class="btn-toolbar float-right" role="toolbar">
                @if(auth()->user()->hasPermissionTo(config('laratickets.permissions.laratickets_add'))||auth()->user()->hasRole(config('laratickets.roles.laratickets_administrator')))
                <a wire:click="openForm('new_ticket')" class="btn btn-success ml-1" data-toggle="tooltip"
                    title="{{trans('laratickets::lang.btn-create-new-ticket')}}"><i class="bi bi-plus-circle"></i></a>
                @endif
            </div>
        </div>
    </div>
    <div class="row mt-6">
        <div class="col-md-12">
            @if($dashboardData['form']['name']=='tickets')
            <livewire:lara-tickets-form :dashboardData="$dashboardData" />
            @endif
            @if($dashboardData['form']['name']=='')
            <livewire:lara-tickets-tickets-table :dashboardData="$dashboardData" />
            @endif
        </div>
    </div>
</div>