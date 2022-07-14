@push('after-scripts')
    <link rel="stylesheet" href="{{asset('laratickets/css/select2.min.css')}}">
    <script src="{{asset('laratickets/js/select2.min.js')}}"></script>
    <script src="{{asset('laratickets/js/slim_notifier.js')}}"></script>
    <script src="{{asset('laratickets/ckeditor/ckeditor.js')}}"></script>

    <script>
        // 1- displaying flash messages
        window.livewire.on('laratickets-flash-message', data => {
            LaraticketsSlimNotifierJs.notification(data.type, data.title, data.message, data.duration);
        })
        // 2- manuplate select2 list
        window.livewire.on('usersList', parm => {
            $('#usersList').select2({
                dropdownAutoWidth: true,
            });
            $('#usersList').on('change', function () {
                window.livewire.emit('selectedUser', $('#usersList').val());
            })
        });
        $('#usersList').on('change', function () {
            window.livewire.emit('selectedUser', $('#usersList').val());
        })
        //3- rendering the text editor
        window.livewire.on('renderLaraTicketsContentEditor', parm => {

            var editor = CKEDITOR.replace('editorContent', {
                language: 'ar',
                // extraPlugins: '',
            });
            if(CKEDITOR.instances['editorContent']){
            CKEDITOR.instances['editorContent'].setData($('#editorContent').val());
            }
            // editor is object of your CKEDITOR
            editor.on('change', function () {
                window.livewire.emit('setContent', CKEDITOR.instances['editorContent'].getData())
            });
            // unless user specified own height.
            CKEDITOR.config.height = 150;
            CKEDITOR.config.width = 'auto';
            window.livewire.on('setLaraTicketsCKEditorContent', content => {
                CKEDITOR.instances['editorContent'].setData(content);
            });
        });
        // 4- clearing texteditor content
        window.livewire.on('cleartext', parm => {
            CKEDITOR.instances['editorContent'].setData('');
        });

        //5- close modal
        window.livewire.on('setLaraTicketsCKEditorContent', content => {
            $('#repliesModal').modal('hide');
        })
    </script>
@endpush