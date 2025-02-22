@props([
    'badge',
    'gambar',
    'title',
    'detail',
    'alamat',
    'kontak'
])


<div class="card program-unggulan">
    <img class="card-img-top" src="{{ $gambar }}" height="127" width="100%" alt="Card image cap">
    <div class="card-body">
        <h5 class="card-title">{{ $title }}</h5>
        <div class="mb-1 d-flex">
            <div class="limited-text-deskripsi">
                {!! limitCharacters($detail, 40) !!}
            </div>
            @if (isLimit($detail, 40))
                <div class="full-text-deskripsi" style="display: none;">
                    {!! $detail !!}
                </div>
                <a class="text-decoration-underline" href="##more" onclick="showMore(this)">More</a>
            @endif
        </div>
        <p class="card-text">
            <b>Alamat :</b> {{ $alamat }}
        </p>
        <p class="card-text">
            <b>Telp :</b> {{ $kontak }}
        </p>

        <div class="media-sosial d-flex justify-content-end">
            <a target="_blank" href="https://wa.me/{{ $kontak }}">
                <x-svg.icon.whatsapp />
            </a>
        </div>
    </div>
</div>
