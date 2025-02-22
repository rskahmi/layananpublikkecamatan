@if (session('alert'))
    <script>
        var data = {!! json_encode(session('alert')) !!}

        window.swal.fire({
            title: data['title'] + '!',
            text: data['text'],
            icon: data['type'],
        });
    </script>
@endif
