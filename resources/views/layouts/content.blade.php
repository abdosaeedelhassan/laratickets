<div>
    @if($active_nav_tab=='main-tab')
        main-tab
    @elseif($active_nav_tab=='active-tickets-tab')
        active-tickets-tab
    @elseif($active_nav_tab=='completed-tickets-tab')
        completed-tickets-tab
    @elseif($active_nav_tab=='statuses-tab')
        {{ trans('laratickets::admin.nav-statuses') }}
    @elseif($active_nav_tab=='priorities-tab')
        {{ trans('laratickets::admin.nav-priorities') }}
    @elseif($active_nav_tab=='agents-tab')
        {{ trans('laratickets::admin.nav-agents') }}
    @elseif($active_nav_tab=='category-tab')
        {{ trans('laratickets::admin.nav-categories') }}
    @elseif($active_nav_tab=='config-tab')
        {{ trans('laratickets::admin.nav-configuration') }}
    @elseif($active_nav_tab=='admin-tab')
        {{ trans('laratickets::admin.nav-administrator') }}
    @endif
</div>
