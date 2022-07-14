<ul class="nav nav-tabs nav-fill p-0">
    @if(auth()->user()->hasPermissionTo(config('laratickets.permissions.laratickets_main_page'))||auth()->user()->hasRole(config('laratickets.roles.laratickets_administrator')))
    <li class="nav-item" style="cursor: pointer">
        <a class="nav-link {{$dashboardData['active_nav_tab']=='main-tab'?'active':''}}"
            wire:click="setActiveNavTab('main-tab')">
            {{ __('Dashboard') }}
        </a>
    </li>
    @endif
    @if(auth()->user()->hasPermissionTo(config('laratickets.permissions.laratickets_active'))||auth()->user()->hasRole(config('laratickets.roles.laratickets_administrator')))
    <li class="nav-item" style="cursor: pointer">
        <a class="nav-link {{$dashboardData['active_nav_tab']=='active-tickets-tab'?'active':''}}"
            wire:click="setActiveNavTab('active-tickets-tab')">
            {{ __('Active tickets') }}
            <span class="badge badge-pill badge-secondary ">
                <?php
                    $collection = \AsayDev\LaraTickets\Helpers\TicketsHelper::getTicketsCollection($dashboardData['model'], $dashboardData['model_id'], 'active');
                    echo $collection->count();
                    ?>
            </span>
        </a>
    </li>
    @endif
    @if(auth()->user()->hasPermissionTo(config('laratickets.permissions.laratickets_waiting_client_reply'))||auth()->user()->hasRole(config('laratickets.roles.laratickets_administrator')))
    <li class="nav-item" style="cursor: pointer">
        <a class="nav-link {{$dashboardData['active_nav_tab']=='waitingClientReply-tickets-tab'?'active':''}}"
            wire:click="setActiveNavTab('waitingClientReply-tickets-tab')">
            {{ __('Waiting client reply') }}
            <span class="badge badge-pill badge-secondary ">
                <?php
                    $collection = \AsayDev\LaraTickets\Helpers\TicketsHelper::getTicketsCollection($dashboardData['model'], $dashboardData['model_id'], 'waitingClientReply');
                    echo $collection->count();
                    ?>
            </span>
        </a>
    </li>
    @endif
    @if(auth()->user()->hasPermissionTo(config('laratickets.permissions.laratickets_waiting_managing_reply'))||auth()->user()->hasRole(config('laratickets.roles.laratickets_administrator')))
    <?php
        $collection = \AsayDev\LaraTickets\Helpers\TicketsHelper::getTicketsCollection($dashboardData['model'], $dashboardData['model_id'], 'waitingManagingReply');
        $waitingManagingReply = $collection->count();
        ?>
    <li class="nav-item" style="cursor: pointer">
        <a class="nav-link {{$dashboardData['active_nav_tab']=='waitingManagingReply-tickets-tab'?'active':''}}"
            wire:click="setActiveNavTab('waitingManagingReply-tickets-tab')">
            {{ __('Waiting managing reply') }}
            <span class="badge badge-pill badge-{{$waitingManagingReply>0?'danger':'secondary'}} ">
                {{$waitingManagingReply}}
            </span>
        </a>
    </li>
    @endif
    @if(auth()->user()->hasPermissionTo(config('laratickets.permissions.laratickets_closed'))||auth()->user()->hasRole(config('laratickets.roles.laratickets_administrator')))
    <li class="nav-item" style="cursor: pointer">
        <a class="nav-link {{$dashboardData['active_nav_tab']=='completed-tickets-tab'?'active':''}}"
            wire:click="setActiveNavTab('completed-tickets-tab')">
            {{ __('Completed tickets') }}
            <span class="badge badge-pill badge-secondary">
                <?php
                    $collection = \AsayDev\LaraTickets\Helpers\TicketsHelper::getTicketsCollection($dashboardData['model'], $dashboardData['model_id'], 'completed');
                    echo $collection->count();
                    ?>
            </span>
        </a>
    </li>
    @endif
    @if(auth()->user()->hasPermissionTo(config('laratickets.permissions.laratickets_managing'))||auth()->user()->hasRole(config('laratickets.roles.laratickets_administrator')))
    <div x-data="{ open: false }" x-on:click.outside="open = false">
        <a x-on:click="open = !open"
            class="nav-link dropdown-toggle {{in_array($dashboardData['active_nav_tab'],['statuses-tab','priorities-tab','agents-tab','config-tab','category-tab','admin-tab'])?'active':''}}"
            data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false"
            style="cursor: pointer">
            {{ trans('laratickets::admin.nav-managing') }} :
            @if($dashboardData['active_nav_tab']=='priorities-tab')
            {{ trans('laratickets::admin.nav-priorities') }}
            @elseif($dashboardData['active_nav_tab']=='agents-tab')
            {{ trans('laratickets::admin.nav-agents') }}
            @elseif($dashboardData['active_nav_tab']=='category-tab')
            {{ trans('laratickets::admin.nav-categories') }}
            @elseif($dashboardData['active_nav_tab']=='config-tab')
            {{ trans('laratickets::admin.nav-configuration') }}
            @elseif($dashboardData['active_nav_tab']=='admin-tab')
            {{ trans('laratickets::admin.nav-administrator') }}
            @elseif($dashboardData['active_nav_tab']=='ticket-replies')
            {{ trans('laratickets::admin.nav-ticket-replies') }}
            @endif
        </a>
        <div x-show="open">
            <a x-on:click="open = false" class="dropdown-item {!! $dashboardData['active_nav_tab']=='priorities-tab' ? "
                active" : "" !!}" wire:click="setActiveNavTab('priorities-tab')"
                style="cursor: pointer">{{ trans('laratickets::admin.nav-priorities') }}</a>
            <a x-on:click="open = false" class="dropdown-item {!! $dashboardData['active_nav_tab']=='category-tab' ? "
                active" : "" !!}" wire:click="setActiveNavTab('category-tab')"
                style="cursor: pointer">{{ trans('laratickets::admin.nav-categories') }}</a>
            <a x-on:click="open = false" class="dropdown-item {!! $dashboardData['active_nav_tab']=='agents-tab' ? "
                active" : "" !!}" wire:click="setActiveNavTab('agents-tab')"
                style="cursor: pointer">{{ trans('laratickets::admin.nav-agents') }}</a>
            <a x-on:click="open = false" class="dropdown-item {!! $dashboardData['active_nav_tab']=='admin-tab' ? "
                active" : "" !!}" wire:click="setActiveNavTab('admin-tab')"
                style="cursor: pointer">{{ trans('laratickets::admin.nav-administrator') }}</a>
            <a x-on:click="open = false" class="dropdown-item {!! $dashboardData['active_nav_tab']=='ticket-replies' ? "
                active" : "" !!}" wire:click="setActiveNavTab('ticket-replies')"
                style="cursor: pointer">{{ trans('laratickets::admin.nav-ticket-replies') }}</a>
            <a x-on:click="open = false" class="dropdown-item {!! $dashboardData['active_nav_tab']=='config-tab' ? "
                active" : "" !!}" wire:click="setActiveNavTab('config-tab')"
                style="cursor: pointer">{{ trans('laratickets::admin.nav-configuration') }}</a>
        </div>
    </div>
    @endif
</ul>
@push('after-scripts')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css"
    integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
<script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
@endpush