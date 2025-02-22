    @extends('layout.guest')

    @section('bodyClass', 'body-berita')
    @section('title', 'Media & Informasi Pertamina RU II Dumai')
    @section('content')

        <div class="container pemberitaan">
            <div class="page-header">
                <h1>Media & Informasi Pertamina RU II Dumai</h1>
            </div>
            <div class="row">
                @foreach ($berita as $item)
                    <div class="col-12 col-sm-6 col-md-6 col-lg-4 col-xl-3 col-xxl-3 mt-3">
                        <x-card.BeritaCard
                            gambar="{{ isFileExists('storage/images/rilis/' . $item->gambar, asset('assets/img/dafault/default-bg.png')) }}"
                            title="{{ $item->judul }}"
                            deskripsi="{!! $item->deskripsi !!}"
                            tautan="{{ $item->tautan }}">

                            onclick="beritaPopUp(`{{ $item->judul }}`, `{{ isFileExists('storage/images/rilis/' . $item->gambar, asset('assets/img/dafault/default-bg.png')) }}`, `{{ $item->deskripsi }}`, {{$item->pemberitaan}})"
                        </x-card.BeritaCard>
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
                    <div class="col-12">
                        <div class="link">
                            <div class="row">
                                <div class="col-12 popup-text">
                                    <h6>Link</h6>
                                </div>
                                <div class="col-12 mb-2">
                                    <div id="anchor-container">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </x-modals.BaseModal>
        </div>

    @endsection
