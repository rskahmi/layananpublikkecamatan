    @extends('layout.guest')

    @section('bodyClass', 'body-berita')
    @section('title', 'Media & Informasi Pertamina RU II Dumai')
    @section('content')
        <div class="container pemberitaan">
            <div class="page-header">
                <h1>Informasi Seputar Kundur Barat</h1>
            </div>
            <div class="row">
                @foreach ($berita as $item)
                    <div class="col-12 col-md-6 col-lg-4 mb-3 mb-lg-0">
                        <x-card.berita-card
                        title="{{ $item->judul }}"
                        detail="{!! $item->deskripsi !!}"
                        tautan="{{ $item->tautan }}"
                        gambar="{{ isFileExists('storage/images/rilis/' . $item->gambar, asset('assets/img/dafault/default-bg.png')) }}"
                        >
                        onclick="beritaPopUp(`{{ $item->judul }}`, `{{ isFileExists('storage/images/rilis/' . $item->gambar, asset('assets/img/dafault/default-bg.png')) }}`, `{{ $item->deskripsi }}`, {{$item->pemberitaan}})"
                        </x-card.berita-card>
                    </div>
                @endforeach
            </div>
            <div class="pagination" id="pagination">
                <ul>
                    @if ($berita->onFirstPage())
                        <li class="disabled"><span>&laquo;</span></li>
                    @else
                        <li><a href="{{ $berita->previousPageUrl() }}" rel="prev">&laquo;</a></li>
                    @endif
                    @foreach ($berita->getUrlRange(1, $berita->lastPage()) as $page => $url)
                        @if ($page == $berita->currentPage())
                            <li class="active"><span>{{ $page }}</span></li>
                        @else
                            <li><a href="{{ $url }}">{{ $page }}</a></li>
                        @endif
                    @endforeach

                    @if ($berita->hasMorePages())
                        <li><a href="{{ route('berita', ['page' => $berita->nextPageUrl()]) }}" rel="next">&raquo;</a></li>
                    @else
                        <li class="disabled"><span>&raquo;</span></li>
                    @endif
                </ul>
            </div>
            <x-modals.BaseModal id="exampleModal">
                <div class="row">
                    <div class="col-12">
                        <h3 class="popup-title" id="judul-berita"></h3>
                    </div>
                    <div class="col-12 mt-2">
                        <img id="gambarBerita" src="" alt="Gambar Pertamina Show 2023"/>
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
