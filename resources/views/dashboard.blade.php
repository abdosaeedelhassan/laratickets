@include('asaydev-lara-tickets::layouts.header')
<div class="card mb-3">
    <div class="laratickets-flash-container">
    </div>
    <div class="card-body">
        @include('asaydev-lara-tickets::layouts.nav')
    </div>
</div>

@livewire('lara-tickets-content',['dashboardData'=>$dashboardData])

@include('asaydev-lara-tickets::layouts.summernote')
