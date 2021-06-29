<ul class="nav nav-tabs nav-fill p-0">
    @if($dashboardData['usertype']=='admin')
        <li  class="nav-item" style="cursor: pointer">
            <a class="nav-link {{$dashboardData['active_nav_tab']=='main-tab'?'active':''}}"
               wire:click="setActiveNavTab('main-tab')">
                {{ trans('laratickets::admin.nav-dashboard') }}
            </a>
        </li>
    @endif
    @if($dashboardData['model']=='all')
        <li  class="nav-item" style="cursor: pointer">
            <a class="nav-link {{$dashboardData['active_nav_tab']=='active-tickets-tab'?'active':''}}"
               wire:click="setActiveNavTab('active-tickets-tab')">
                {{ trans('laratickets::lang.nav-active-tickets') }}
                <span class="badge badge-pill badge-secondary ">
                <?php
                    $collection = \AsayDev\LaraTickets\Helpers\TicketsHelper::getTicketsCollection($dashboardData['model'], $dashboardData['model_id']);
                    echo $collection->whereNull('completed_at')->count();
                    ?>
                </span>
            </a>
        </li>
        <li  class="nav-item" style="cursor: pointer">
            <a class="nav-link {{$dashboardData['active_nav_tab']=='completed-tickets-tab'?'active':''}}"
               wire:click="setActiveNavTab('completed-tickets-tab')">
                {{ trans('laratickets::lang.nav-completed-tickets') }}
                <span class="badge badge-pill badge-secondary">
                    <?php
                    $collection = \AsayDev\LaraTickets\Helpers\TicketsHelper::getTicketsCollection($dashboardData['model'], $dashboardData['model_id']);
                    echo $collection->whereNotNull('completed_at')->count();
                    ?>
                </span>
            </a>
        </li>
    @endif
    @if($dashboardData['usertype']=='admin')
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle {{in_array($dashboardData['active_nav_tab'],['statuses-tab','priorities-tab','agents-tab','config-tab','category-tab','admin-tab'])?'active':''}}" href="#" id="navbarDarkDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    {{ trans('laratickets::admin.nav-settings') }}
                    @if($dashboardData['active_nav_tab']=='statuses-tab')
                        : {{ trans('laratickets::admin.nav-statuses') }}
                    @elseif($dashboardData['active_nav_tab']=='priorities-tab')
                        {{ trans('laratickets::admin.nav-priorities') }}
                    @elseif($dashboardData['active_nav_tab']=='agents-tab')
                        {{ trans('laratickets::admin.nav-agents') }}
                    @elseif($dashboardData['active_nav_tab']=='category-tab')
                        {{ trans('laratickets::admin.nav-categories') }}
                    @elseif($dashboardData['active_nav_tab']=='config-tab')
                        {{ trans('laratickets::admin.nav-configuration') }}
                    @elseif($dashboardData['active_nav_tab']=='admin-tab')
                        {{ trans('laratickets::admin.nav-administrator') }}
                    @endif
                </a>
                <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="navbarDarkDropdownMenuLink">
                    <li>
                        <a class="dropdown-item {!! $dashboardData['active_nav_tab']=='statuses-tab' ? "active" : "" !!}"
                           wire:click="setActiveNavTab('statuses-tab')">{{ trans('laratickets::admin.nav-statuses') }}</a>
                    </li>
                    <li>
                        <a class="dropdown-item {!! $dashboardData['active_nav_tab']=='priorities-tab' ? "active" : "" !!}"
                           wire:click="setActiveNavTab('priorities-tab')">{{ trans('laratickets::admin.nav-priorities') }}</a>
                    </li>
                    <li>
                        <a class="dropdown-item {!! $dashboardData['active_nav_tab']=='agents-tab' ? "active" : "" !!}"
                           wire:click="setActiveNavTab('agents-tab')">{{ trans('laratickets::admin.nav-agents') }}</a>
                    </li>
                    <li>
                        <a class="dropdown-item {!! $dashboardData['active_nav_tab']=='category-tab' ? "active" : "" !!}"
                           wire:click="setActiveNavTab('category-tab')">{{ trans('laratickets::admin.nav-categories') }}</a>
                    </li>
                    <li>
                        <a class="dropdown-item {!! $dashboardData['active_nav_tab']=='config-tab' ? "active" : "" !!}"
                           wire:click="setActiveNavTab('config-tab')">{{ trans('laratickets::admin.nav-configuration') }}</a>
                    </li>
                    <li>
                        <a class="dropdown-item {!! $dashboardData['active_nav_tab']=='admin-tab' ? "active" : "" !!}"
                           wire:click="setActiveNavTab('admin-tab')">{{ trans('laratickets::admin.nav-administrator') }}</a>
                    </li>
                </ul>
            </li>
    @endif
</ul>
