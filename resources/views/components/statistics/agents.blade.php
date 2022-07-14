<div>
    <a href="#" class="list-group-item list-group-item-action disabled">
        <span>{{ trans('laratickets::admin.index-agent') }}
            <span class="badge badge-pill badge-secondary">{{ trans('laratickets::admin.index-total') }}</span>
        </span>
        <span class="pull-right text-muted small">
            <em>
                {{ trans('laratickets::admin.index-open') }} /
                {{ trans('laratickets::admin.index-closed') }}
            </em>
        </span>
    </a>
    @foreach($agents as $agent)
    <a href="#" class="list-group-item list-group-item-action">
        <span>
            {{ $agent->name }}
            <span class="badge badge-pill badge-secondary">
                {{ $agent->agentTickets(false)->count()  +
                         $agent->agentTickets(true)->count() }}
            </span>
        </span>
        <span class="pull-right text-muted small">
            <em>
                {{ $agent->agentTickets(false)->count() }} /
                {{ $agent->agentTickets(true)->count() }}
            </em>
        </span>
    </a>
    @endforeach
    {!! $agents->links() !!}
</div>