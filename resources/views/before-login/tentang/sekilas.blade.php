@extends('before-login.tentang.layout')

@section('title', 'Tentang Pertamina RU II Dumai')

@section('bodyClass', 'body-tentang body-sekilas')
@section('tentang-content')
    <div class="sekilas ms-0 ms-lg-5">
        <h3 class="tentang-title">Sekilas Pertamina RU II Dumai</h3>
        <img src="{{ isFileExists('storage/images/profil-perusahaan/sekilas/' . $sekilas->gambar, asset('assets/img/dafault/default-bg.png')) }}" alt="Gambar sekilas" width="631" height="336" class="rounded">
        <div class="deskripsi mt-2">
            <div class="limited-text-deskripsi">
                {!! limitCharacters($sekilas->deskripsi, 250) !!}
                @if (isLimit($sekilas->deskripsi, 250))
                    <a href="##more" onclick="showSelengkapnya(this)">More</a>
                @endif
            </div>
            @if (isLimit($sekilas->deskripsi, 250))
                <div class="full-text-deskripsi" style="display: none;">
                    {!! $sekilas->deskripsi !!}
                    <a href="##less" onclick="showLess(this)">Less</a>
                </div>
            @endif
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        function showLess(link){
            document.querySelector('.full-text-deskripsi').style.display = 'none'
            document.querySelector('.limited-text-deskripsi').style.display = 'block'
        }

        function showSelengkapnya(link){
            document.querySelector('.limited-text-deskripsi').style.display = 'none'
            document.querySelector('.full-text-deskripsi').style.display = 'block'
        }
    </script>
@endsection
