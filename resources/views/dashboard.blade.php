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
    @push('after-scripts')
        <script>
            window.livewire.on('usersList', parm => {
                $('#usersList').select2();
                $('#usersList').on('change',function () {
                    window.livewire.emit('selectedUser',$('#usersList').val());
                })
            });
            $('#usersList').on('change',function () {
                window.livewire.emit('selectedUser',$('#usersList').val());
            })

            // setInterval(function () {
            //     if (!$('#usersList').hasClass('select2-hidden-accessible'))
            //     {
            //         $('#usersList').select2();
            //     }
            // },1000);

        </script>
    @endpush
</div>
