<div class="card">
    <h5 class="card-header d-flex justify-content-between align-items-baseline flex-wrap">
        <div class="col-sm-5">
            <h4 class="card-title mb-0">
                {{$active_nav_title}}
            </h4>
        </div><!--col-->
        <div class="col-sm-7 pull-right">
            <div class="btn-toolbar float-right" role="toolbar">
                <a wire:click="openForm('new_ticket')" class="btn btn-success ml-1" data-toggle="tooltip"
                   title="{{trans('laratickets::lang.btn-create-new-ticket')}}"><i class="fas fa-plus-circle"></i></a>
            </div>
        </div><!--col-->

    </h5>
    <div class="card-body">
        @if($show_form['name']=='tickets')
            @livewire('lara-tickets-form',['form'=>$show_form])
        @endif
        @if($show_form['action']=='')
            @livewire('lara-tickets-tickets',['tickets_type'=>$tickets_type])
        @endif
    </div>
</div>
