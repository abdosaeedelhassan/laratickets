@include('asaydev-lara-tickets::layouts.header')
<div class="card mb-3">
    <div class="card-body">
        @include('asaydev-lara-tickets::layouts.nav')
    </div>
</div>
<div class="card">
    <h5 class="card-header d-flex justify-content-between align-items-baseline flex-wrap">
        header will be her
    </h5>
    <div class="card-body">
        @livewire('lara-tickets-content',['active_nav_tab'=>$active_nav_tab])
    </div>
</div>

