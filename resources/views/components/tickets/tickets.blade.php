<div class="card">
    <h5 class="card-header d-flex justify-content-between align-items-baseline flex-wrap">
        <div class="col-sm-5">
            <h4 class="card-title mb-0">
                {{$active_nav_title}}
            </h4>
        </div><!--col-->
        <div class="col-sm-7 pull-right">
            <div class="btn-toolbar float-right" role="toolbar">
                <a wire:click="openForm('new_ticket')" class="btn btn-success ml-1" data-toggle="tooltip"
                   title="{{trans('laratickets::lang.btn-create-new-ticket')}}"><i class="fas fa-plus-circle"></i></a>
            </div>
        </div><!--col-->

    </h5>
    <div class="card-body">
        @if($show_form['name']=='tickets')
            @livewire('lara-tickets-form',['form'=>$show_form])
        @endif
        @if($show_form['action']=='')
            @livewire('lara-tickets-tickets',['tickets_type'=>$tickets_type])
        @endif
    </div>
</div>


{{--@section('ticketit_header')--}}
{{--    {!! link_to_route($setting->grab('main_route').'.create', trans('ticketit::lang.btn-create-new-ticket'), null, ['class' => 'btn btn-primary']) !!}--}}
{{--@stop--}}

{{--@section('ticketit_content_parent_class', 'pl-0 pr-0')--}}

{{--@section('ticketit_content')--}}
{{--    <div id="message"></div>--}}
{{--    @include('ticketit::tickets.partials.datatable')--}}
{{--@stop--}}

{{--@section('footer')--}}

{{--    @push('after-scripts')--}}
{{--        <script src="https://cdn.datatables.net/v/bs4/dt-{{ \AsayDev\LaraTickets\Helpers\Cdn::DataTables }}/r-{{ \AsayDev\LaraTickets\Helpers\Cdn::DataTablesResponsive }}/datatables.min.js"></script>--}}
{{--        <script>--}}
{{--            $('.table').DataTable({--}}
{{--                processing: false,--}}
{{--                serverSide: true,--}}
{{--                responsive: true,--}}
{{--                pageLength: {{ $setting->grab('paginate_items') }},--}}
{{--                lengthMenu: {{ json_encode($setting->grab('length_menu')) }},--}}
{{--                ajax: '{!! route($setting->grab('main_route').'.data', $complete) !!}',--}}
{{--                language: {--}}
{{--                    decimal:        "{{ trans('ticketit::lang.table-decimal') }}",--}}
{{--                    emptyTable:     "{{ trans('ticketit::lang.table-empty') }}",--}}
{{--                    info:           "{{ trans('ticketit::lang.table-info') }}",--}}
{{--                    infoEmpty:      "{{ trans('ticketit::lang.table-info-empty') }}",--}}
{{--                    infoFiltered:   "{{ trans('ticketit::lang.table-info-filtered') }}",--}}
{{--                    infoPostFix:    "{{ trans('ticketit::lang.table-info-postfix') }}",--}}
{{--                    thousands:      "{{ trans('ticketit::lang.table-thousands') }}",--}}
{{--                    lengthMenu:     "{{ trans('ticketit::lang.table-length-menu') }}",--}}
{{--                    loadingRecords: "{{ trans('ticketit::lang.table-loading-results') }}",--}}
{{--                    processing:     "{{ trans('ticketit::lang.table-processing') }}",--}}
{{--                    search:         "{{ trans('ticketit::lang.table-search') }}",--}}
{{--                    zeroRecords:    "{{ trans('ticketit::lang.table-zero-records') }}",--}}
{{--                    paginate: {--}}
{{--                        first:      "{{ trans('ticketit::lang.table-paginate-first') }}",--}}
{{--                        last:       "{{ trans('ticketit::lang.table-paginate-last') }}",--}}
{{--                        next:       "{{ trans('ticketit::lang.table-paginate-next') }}",--}}
{{--                        previous:   "{{ trans('ticketit::lang.table-paginate-prev') }}"--}}
{{--                    },--}}
{{--                    aria: {--}}
{{--                        sortAscending:  "{{ trans('ticketit::lang.table-aria-sort-asc') }}",--}}
{{--                        sortDescending: "{{ trans('ticketit::lang.table-aria-sort-desc') }}"--}}
{{--                    },--}}
{{--                },--}}
{{--                columns: [--}}
{{--                    { data: 'id', name: 'ticketit.id' },--}}
{{--                    { data: 'subject', name: 'subject' },--}}
{{--                    { data: 'status', name: 'ticketit_statuses.name' },--}}
{{--                    { data: 'updated_at', name: 'ticketit.updated_at' },--}}
{{--                    { data: 'agent', name: 'users.name' },--}}
{{--                        @if( $user->isAgent() || $user->laratickes_isAdmin() )--}}
{{--                    { data: 'priority', name: 'ticketit_priorities.name' },--}}
{{--                    { data: 'owner', name: 'users.name' },--}}
{{--                    { data: 'category', name: 'ticketit_categories.name' }--}}
{{--                    @endif--}}
{{--                ]--}}
{{--            });--}}
{{--        </script>--}}
{{--    @endpush--}}
{{--@append--}}
