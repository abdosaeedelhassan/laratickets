<ul class="nav nav-pills">
    @if($user->laratickets_isAdmin())
        <li role="presentation" class="nav-item">
            <a class="nav-link {{$active_nav_tab=='dashboard-tab'?'active':''}}"
               wire:click="setActiveNavTab('dashboard-tab')">
                {{ trans('laratickets::admin.nav-dashboard') }}
            </a>
        </li>
    @endif
    <li role="presentation" class="nav-item">
        <a class="nav-link {{$active_nav_tab=='active-tickets-tab'?'active':''}}"
           wire:click="setActiveNavTab('active-tickets-tab')">
            {{ trans('laratickets::lang.nav-active-tickets') }}
            <span class="badge badge-pill badge-secondary ">
                     <?php
                if ($user->laratickets_isAdmin()) {
                    echo \AsayDev\LaraTickets\Models\Ticket::active()->count();
                } elseif ($user->isAgent()) {
                    echo \AsayDev\LaraTickets\Models\Ticket::active()->agentUserTickets($user->id)->count();
                } else {
                    echo \AsayDev\LaraTickets\Models\Ticket::userTickets($u->id)->active()->count();
                }
                ?>
                </span>
        </a>
    </li>
    <li role="presentation" class="nav-item">
        <a class="nav-link {{$active_nav_tab=='completed-tickets-tab'?'active':''}}"
           wire:click="setActiveNavTab('completed-tickets-tab')">
            {{ trans('laratickets::lang.nav-completed-tickets') }}
            <span class="badge badge-pill badge-secondary">
                    <?php
                if ($user->laratickets_isAdmin()) {
                    echo \AsayDev\LaraTickets\Models\Ticket::complete()->count();
                } elseif ($user->isAgent()) {
                    echo \AsayDev\LaraTickets\Models\Ticket::complete()->agentUserTickets($user->id)->count();
                } else {
                    echo \AsayDev\LaraTickets\Models\Ticket::userTickets($user->id)->complete()->count();
                }
                ?>
                </span>
        </a>
    </li>
    @if($user->laratickets_isAdmin())
        <li role="presentation" class="nav-item dropdown">
            <a class="nav-link dropdown-toggle {{in_array($active_nav_tab,['statuses-tab','priorities-tab','agents-tab','config-tab','category-tab','admin-tab'])?'active':''}}"
               data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                {{ trans('laratickets::admin.nav-settings') }}
                @if($active_nav_tab=='statuses-tab')
                    : {{ trans('laratickets::admin.nav-statuses') }}
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
            </a>
            <div class="dropdown-menu">
                <a class="dropdown-item {!! $active_nav_tab=='statuses-tab' ? "active" : "" !!}"
                   wire:click="setActiveNavTab('statuses-tab')">{{ trans('laratickets::admin.nav-statuses') }}</a>
                <a class="dropdown-item {!! $active_nav_tab=='priorities-tab' ? "active" : "" !!}"
                   wire:click="setActiveNavTab('priorities-tab')">{{ trans('laratickets::admin.nav-priorities') }}</a>
                <a class="dropdown-item {!! $active_nav_tab=='agents-tab' ? "active" : "" !!}"
                   wire:click="setActiveNavTab('agents-tab')">{{ trans('laratickets::admin.nav-agents') }}</a>
                <a class="dropdown-item {!! $active_nav_tab=='category-tab' ? "active" : "" !!}"
                   wire:click="setActiveNavTab('category-tab')">{{ trans('laratickets::admin.nav-categories') }}</a>
                <a class="dropdown-item {!! $active_nav_tab=='config-tab' ? "active" : "" !!}"
                   wire:click="setActiveNavTab('config-tab')">{{ trans('laratickets::admin.nav-configuration') }}</a>
                <a class="dropdown-item {!! $active_nav_tab=='admin-tab' ? "active" : "" !!}"
                   wire:click="setActiveNavTab('admin-tab')">{{ trans('laratickets::admin.nav-administrator') }}</a>
            </div>
        </li>
    @endif
</ul>

