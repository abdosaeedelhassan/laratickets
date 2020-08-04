@if($editor_enabled)
@if($codemirror_enabled)
    @push('after-scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/{{\AsayDev\LaraTickets\Helpers\Cdn::CodeMirror}}/codemirror.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/{{\AsayDev\LaraTickets\Helpers\Cdn::CodeMirror}}/mode/xml/xml.min.js"></script>
    @endpush
@endif
@push('after-scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/{{\AsayDev\LaraTickets\Helpers\Cdn::Summernote}}/summernote-bs4.min.js"></script>
@endpush
@if($editor_locale)
    @push('after-scripts')
{{--    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/{{\AsayDev\LaraTickets\Helpers\Cdn::Summernote}}/lang/summernote-{{$editor_locale}}.min.js"></script>--}}
    @endpush
@endif
@push('after-scripts')
<script>
    $(function() {
        $(function() {
            window.livewire.on('cleartext', parm => {
                $("#content").summernote("code", "");
                $('#content').value='';
            });
        });
        window.livewire.on('renderContentEditor', parm => {
            $('#content').summernote({
                codemirror: {
                    theme: 'monokai'
                },
                callbacks: {
                    onChange: function(contents, $editable) {
                        window.livewire.emit('setContent',contents)
                    }
                }
            });
            {{--var options = $.extend(true, {lang: '{{$editor_locale}}' {!! $codemirror_enabled ? ", codemirror: {theme: '{$codemirror_theme}', mode: 'text/html', htmlMode: true, lineWrapping: true}" : ''  !!} } , {!! $editor_options !!});--}}
            {{--$("textarea.summernote-editor").summernote(options);--}}
        });
    });
</script>
@endpush
@endif
