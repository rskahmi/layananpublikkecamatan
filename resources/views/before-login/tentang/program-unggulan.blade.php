@extends('before-login.tentang.layout')

@section('title', 'Tentang Pertamina RU II Dumai')
@section('tentang-content')

    <div class="sekilas">
        <h3 class="tentang-title">Program Unggulan Comrell & CSR RU II Dumai</h3>
        <div class="row mt-3">
            @foreach ($program_unggulan as $item)
                <div class="col-12 col-md-6 col-lg-4 mb-3 mb-lg-0">
                    <x-card.program
                        badge="UMKM"
                        title="{{ $item->nama_program }}"
                        detail="{!! $item->deskripsi !!}"
                        alamat="{{ $item->wilayah->alamat }},
                        {{ $item->wilayah->kelurahan }},
                        {{ $item->wilayah->kecamatan }},
                        {{ $item->wilayah->kota }}"
                        kontak="{{ checkNumber($item->contact) }}"
                        gambar="{{ isFileExists('storage/images/program-unggulan/' . $item->gambar, asset('assets/img/dafault/default-bg.png')) }}"
                    />
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
    </div>
@endsection
