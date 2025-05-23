@extends('before-login.tentang.layout')

@section('title', 'Tentang Pertamina RU II Dumai')

@section('bodyClass', 'body-tentang body-sekilas')
@section('tentang-content')
    <div class="sejarah">
        <h3 class="tentang-title">Sejarah Pertamina RU II Dumai</h3>
        <img class="w-100" src="{{ isFileExists('storage/images/profil-perusahaan/sejarah/' . $sejarah->gambar, asset('assets/img/dafault/default-bg.png')) }}"
            alt="Gambar sejarah">
        <div class="deskripsi mt-2">
            <div class="limited-text-deskripsi">
                {!! limitCharacters($sejarah->deskripsi, 350) !!}
                @if (isLimit($sejarah->deskripsi, 350))
                    <a href="##more" onclick="showSelengkapnya(this)">More</a>
                @endif
            </div>
            @if (isLimit($sejarah->deskripsi, 350))
                <div class="full-text-deskripsi" style="display: none;">
                    {!! $sejarah->deskripsi !!}
                    <a href="##less" onclick="showLess(this)">Less</a>
                </div>
            @endif
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        function showLess(link) {
            document.querySelector('.full-text-deskripsi').style.display = 'none'
            document.querySelector('.limited-text-deskripsi').style.display = 'block'
        }

        function showSelengkapnya(link) {
            document.querySelector('.limited-text-deskripsi').style.display = 'none'
            document.querySelector('.full-text-deskripsi').style.display = 'block'
        }
    </script>
@endsection
