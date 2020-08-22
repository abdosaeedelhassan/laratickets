@push('after-styles')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
@endpush
<!-- The Modal -->
<div id="laratickets-modal" class="modal">
    <span class="close">&times;</span>
    <img class="modal-content" id="img01">
    <div id="caption"></div>
</div>

@push('after-scripts')
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
                    maximumImageFileSize: 1048576,
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
