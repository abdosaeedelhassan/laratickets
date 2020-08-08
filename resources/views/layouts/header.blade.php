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
    <script src="{{asset('laratickets/js/slim_notifier.js')}}"></script>
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
            LaraticketsSlimNotifierJs.notification(data.type,data.title,data.message, data.duration);
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
