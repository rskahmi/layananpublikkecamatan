@if (session('alert'))
    <script>
        var data = {!! json_encode(session('alert')) !!}

        window.swal.fire({
            title: data['title'] + '!',
            text: data['text'],
            icon: data['type'],
            timer: 3000, // Auto close setelah 5 detik
            timerProgressBar: true, // Tampilkan progress bar saat menunggu
        });
    </script>
@endif
