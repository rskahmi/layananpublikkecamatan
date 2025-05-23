@props([
    'gambar',
    'title',
    'detail',
    'tautan'
])

<div class="animate__animated animate__fadeInUp" data-bs-toggle="modal" data-bs-target="#exampleModal"
    {{ $slot }}
>
<div class="card program-unggulan">
    <img class="card-img-top" src="{{ $gambar }}" height="127" width="100%" alt="Card image cap">
    <div class="card-body">
        <h5 class="card-title">{{ $title }}</h5>
        <div class="mb-1 d-flex">
            <div class="limited-text-deskripsi">
                {{ $detail }}
            </div>
        </div>
    </div>
</div>

</div>

