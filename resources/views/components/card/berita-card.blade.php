@props([
    'gambar',
    'title',
    'deskripsi',
    'tautan',
])

<div class="card berita animate__animated animate__fadeInUp" data-bs-toggle="modal" data-bs-target="#exampleModal"
    {{ $slot }}
>
    <div class="card-body">
        <img src="{{ $gambar }}" class="card-img-top" alt="Gambar {{ $title }}">
        <h5 title="{{ $title }}" class="card-title">{{ limitCharacters($title, 34) }}</h5>
        <p class="card-text">
            {!! limitCharacters($deskripsi, 100) !!} <span class="selengkapnya">Selengkapnya</span>
        </p>
    </div>
</div>
