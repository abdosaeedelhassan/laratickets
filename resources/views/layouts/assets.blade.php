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
@endpush
