@extends('before-login.tentang.layout')

@section('title', 'Tentang Pertamina RU II Dumai')
@section('tentang-content')
    <div class="produk">
        <h3 class="tentang-title">Produk Yang Dihasilkan RU II Dumai</h3>
        @if ($bbm->isNotEmpty())
            <h4 class="tentang-title mt-3">BBM</h4>
            <div class="row">
                @foreach ($bbm as $item)
                    <div class="col-6 col-md-4 col-lg-3 mb-4">
                        <x-card.produk source="{{ isFileExists('storage/images/profil-perusahaan/produk/' . $item->gambar, asset('assets/img/dafault/default-bg.png')) }}" title="{{ $item->deskripsi }}"/>
                    </div>
                @endforeach
            </div>
        @endif
        @if ($nonbbm->isNotEmpty())
            <h4 class="tentang-title mt-3">NON BBM</h4>
            <div class="row">
                @foreach ($nonbbm as $item)
                    <div class="col-6 col-md-4 col-lg-3 mb-4">
                        <x-card.produk source="{{ isFileExists('storage/images/profil-perusahaan/produk/' . $item->gambar, asset('assets/img/dafault/default-bg.png')) }}" title="{{ $item->deskripsi }}"/>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection
