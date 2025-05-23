@extends('before-login.tentang.layout')

@section('title', 'Tentang Pertamina RU II Dumai')
@section('bodyClass', 'body-tentang visi-misi')

@section('tentang-content')
    <div class="sekilas">
        <h3 class="tentang-title">Visi & Misi Kantor Camat Kundur Barat</h3>
        <div class="deskripsi mt-3">
            <p class="mt-3" style="line-height: 1.5;">
                <b>Visi</b>: <br> {{ $visi->deskripsi }}
            </p>
            <p class="mt-3" style="line-height: 1.5;">
                <b>Misi</b>: <br> {{ $misi->deskripsi }}
            </p>
        </div>
    </div>
@endsection
