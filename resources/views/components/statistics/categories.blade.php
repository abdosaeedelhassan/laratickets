<div>
    <a href="#" class="list-group-item list-group-item-action disabled">
        <span>{{ trans('laratickets::admin.index-category') }}
            <span class="badge badge-pill badge-secondary">{{ trans('laratickets::admin.index-total') }}</span>
        </span>
        <small class="pull-right text-muted">
            <em>
                {{ trans('laratickets::admin.index-open') }} /
                {{ trans('laratickets::admin.index-closed') }}
            </em>
        </small>
    </a>
    @foreach($categories as $category)
    <a href="#" class="list-group-item list-group-item-action">
        <span style="color: {{ $category->color }}">
            {{ $category->name }} <span
                class="badge badge-pill badge-secondary">{{ $category->tickets()->count() }}</span>
        </span>
        <span class="pull-right text-muted small">
            <em>
                {{ $category->tickets()->whereNull('completed_at')->count() }} /
                {{ $category->tickets()->whereNotNull('completed_at')->count() }}
            </em>
        </span>
    </a>
    @endforeach
    {!! $categories->links() !!}
</div>