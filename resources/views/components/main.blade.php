<div>
    @if($tickets_count)
    <div class="mb-5" style="display: flex;justify-content:space-between;flex-flow:wrap">
        <div class="card m-2 bg-light" style="display: flex;flex-grow:1">
            <div class="card-body row d-flex align-items-center">
                <div class="col-3" style="font-size: 5em;">
                    <i class="bi bi-grid-fill"></i>
                </div>
                <div class="col-9 text-right">
                    <h1>{{ $tickets_count }}</h1>
                    <div>{{ trans('laratickets::admin.index-total-tickets') }}</div>
                </div>
            </div>
        </div>
        <div class="card bg-danger m-2" style="display: flex;flex-grow:1">
            <div class="card-body row d-flex align-items-center">
                <div class="col-3" style="font-size: 5em;">
                    <i class="bi bi-ticket-detailed"></i>
                </div>
                <div class="col-9 text-right">
                    <h1>{{ $open_tickets_count }}</h1>
                    <div>{{ trans('laratickets::admin.index-open-tickets') }}</div>
                </div>
            </div>
        </div>
        <div class="card m-2 bg-success" style="display: flex;flex-grow:1">
            <div class="card-body row d-flex align-items-center">
                <div class="col-3" style="font-size: 5em;">
                    <i class="bi bi-hand-thumbs-up-fill"></i>
                </div>
                <div class="col-9 text-right">
                    <h1>{{ $closed_tickets_count }}</h1>
                    <span>{{ trans('laratickets::admin.index-closed-tickets') }}</span>
                </div>
            </div>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-lg-8 mt-3">
            <div class="card " style="width:100%">
                <div class="card-header d-flex justify-content-between align-items-baseline flex-wrap">
                    <div><i class="bi bi-bar-chart fa-fw"></i>
                        {{ trans('laratickets::admin.index-performance-indicator') }}</div>
                    <div class="dropdown">
                        <button type="button" class="btn btn-secondary btn-sm dropdown-toggle" data-toggle="dropdown">
                            {{ trans('laratickets::admin.index-periods') }}
                            <span class="caret"></span>
                        </button>
                        <div class="dropdown-content" role="menu">
                            <a class="dropdown-item" wire:click="initData(2)">
                                {{ trans('laratickets::admin.index-3-months') }}
                            </a>
                            <a class="dropdown-item" wire:click="initData(5)">
                                {{ trans('laratickets::admin.index-6-months') }}
                            </a>
                            <a class="dropdown-item" wire:click="initData(11)">
                                {{ trans('laratickets::admin.index-12-months') }}
                            </a>
                        </div>
                    </div>
                </div>
                <div class="panel-body">
                    <div id="curve_chart" style="width: 100%; height: 350px;"></div>
                </div>
            </div>
            <div class="card-deck mt-3">
                <div class="card ">
                    <div class="card-header">
                        {{ trans('laratickets::admin.index-tickets-share-per-category') }}
                    </div>
                    <div class="panel-body">
                        <div id="catpiechart" style="width: auto; height: 350;"></div>
                    </div>
                </div>
                <div class="card ">
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
            <nav>
                <ul class="nav nav-pills nav-justified" id="categoriesTabs">
                    <li class="nav-item">
                        <a class="nav-link  {{$active_tab == "cat" ? "active" : ""}}" wire:click="setActiveTab('cat)"
                            data-toggle="pill" href="#information-panel-categories">
                            <i class="bi bi-folder"></i>
                            <small>{{ trans('laratickets::admin.index-categories') }}</small>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{$active_tab == "agents" ? "active"  : ""}}"
                            wire:click="setActiveTab('agents)" data-toggle="pill" href="#information-panel-agents">
                            <i class="bi bi-incognito"></i>
                            <small>{{ trans('laratickets::admin.index-agents') }}</small>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{$active_tab == "users" ? "active" : ""}}" wire:click="setActiveTab('users)"
                            data-toggle="pill" href="#information-panel-users">
                            <i class="bi bi-people-fill"></i>
                            <small>{{ trans('laratickets::admin.index-users') }}</small>
                        </a>
                    </li>
                </ul>
            </nav>
            <br>
            <div class="tab-content">
                <div id="information-panel-categories"
                    class="list-group tab-pane fade {{$active_tab == "cat" ? "show active" : ""}}">
                    <livewire:lara-tickets-statistics-categories>
                </div>
                <div id="information-panel-agents"
                    class="list-group tab-pane fade {{$active_tab == "agents" ? "show active" : ""}}">
                    <livewire:lara-tickets-statistics-agents>
                </div>
                <div id="information-panel-users"
                    class="list-group tab-pane fade {{$active_tab == "users" ? "show active" : ""}}">
                    <livewire:lara-tickets-statistics-users>
                </div>
            </div>
        </div>
    </div>
    @else
    <div class="card text-center">
        {{ trans('laratickets::admin.index-empty-records') }}
    </div>
    @endif
</div>
@push('after-scripts')
@if($tickets_count)
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
    window.livewire.on('periodChanged', period => {
        drawChart();
    });
    google.charts.load('current', {
        callback: function() {
            drawChart();
            $(window).resize(drawChart);
        },
        packages: ['corechart']
    });
    // performance line chart
    function drawChart() {
        var data = google.visualization.arrayToDataTable([
            ["{{ trans('laratickets::admin.index-month') }}", @json($monthly_performance['categories'])],
            @foreach($monthly_performance['interval'] as $month => $records)
            ["{{ $month }}", @json($records)],
            @endforeach
        ]);
        var options = {
            title: '{{trans('laratickets::admin.index-performance-chart')}}',
            curveType: 'function',
            legend: {
                position: 'right'
            },
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
            ['{{ trans('laratickets::admin.index-category') }}', '{{trans('laratickets::admin.index-tickets')}}'
            ],
            @foreach($categories_share as $cat_name => $cat_tickets)
            [
                '{{$cat_name}}','{{$cat_tickets}}'
            ],
            @endforeach
        ]);
        var cat_options = {
            title: '{{trans('laratickets::admin.index-categories-chart')}}',
            legend: {
                position: 'bottom'
            }
        };
        var cat_chart = new google.visualization.PieChart(document.getElementById('catpiechart'));
        cat_chart.draw(cat_data, cat_options);
        // Agents Pie Chart
        var agent_data = google.visualization.arrayToDataTable([
            ['{{ trans('laratickets::admin.index-agent') }}', '{{ trans('laratickets::admin.index-tickets') }}'
            ],
            @foreach($agents_share as $agent_name => $agent_tickets)['{!! addslashes($agent_name) !!}', {
                {
                    $agent_tickets
                }
            }],
            @endforeach
        ]);
        var agent_options = {
            title: '{{(trans('laratickets::admin.index-agents-chart')) }}',
            legend: {
                position: 'bottom'
            }
        };
        var agent_chart = new google.visualization.PieChart(document.getElementById('agentspiechart'));
        agent_chart.draw(agent_data, agent_options);
    }

    /**
     * just for resize chart after page loadm
     */
    setTimeout(function() {
        drawChart();
    }, 3000);

    window.addEventListener('load', function () {
                     $('#categoriesTabs a').on('click', function(e){
                      e.preventDefault()
                      $(this).tab('show')
                    })               
                });

</script>
@endif
@endpush