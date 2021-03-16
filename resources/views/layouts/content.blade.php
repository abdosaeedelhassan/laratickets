<div>
    @if($dashboardData['active_nav_tab']=='main-tab')
        @livewire('lara-tickets-main',['dashboardData'=>$dashboardData])
    @elseif($dashboardData['active_nav_tab']=='active-tickets-tab')
        @include('asaydev-lara-tickets::components.tickets.tickets',['tickets_type'=>'active','dashboardData'=>$dashboardData])
    @elseif($dashboardData['active_nav_tab']=='completed-tickets-tab')
        @include('asaydev-lara-tickets::components.tickets.tickets',['tickets_type'=>'completed','dashboardData'=>$dashboardData])
    @elseif($dashboardData['active_nav_tab']=='statuses-tab')
        @include('asaydev-lara-tickets::components.statuses.index',['dashboardData'=>$dashboardData])
    @elseif($dashboardData['active_nav_tab']=='priorities-tab')
        @include('asaydev-lara-tickets::components.priorities.index',['dashboardData'=>$dashboardData])
    @elseif($dashboardData['active_nav_tab']=='agents-tab')
        @include('asaydev-lara-tickets::components.agents.index',['dashboardData'=>$dashboardData])
    @elseif($dashboardData['active_nav_tab']=='category-tab')
        @include('asaydev-lara-tickets::components.categories.index',['dashboardData'=>$dashboardData])
    @elseif($dashboardData['active_nav_tab']=='config-tab')
        @include('asaydev-lara-tickets::components.configuration.index',['dashboardData'=>$dashboardData])
    @elseif($dashboardData['active_nav_tab']=='admin-tab')
        @include('asaydev-lara-tickets::components.admins.index',['dashboardData'=>$dashboardData])
    @elseif($dashboardData['active_nav_tab']=='ticket-viewer')
        @livewire('lara-tickets-viewer',['dashboardData'=>$dashboardData])
    @endif
</div>

{{--@push('before-scripts')--}}
{{--    <script type="text/javascript">--}}
{{--        window.livewire.on('renderAgentsList', parm => {--}}
{{--            $("#agents").select2();--}}
{{--        });--}}
{{--    </script>--}}
{{--@endpush--}}
