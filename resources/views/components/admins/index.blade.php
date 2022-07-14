<div class="card">
    <h5 class="card-header d-flex justify-content-between align-items-baseline flex-wrap">
        <div class="col-sm-5">
            <h4 class="card-title mb-0">
                {{$dashboardData['active_nav_title']}}
            </h4>
        </div>
        <!--col-->
        <div class="col-sm-7 pull-right">
            <div class="btn-toolbar float-right" role="toolbar">
                <a wire:click="openForm('new_admin')" class="btn btn-success ml-1" data-toggle="tooltip"
                    title="{{trans('laratickets::admin.btn-create-new-administrator')}}"><i
                        class="bi bi-plus-circle"></i></a>
            </div>
        </div>
        <!--col-->
    </h5>
    <div class="card-body">
        @if($dashboardData['form']['name']=='admins')
        @livewire('lara-tickets-admins-form',['dashboardData'=>$dashboardData])
        @endif
        @if($dashboardData['form']['name']=='')
        @livewire('lara-tickets-admins-table',['dashboardData'=>$dashboardData])
        @endif
    </div>
</div>