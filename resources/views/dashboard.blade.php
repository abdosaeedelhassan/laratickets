@include('asaydev-lara-tickets::layouts.header')
<div class="card mb-3">
    <div class="card-body">
        @include('asaydev-lara-tickets::layouts.nav')
    </div>
</div>

@livewire('lara-tickets-content',['active_nav_tab'=>$active_nav_tab])
