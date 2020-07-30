<nav>
    <ul class="nav nav-pills">
        @if($user->laratickets_isAdmin())
            <li role="presentation" class="nav-item">
                <button class="nav-link {{$active_nav_tab=='dashboard-tab'?'active':''}}" wire:click="setActiveNavTab('dashboard-tab')">
                    {{ trans('laratickets::admin.nav-dashboard') }}
                </button>
            </li>
        @endif
        <li role="presentation" class="nav-item">
            <button class="nav-link {{$active_nav_tab=='active-tickets-tab'?'active':''}}" wire:click="setActiveNavTab('active-tickets-tab')">
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
            </button>
        </li>
        <li role="presentation" class="nav-item">
            <a class="nav-link {{$active_nav_tab=='completed-tickets-tab'?'active':''}}" wire:click="setActiveNavTab('completed-tickets-tab')">
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
                    <a class="nav-link dropdown-toggle
{{--                    {!!--}}
{{--                    $tools->fullUrlIs(action('\Kordy\Ticketit\Controllers\StatusesController@index').'*') ||--}}
{{--                    $tools->fullUrlIs(action('\Kordy\Ticketit\Controllers\PrioritiesController@index').'*') ||--}}
{{--                    $tools->fullUrlIs(action('\Kordy\Ticketit\Controllers\AgentsController@index').'*') ||--}}
{{--                    $tools->fullUrlIs(action('\Kordy\Ticketit\Controllers\CategoriesController@index').'*') ||--}}
{{--                    $tools->fullUrlIs(action('\Kordy\Ticketit\Controllers\ConfigurationsController@index').'*') ||--}}
{{--                    $tools->fullUrlIs(action('\Kordy\Ticketit\Controllers\AdministratorsController@index').'*')--}}
{{--                    ? "active" : "" !!}--}}
                        "
                       data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                        {{ trans('laratickets::admin.nav-settings') }}
                    </a>
                    <div class="dropdown-menu">
{{--                        <a  class="dropdown-item {!! $tools->fullUrlIs(action('\Kordy\Ticketit\Controllers\StatusesController@index').'*') ? "active" : "" !!}"--}}
{{--                            href="{{ action('\Kordy\Ticketit\Controllers\StatusesController@index') }}">{{ trans('laratickets::admin.nav-statuses') }}</a>--}}

{{--                        <a  class="dropdown-item {!! $tools->fullUrlIs(action('\Kordy\Ticketit\Controllers\PrioritiesController@index').'*') ? "active" : "" !!}"--}}
{{--                            href="{{ action('\Kordy\Ticketit\Controllers\PrioritiesController@index') }}">{{ trans('laratickets::admin.nav-priorities') }}</a>--}}

{{--                        <a  class="dropdown-item {!! $tools->fullUrlIs(action('\Kordy\Ticketit\Controllers\AgentsController@index').'*') ? "active" : "" !!}"--}}
{{--                            href="{{ action('\Kordy\Ticketit\Controllers\AgentsController@index') }}">{{ trans('laratickets::admin.nav-agents') }}</a>--}}

{{--                        <a  class="dropdown-item {!! $tools->fullUrlIs(action('\Kordy\Ticketit\Controllers\CategoriesController@index').'*') ? "active" : "" !!}"--}}
{{--                            href="{{ action('\Kordy\Ticketit\Controllers\CategoriesController@index') }}">{{ trans('laratickets::admin.nav-categories') }}</a>--}}

{{--                        <a  class="dropdown-item {!! $tools->fullUrlIs(action('\Kordy\Ticketit\Controllers\ConfigurationsController@index').'*') ? "active" : "" !!}"--}}
{{--                            href="{{ action('\Kordy\Ticketit\Controllers\ConfigurationsController@index') }}">{{ trans('laratickets::admin.nav-configuration') }}</a>--}}

{{--                        <a  class="dropdown-item {!! $tools->fullUrlIs(action('\Kordy\Ticketit\Controllers\AdministratorsController@index').'*') ? "active" : "" !!}"--}}
{{--                            href="{{ action('\Kordy\Ticketit\Controllers\AdministratorsController@index')}}">{{ trans('laratickets::admin.nav-administrator') }}</a>--}}
                    </div>
                </li>
            @endif
    </ul>
</nav>
