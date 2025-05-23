@extends('layout.guest')
@section('bodyClass', 'body-berita')
@section('title', 'Media & Informasi Pertamina RU II Dumai')
@section('content')
    <div class="container pemberitaan">
        <div class="page-header">
            <h1>Kegiatan Kantor Camat Kundur Barat</h1>
        </div>
        <div class="row">
            @foreach ($program_unggulan as $item)
                <div class="col-12 col-md-6 col-lg-4 mb-3 mb-lg-0">
                    <x-card.program
                    badge="UMKM"
                    title="{{ $item->nama_kegiatan }}"
                    detail="{!! $item->deskripsi !!}"
                    kontak="{{ checkNumber($item->contact) }}"
                    gambar="{{ isFileExists('storage/images/program-unggulan/' . $item->gambar, asset('assets/img/dafault/default-bg.png')) }}"
                    >
                    onclick="kegiatanPopUp(`{{ $item->nama_kegiatan }}`, `{{ isFileExists('storage/images/program_unggulan/' . $item->gambar, asset('assets/img/dafault/default-bg.png')) }}`, `{{ $item->deskripsi }}`)"
                    </x-card.program>
                </div>
            @endforeach
        </div>
        <div class="pagination" id="pagination">
            <ul>
                @if ($program_unggulan->onFirstPage())
                    <li class="disabled"><span>&laquo;</span></li>
                @else
                    <li><a href="{{ $program_unggulan->previousPageUrl() }}" rel="prev">&laquo;</a></li>
                @endif

                @foreach ($program_unggulan->getUrlRange(1, $program_unggulan->lastPage()) as $page => $url)
                    @if ($page == $program_unggulan->currentPage())
                        <li class="active"><span>{{ $page }}</span></li>
                    @else
                        <li><a href="{{ $url }}">{{ $page }}</a></li>
                    @endif
                @endforeach
                @if ($program_unggulan->hasMorePages())
                    <li><a href="{{ $program_unggulan->nextPageUrl() }}" rel="next">&raquo;</a></li>
                @else
                    <li class="disabled"><span>&raquo;</span></li>
                @endif
            </ul>
        </div>
        <x-modals.BaseModal id="exampleModal">
            <div class="row">
                <div class="col-12">
                    <h3 class="popup-title" id="nama-kegiatan"></h3>
                </div>
                <div class="col-12 mt-2">
                    <img id="gambarKegiatan" src="" alt="Gambar Pertamina Show 2023"/>
                </div>
                <div class="col-12">
                    <div class="deskripsi mt-3">
                        <x-text.PopUpMenu
                            title="Deskripsi"
                            id="deskripsi"
                        />
                    </div>
                </div>
            </div>
        </x-modals.BaseModal>
    </div>
@endsection
