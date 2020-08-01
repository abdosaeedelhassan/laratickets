{{-- Load the css file to the header --}}
@push('after-scripts')
    <script type="text/javascript">
        function loadCSS(filename) {
            var file = document.createElement("link");
            file.setAttribute("rel", "stylesheet");
            file.setAttribute("type", "text/css");
            file.setAttribute("href", filename);
            if (typeof file !== "undefined") {
                document.getElementsByTagName("head")[0].appendChild(file)
            }
        }

        loadCSS({!! '"'.asset('https://cdn.datatables.net/v/bs4/dt-' .\AsayDev\LaraTickets\Helpers\Cdn::DataTables . '/r-' . \AsayDev\LaraTickets\Helpers\Cdn::DataTablesResponsive . '/datatables.min.css').'"' !!});
        @if($editor_enabled)
        loadCSS({!! '"'.asset('https://cdnjs.cloudflare.com/ajax/libs/summernote/' . \AsayDev\LaraTickets\Helpers\Cdn::Summernote . '/summernote-bs4.css').'"' !!});
        @if($include_font_awesome)
        loadCSS({!! '"'.asset('https://use.fontawesome.com/releases/v' . \AsayDev\LaraTickets\Helpers\Cdn::FontAwesome5 . '/css/solid.css').'"' !!});
        loadCSS({!! '"'.asset('https://use.fontawesome.com/releases/v' . \AsayDev\LaraTickets\Helpers\Cdn::FontAwesome5 . '/css/fontawesome.css').'"' !!});
        @endif
        @if($codemirror_enabled)
        loadCSS({!! '"'.asset('https://cdnjs.cloudflare.com/ajax/libs/codemirror/' . \AsayDev\LaraTickets\Helpers\Cdn::CodeMirror . '/codemirror.min.css').'"' !!});
        loadCSS({!! '"'.asset('https://cdnjs.cloudflare.com/ajax/libs/codemirror/' . \AsayDev\LaraTickets\Helpers\Cdn::CodeMirror . '/theme/'.$codemirror_theme.'.min.css').'"' !!});
        @endif
        @endif
    </script>
    <link rel="stylesheet" href="{{asset('laratickets/css/notify.css')}}">
    <script>
        $.notifyDefaults({
            placement: {
                from: "top",
                align: "center"
            },
            animate:{
                enter: "animated fadeInUp",
                exit: "animated fadeOutDown"
            }
        });
        window.livewire.on('laratickets-flash-message', data => {
            $.notify({
                title: data.title,
                message: data.message
            },{
                type: 'pastel-'+data.type,
                delay: 1000,
                showProgressbar: true,
                template: '<div data-notify="container" class="col-xs-11 col-sm-3 alert alert-{0}" role="alert">' +
                    '<button type="button" aria-hidden="true" class="close" data-notify="dismiss">×</button>' +
                    '<span data-notify="icon"></span> ' +
                    '<span data-notify="title">{1}</span> ' +
                    '<span data-notify="message">{2}</span>' +
                    '<div class="progress" data-notify="progressbar">' +
                    '<div class="progress-bar progress-bar-{0}" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>' +
                    '</div>' +
                    '<a href="{3}" target="{4}" data-notify="url"></a>' +
                    '</div>'
            });
        })
    </script>
@endpush

@if($errors->first() != '')
    <div class="container">
        <div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert"><span
                    aria-hidden="true">{{ trans('laratickets::lang.flash-x') }}</span></button>
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
@endif
@if(Session::has('warning'))
    <div class="container">
        <div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert"><span
                    aria-hidden="true">{{ trans('laratickets::lang.flash-x') }}</span></button>
            {{ session('warning') }}
        </div>
    </div>
@endif
@if(Session::has('status'))
    <div class="container">
        <div class="alert alert-success">
            <button type="button" class="close" data-dismiss="alert"><span
                    aria-hidden="true">{{ trans('laratickets::lang.flash-x') }}</span></button>
            {{ session('status') }}
        </div>
    </div>
@endif
