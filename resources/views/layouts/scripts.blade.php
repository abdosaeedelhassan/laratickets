@push('after-styles')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
@endpush
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
    <link rel="stylesheet" href="{{asset('laratickets/css/select2.min.css')}}">
    <script src="{{asset('laratickets/js/select2.min.js')}}"></script>
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
    <script>
        window.livewire.on('usersList', parm => {
            $('#usersList').select2();
            $('#usersList').on('change', function () {
                window.livewire.emit('selectedUser', $('#usersList').val());
            })
        });
        $('#usersList').on('change', function () {
            window.livewire.emit('selectedUser', $('#usersList').val());
        })
    </script>
    @if(app()->getLocale()=='ar')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/lang/summernote-ar-AR.min.js"></script>
    @else
        <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
    @endif
    <script>
        $(function () {
            window.livewire.on('cleartext', parm => {
                $("#content").summernote("code", "");
                $('#content').value = '';
            });
            window.livewire.on('renderContentEditor', parm => {
                $('#content').summernote({
                    dialogsInBody: true,
                    // maximumImageFileSize: 1048576,
                    disableDragAndDrop: true,
                    lang: 'ar-AR',
                    codemirror: {
                        theme: 'monokai'
                    },
                    popover: {
                        image: [
                            ['image', ['resizeFull', 'resizeHalf', 'resizeQuarter', 'resizeNone']],
                            ['float', ['floatLeft', 'floatRight', 'floatNone']],
                            ['remove', ['removeMedia']]
                        ]
                    },
                    callbacks: {
                        onChange: function (contents, $editable) {
                            window.livewire.emit('setContent', contents)
                        }
                    }
                });
                {{--var options = $.extend(true, {lang: '{{$editor_locale}}' {!! $codemirror_enabled ? ", codemirror: {theme: '{$codemirror_theme}', mode: 'text/html', htmlMode: true, lineWrapping: true}" : ''  !!} } , {!! $editor_options !!});--}}
                {{--$("textarea.summernote-editor").summernote(options);--}}
            });
        });
    </script>
@endpush
