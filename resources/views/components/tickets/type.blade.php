@if($column->completed_at)
    {{ trans('laratickets::lang.nav-completed-tickets') }}
@else
    {{ trans('laratickets::lang.nav-active-tickets') }}
@endif
