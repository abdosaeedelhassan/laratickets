<div>
    <a href="#" class="list-group-item list-group-item-action disabled">
        <span>{{ trans('laratickets::admin.index-user') }}
            <span class="badge badge-pill badge-secondary">{{ trans('laratickets::admin.index-total') }}</span>
        </span>
        <span class="pull-right text-muted small">
            <em>
                {{ trans('laratickets::admin.index-open') }} /
                {{ trans('laratickets::admin.index-closed') }}
            </em>
        </span>
    </a>
    @foreach($users as $user)
    <a href="#" class="list-group-item list-group-item-action">
        <span>
            {{ $user->name }}
            <span class="badge badge-pill badge-secondary">
                {{ $user->userTickets(false)->count()  +
                         $user->userTickets(true)->count() }}
            </span>
        </span>
        <span class="pull-right text-muted small">
            <em>
                {{ $user->userTickets(false)->count() }} /
                {{ $user->userTickets(true)->count() }}
            </em>
        </span>
    </a>
    @endforeach
    {{-- {!! $users->links() !!} --}}
</div>