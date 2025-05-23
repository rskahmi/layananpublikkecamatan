@props([
    'kegiatan' => 'Sosialisasi SIMINAH',
    'tanggal' => '11 Januari 2024',
    'gambar' => ''
])

<div class="card dokumentasi animate__animated animate__fadeInLeft">
    <img src="{{ $gambar }}" class="card-img-top" alt="Gambar {{ $kegiatan }}">
    <div class="card-body">
        <h5 class="card-title text-center">{{ $kegiatan }}</h5>
        <p class="card-text text-center">
            {{ $tanggal }}
        </p>
    </div>
</div>
