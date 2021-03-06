<div>
    @if($tickets_count)

        <div class="row">
            <div class="col-md-4">
                <div class="card bg-light">
                    <div class="card-body row d-flex align-items-center">
                        <div class="col-3" style="font-size: 5em;">
                            <i class="fas fa-th"></i>
                        </div>
                        <div class="col-9 text-right">
                            <h1>{{ $tickets_count }}</h1>
                            <div>{{ trans('laratickets::admin.index-total-tickets') }}</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-danger">
                    <div class="card-body row d-flex align-items-center">
                        <div class="col-3" style="font-size: 5em;">
                            <i class="fas fa-wrench"></i>
                        </div>
                        <div class="col-9 text-right">
                            <h1>{{ $open_tickets_count }}</h1>
                            <div>{{ trans('laratickets::admin.index-open-tickets') }}</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-success">
                    <div class="card-body row d-flex align-items-center">
                        <div class="col-3" style="font-size: 5em;">
                            <i class="fas fa-thumbs-up"></i>
                        </div>
                        <div class="col-9 text-right">
                            <h1>{{ $closed_tickets_count }}</h1>
                            <span>{{ trans('laratickets::admin.index-closed-tickets') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="row mb-3">
            <div class="col-lg-8 mt-3">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-baseline flex-wrap">
                        <div>
                            <i class="fas fa-chart-bar fa-fw"></i> {{ trans('laratickets::admin.index-performance-indicator') }}
                        </div>
                        <div class="btn-group">

                            <a class="btn btn-secondary btn-sm dropdown-toggle" href="#"
                               id="navbarDarkDropdownMenuLink1" role="button" data-bs-toggle="dropdown"
                               aria-expanded="false">
                                {{ trans('laratickets::admin.index-periods') }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="navbarDarkDropdownMenuLink1">
                                <li>
                                    <a class="dropdown-item" wire:click="initData(2)">
                                        {{ trans('laratickets::admin.index-3-months') }}
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" wire:click="initData(5)">
                                        {{ trans('laratickets::admin.index-6-months') }}
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" wire:click="initData(11)">
                                        {{ trans('laratickets::admin.index-12-months') }}
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div id="curve_chart" style="width: 100%; height: 350px;"></div>
                    </div>
                </div>
                <div class="card-deck mt-3">
                    <div class="card">
                        <div class="card-header">
                            {{ trans('laratickets::admin.index-tickets-share-per-category') }}
                        </div>
                        <div class="panel-body">
                            <div id="catpiechart" style="width: auto; height: 350;"></div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            {{ trans('laratickets::admin.index-tickets-share-per-agent') }}
                        </div>
                        <div class="panel-body">
                            <div id="agentspiechart" style="width: auto; height: 350;"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 mt-3">
                <ul class="nav nav-pills nav-justified">
                    <li class="nav-item">
                        <a class="nav-link  {{$active_tab == "cat" ? "active" : ""}}" wire:click="setActiveTab('cat')">
                            <i class="fas fa-folder"></i>
                            <small>{{ trans('laratickets::admin.index-categories') }}</small>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{$active_tab == "agents" ? "active"  : ""}}"
                           wire:click="setActiveTab('agents')">
                            <i class="fas fa-user-secret"></i>
                            <small>{{ trans('laratickets::admin.index-agents') }}</small>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{$active_tab == "users" ? "active" : ""}}"
                           wire:click="setActiveTab('users')">
                            <i class="fas fa-users"></i>
                            <small>{{ trans('laratickets::admin.index-users') }}</small>
                        </a>
                    </li>
                </ul>
                <div id="information-panel-categories" style="display: {{$active_tab == "cat" ?'block':'none'}}">
                    <a href="#" class="list-group-item list-group-item-action disabled">
                            <span>{{ trans('laratickets::admin.index-category') }}
                                <span
                                    class="badge badge-pill badge-secondary">{{ trans('laratickets::admin.index-total') }}</span>
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
                <div id="information-panel-agents" style="display: {{$active_tab == "agents" ?'block':'none'}}">
                    <a href="#" class="list-group-item list-group-item-action disabled">
                            <span>{{ trans('laratickets::admin.index-agent') }}
                                <span
                                    class="badge badge-pill badge-secondary">{{ trans('laratickets::admin.index-total') }}</span>
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
                <div style="display: {{$active_tab == "users" ?'block':'none'}}">
                    <a href="#" class="list-group-item list-group-item-action disabled">
                            <span>{{ trans('laratickets::admin.index-user') }}
                                <span
                                    class="badge badge-pill badge-secondary">{{ trans('laratickets::admin.index-total') }}</span>
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
                    {!! $users->links() !!}
                </div>
            </div>
        </div>
    @else
        <div class="card text-center">
            {{ trans('laratickets::admin.index-empty-records') }}
        </div>
    @endif
    @push('after-scripts')
        @if($tickets_count)
            <script src="https://www.gstatic.com/charts/loader.js"></script>
            <script>
                window.livewire.on('periodChanged', period => {
                    drawChart();
                });
                google.charts.load('current', {
                    callback: function () {
                        drawChart();
                        $(window).resize(drawChart);
                    },
                    packages: ['corechart']
                });

                // performance line chart
                function drawChart() {
                    var data = google.visualization.arrayToDataTable([
                        ["{{ trans('laratickets::admin.index-month') }}", "{!! implode('", "', $monthly_performance['categories']) !!}"],
                            @foreach($monthly_performance['interval'] as $month => $records)
                        ["{{ $month }}", {!! implode(',', $records) !!}],
                        @endforeach
                    ]);
                    var options = {
                        title: '{!! addslashes(trans('laratickets::admin.index-performance-chart')) !!}',
                        curveType: 'function',
                        legend: {position: 'right'},
                        vAxis: {
                            viewWindowMode: 'explicit',
                            format: '#',
                            viewWindow: {
                                min: 0
                            }
                        }
                    };
                    var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));
                    chart.draw(data, options);
                    // Categories Pie Chart
                    var cat_data = google.visualization.arrayToDataTable([
                        ['{{ trans('laratickets::admin.index-category') }}', '{!! addslashes(trans('laratickets::admin.index-tickets')) !!}'],
                            @foreach($categories_share as $cat_name => $cat_tickets)
                        ['{!! addslashes($cat_name) !!}', {{ $cat_tickets }}],
                        @endforeach
                    ]);
                    var cat_options = {
                        title: '{!! addslashes(trans('laratickets::admin.index-categories-chart')) !!}',
                        legend: {position: 'bottom'}
                    };
                    var cat_chart = new google.visualization.PieChart(document.getElementById('catpiechart'));
                    cat_chart.draw(cat_data, cat_options);
                    // Agents Pie Chart
                    var agent_data = google.visualization.arrayToDataTable([
                        ['{{ trans('laratickets::admin.index-agent') }}', '{!! addslashes(trans('laratickets::admin.index-tickets')) !!}'],
                            @foreach($agents_share as $agent_name => $agent_tickets)
                        ['{!! addslashes($agent_name) !!}', {{ $agent_tickets }}],
                        @endforeach
                    ]);
                    var agent_options = {
                        title: '{!! addslashes(trans('laratickets::admin.index-agents-chart')) !!}',
                        legend: {position: 'bottom'}
                    };
                    var agent_chart = new google.visualization.PieChart(document.getElementById('agentspiechart'));
                    agent_chart.draw(agent_data, agent_options);
                }

                /**
                 * just for resize chart after page loadm
                 */
                setTimeout(function () {
                    drawChart();
                }, 3000);
            </script>
        @endif
    @endpush

</div>
