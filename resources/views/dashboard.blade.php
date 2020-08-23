<div>
    @include('asaydev-lara-tickets::layouts.header')
    @if($dashboardData['model']=='all')
    <div class="card mb-3">
        <div class="card-body">
            @include('asaydev-lara-tickets::layouts.nav')
        </div>
    </div>
    @endif
    @livewire('lara-tickets-content',['dashboardData'=>$dashboardData])
    @include('asaydev-lara-tickets::layouts.summernote')
</div>
