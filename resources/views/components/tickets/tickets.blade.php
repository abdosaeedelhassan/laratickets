<div class="card">
    <h5 class="card-header d-flex justify-content-between align-items-baseline flex-wrap">
        <div class="col-sm-5">
            <h4 class="card-title mb-0">
                {{$dashboardData['active_nav_title']}}
            </h4>
        </div><!--col-->
        <div class="col-sm-7 pull-right">
            <div class="btn-toolbar float-right" role="toolbar">
                @if(isset($dashboardData['options']['can_create_ticket']))
                    @if($dashboardData['options']['can_create_ticket']==true)
                        <a wire:click="openForm('new_ticket')" class="btn btn-success ml-1" data-toggle="tooltip"
                           title="{{trans('laratickets::lang.btn-create-new-ticket')}}"><i
                                class="fas fa-plus-circle"></i></a>
                    @endif
                @else
                    <a wire:click="openForm('new_ticket')" class="btn btn-success ml-1" data-toggle="tooltip"
                       title="{{trans('laratickets::lang.btn-create-new-ticket')}}"><i
                            class="fas fa-plus-circle"></i></a>
                @endif
            </div>
        </div><!--col-->

    </h5>
    <div class="card-body">
        @if($dashboardData['form']['name']=='tickets')
            @livewire('lara-tickets-form',['dashboardData'=>$dashboardData])
        @endif
        @if($dashboardData['form']['name']=='')
            @livewire('lara-tickets-tickets-table',['dashboardData'=>$dashboardData])
        @endif
    </div>
</div>
