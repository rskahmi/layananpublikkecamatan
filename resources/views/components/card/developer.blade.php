@props([
    'nama' => 'Josep Ronaldo Francis Siregar',
    'role' => 'Head of Dev Team & Frontend Developer',
    'gambar' => ''
])

<div class="card developer animate__animated animate__fadeInUp">
    <img src="{{ $gambar }}" class="card-img-top" alt="Foto {{ $nama }}">
    <div class="card-body">
        <h5 class="card-title text-center">{{ $nama }}</h5>
        <p class="card-text text-center">
            {{ $role }}
        </p>
    </div>
</div>
