@extends('layout.user')

@section('title', 'Detail Pengajuan')
@section('headers')
    <script src="https://cdn.ckeditor.com/ckeditor5/41.2.0/classic/ckeditor.js"></script>
@endsection
@section('content')
    <x-svg.fitur.berkas />

    @php
        if(isBaru($rd->jenis)) {
            $baru = $rd->baru;
            $riwayat = $rd->baru->riwayat;
        }
        else if (isGanti($rd->jenis)) {
            $ganti = $rd->ganti;
            $riwayat = $rd->ganti->riwayat;
        }
        else if (isKembalikan($rd->jenis)) {
            $kembalikan = $rd->kembalikan;
            $riwayat = $rd->kembalikan->riwayat;
        }
    @endphp

    <div class="row detail-pengajuan">
        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-6 animate__animated animate__fadeInLeft">
            <div class="card standart">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-6 mt-2 mt-sm-2 mt-md-3">
                            <x-text.PopUpMenu title="Jenis" subtitle="{{ $rd->jenis }}" />
                        </div>
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-6 mt-2 mt-sm-2 mt-md-3">
                            <x-text.PopUpMenu title="Tanggal Diajukan" subtitle="{{ format_dfy($rd->tanggal) }}" />
                        </div>
                        @if (isBaru($rd->jenis))
                            @if ( $baru !== null)
                            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-6 mt-2 mt-sm-2 mt-md-3 popup-text">
                                <h6>Surat Permohonan Pengajuan RD </h6>
                                <a target="_blank" href="{{ asset('storage/rd/' . $baru->suratpermohonanbaru) }}">
                                    <img src="{{ asset('assets/img/icon/Download.svg') }}" alt="Icon Download">
                                    Buka Disini
                                </a>
                            </div>
                                <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-6 mt-2 mt-sm-2 mt-md-3 popup-text">
                                    <h6>Status</h6>
                                    <span
                                        class="badge text-capitalize
                                        {{ isStatusDiterima($baru->status) ? 'bg-success' : (isStatusProses($baru->status) ? 'bg-warning' : (isStatusDitolak($baru->status) ? 'bg-danger' : 'bg-warning-subtle text-dark')) }}">{{ $baru->status }}</span>
                                </div>

                                {{-- <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-6 mt-2 mt-sm-2 mt-md-3 popup-text">
                                    <h6>Dokumentasi Oleh Sarana </h6>
                                    <a target="_blank" href="">
                                        <img src="{{ asset('assets/img/icon/Download.svg') }}" alt="Icon Download">
                                        Buka Disini
                                    </a>
                                </div> --}}
                            @endif
                        @elseif (isGanti($rd->jenis))
                            @if ( $ganti !== null)
                            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-6 mt-2 mt-sm-2 mt-md-3 popup-text">
                                <h6>Surat Permohonan Penggantian RD</h6>
                                <a target="_blank" href="{{ asset('storage/npp/' . $ganti->suratpermohonanganti) }}">
                                    <img src="{{ asset('assets/img/icon/Download.svg') }}" alt="Icon Download">
                                    Buka Disini
                                </a>
                            </div>

                            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-6 mt-2 mt-sm-2 mt-md-3 popup-text">
                                <h6>SIMRD</h6>
                                <a target="_blank" href="{{ asset('storage/npp/' . $ganti->simrd) }}">
                                    <img src="{{ asset('assets/img/icon/Download.svg') }}" alt="Icon Download">
                                    Buka Disini
                                </a>
                            </div>
                                <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-6 mt-2 mt-sm-2 mt-md-3 popup-text">
                                    <h6>Status</h6>
                                    <span
                                        class="badge text-capitalize
                                        {{ isStatusDiterima($ganti->status) ? 'bg-success' : (isStatusProses($ganti->status) ? 'bg-warning' : (isStatusDitolak($ganti->status) ? 'bg-danger' : 'bg-warning-subtle text-dark')) }}">{{ $ganti->status }}</span>
                                </div>
                            @endif

                            @elseif (isKembalikan($rd->jenis))
                            @if ( $kembalikan !== null)
                            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-6 mt-2 mt-sm-2 mt-md-3 popup-text">
                                <h6>Surat Permohonan Pengembalian RD </h6>
                                <a target="_blank" href="{{ asset('storage/rd/' . $kembalikan->suratpermohonankembalikan) }}">
                                    <img src="{{ asset('assets/img/icon/Download.svg') }}" alt="Icon Download">
                                    Buka Disini
                                </a>
                            </div>
                                <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-6 mt-2 mt-sm-2 mt-md-3 popup-text">
                                    <h6>Status</h6>
                                    <span
                                        class="badge text-capitalize
                                        {{ isStatusDiterima($kembalikan->status) ? 'bg-success' : (isStatusProses($kembalikan->status) ? 'bg-warning' : (isStatusDitolak($kembalikan->status) ? 'bg-danger' : 'bg-warning-subtle text-dark')) }}">{{ $kembalikan->status }}</span>
                                </div>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>


        @if (isBaru($rd->jenis))
        <div
            class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-6 mt-3 mt-sm-3 mt-md-3 mt-xl-0 animate__animated animate__fadeInRight">
            <div class="container ms-0 ms-sm-0 ms-md-0 ms-lg-0 ms-xl-5">
                @php
                    $lastOfRiwayat = $riwayat->sortBy('created_at')->last();
                @endphp

                @if (isManagerSection($lastOfRiwayat))
                    <div class="row mb-3">
                        <div class="col-12 popup-text">
                            <h6>Verifikasi Disini</h6>
                        </div>
                        <div class="col-12 mt-2">
                            <div class="d-flex gap-3">
                                <button class="btn btn-warning text-capitalize" data-bs-toggle="modal"
                                    data-bs-target="#modalVerifikasiPengajuan">
                                    Verifikasi
                                </button>
                            </div>
                        </div>
                    </div>
                @endif

                @if (isStaffSection($lastOfRiwayat))
                    <div class="row mb-3">
                        <div class="col-12 popup-text">
                            <h6>Verifikasi Disini</h6>
                        </div>
                    <div class="col-12 mt-2">
                        <div class="d-flex gap-3">
                              <button class="btn btn-warning text-capitalize" data-bs-toggle="modal"
                                data-bs-target="#modalVerifikasiPengajuan">
                                Verifikasi
                                </button>
                        </div>
                    </div>
                </div>
                @endif

                @if (isSaranaSection($lastOfRiwayat))
                    <div class="row mb-3">
                        <div class="col-12 popup-text">
                            <h6>Verifikasi Disini</h6>
                        </div>
                    <div class="col-12 mt-2">
                        <div class="d-flex gap-3">
                              <button class="btn btn-warning text-capitalize" data-bs-toggle="modal"
                                data-bs-target="#modalVerifikasiPengajuan">
                                Verifikasi
                                </button>
                        </div>
                    </div>
                </div>
                @endif

                @if (isMgrAdmSection($lastOfRiwayat))
                    <div class="row mb-3">
                        <div class="col-12 popup-text">
                            <h6>Verifikasi Disini</h6>
                        </div>
                    <div class="col-12 mt-2">
                        <div class="d-flex gap-3">
                              <button class="btn btn-warning text-capitalize" data-bs-toggle="modal"
                                data-bs-target="#modalVerifikasiPengajuan">
                                Verifikasi
                                </button>
                        </div>
                    </div>
                </div>
                @endif

                @if (isAVPAdmSection($lastOfRiwayat))
                    <div class="row mb-3">
                        <div class="col-12 popup-text">
                            <h6>Verifikasi Disini</h6>
                        </div>
                    <div class="col-12 mt-2">
                        <div class="d-flex gap-3">
                              <button class="btn btn-warning text-capitalize" data-bs-toggle="modal"
                                data-bs-target="#modalVerifikasiPengajuan">
                                Verifikasi
                                </button>
                        </div>
                    </div>
                </div>
                @endif



                @if (isUserSection($lastOfRiwayat))
                    <div class="row mb-3">
                        <div class="col-12 popup-text">
                            <h6>Verifikasi Disini</h6>
                        </div>
                    <div class="col-12 mt-2">
                        <div class="d-flex gap-3">
                              <button class="btn btn-warning text-capitalize" data-bs-toggle="modal"
                                data-bs-target="#modalVerifikasiPengajuan">
                                Verifikasi
                                </button>
                        </div>
                    </div>
                </div>
                @endif


                @if (isset($riwayat_baru))
                    @if (count($riwayat_baru) > 0)
                        <div
                            class="row {{ (isStatusDiterima($baru->status) || isStatusDitolak($baru->status)) ? 'mt-5' : '' }}">
                            <div class="col-12">
                                <h6 class="riwayat-header">Riwayat</h6>
                            </div>
                            <div class="col-12 mt-3">
                                <ul class="timeline">
                                    @foreach ($riwayat_baru as $item)
                                        <li class="timeline-item">
                                            <div class="date w-auto">
                                                <div class="header">
                                                    <h6>{{ format_dfh($item->created_at) }}</h6>
                                                </div>
                                                <div class="bottom">
                                                    {{ format_time($item->created_at) }}
                                                </div>
                                            </div>
                                            <div class="circle"></div>
                                            <div class="message-timeline w-auto">
                                                <div class="header">
                                                    <h6 class="status text-capitalize">
                                                        {{ $item->status }}
                                                    </h6>
                                                </div>
                                                <div class="bottom text-capitalize">
                                                    Pengajuan telah
                                                    {{ strtolower($item->status) == 'proses' ? 'di' : '' }}
                                                    {{ $item->status }} oleh {{ roles($item->user->role) }}

                                                    @if ($item->status == 'diajukan')
                                                    <h6 class="status mt-1 mb-1">
                                                        Nama User
                                                    </h6>
                                                    {{ $item->user->nama }}
                                                    <h6 class="status mt-1 mb-1">
                                                        Departemen
                                                    </h6>
                                                    {{ $item->user->departemen }}
                                                    @endif

                                                    @if ($item->status != 'diajukan')
                                                        <h6 class="status mt-1 mb-1">
                                                            Nama Pemroses
                                                        </h6>
                                                        {{ $item->user->nama }}
                                                        @if ($item->user->role != "sarana")
                                                        <div class="keterangan">
                                                            <a href="##detail"
                                                                onclick="showReview('{{ $item->alasan }}', '{{ $item->user->nama }}', '{{ roles($item->user->role) }}')">Lihat
                                                                Keterangan</a>
                                                            <x-svg.icon.info />
                                                        </div>
                                                        @else
                                                        <div class="keterangan">
                                                            <a target="_blank" href="{{ asset('storage/rd/' . $item->dokumentasi_sarpras) }}">
                                                                <img src="{{ asset('assets/img/icon/Download.svg') }}" alt="Icon Download">
                                                                Lihat Dokumentasi
                                                            </a>

                                                        </div>
                                                        @endif

                                                    @endif


                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif
                @endif
            </div>
        </div>


        @elseif (isGanti($rd->jenis))
            <div
            class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-6 mt-3 mt-sm-3 mt-md-3 mt-xl-0 animate__animated animate__fadeInRight">
            <div class="container ms-0 ms-sm-0 ms-md-0 ms-lg-0 ms-xl-5">
                @php
                    $lastOfRiwayat = $riwayat->sortBy('created_at')->last();
                @endphp

                @if (isManagerSection($lastOfRiwayat))
                    <div class="row mb-3">
                        <div class="col-12 popup-text">
                            <h6>Verifikasi Disini</h6>
                        </div>
                        <div class="col-12 mt-2">
                            <div class="d-flex gap-3">
                                <button class="btn btn-warning text-capitalize" data-bs-toggle="modal"
                                    data-bs-target="#modalVerifikasiPengajuan">
                                    Verifikasi
                                </button>
                            </div>
                        </div>
                    </div>
                @endif

                @if (isStaffSection($lastOfRiwayat))
                    <div class="row mb-3">
                        <div class="col-12 popup-text">
                            <h6>Verifikasi Disini</h6>
                        </div>
                        <div class="col-12 mt-2">
                            <div class="d-flex gap-3">
                                <button class="btn btn-warning text-capitalize" data-bs-toggle="modal"
                                    data-bs-target="#modalVerifikasiPengajuan">
                                    Verifikasi
                                </button>
                            </div>
                        </div>
                    </div>
                @endif

                @if (isSaranaSection($lastOfRiwayat))
                    <div class="row mb-3">
                        <div class="col-12 popup-text">
                            <h6>Verifikasi Disini</h6>
                        </div>
                        <div class="col-12 mt-2">
                            <div class="d-flex gap-3">
                                <button class="btn btn-warning text-capitalize" data-bs-toggle="modal"
                                    data-bs-target="#modalVerifikasiPengajuan">
                                    Verifikasi
                                </button>
                            </div>
                        </div>
                    </div>
                @endif

                @if (isMgrAdmSection($lastOfRiwayat))
                    <div class="row mb-3">
                        <div class="col-12 popup-text">
                            <h6>Verifikasi Disini</h6>
                        </div>
                        <div class="col-12 mt-2">
                            <div class="d-flex gap-3">
                                <button class="btn btn-warning text-capitalize" data-bs-toggle="modal"
                                    data-bs-target="#modalVerifikasiPengajuan">
                                    Verifikasi
                                </button>
                            </div>
                        </div>
                    </div>
                @endif

                @if (isAVPAdmSection($lastOfRiwayat))
                    <div class="row mb-3">
                        <div class="col-12 popup-text">
                            <h6>Verifikasi Disini</h6>
                        </div>
                    <div class="col-12 mt-2">
                        <div class="d-flex gap-3">
                              <button class="btn btn-warning text-capitalize" data-bs-toggle="modal"
                                data-bs-target="#modalVerifikasiPengajuan">
                                Verifikasi
                                </button>
                        </div>
                    </div>
                </div>
                @endif

                @if (isUserSection($lastOfRiwayat))
                    <div class="row mb-3">
                        <div class="col-12 popup-text">
                            <h6>Verifikasi Disini</h6>
                        </div>
                    <div class="col-12 mt-2">
                        <div class="d-flex gap-3">
                              <button class="btn btn-warning text-capitalize" data-bs-toggle="modal"
                                data-bs-target="#modalVerifikasiPengajuan">
                                Verifikasi
                                </button>
                        </div>
                    </div>
                </div>
                @endif

                @if (isset($riwayat_ganti))
                    @if (count($riwayat_ganti) > 0)
                        <div
                            class="row {{ (isStatusDiterima($ganti->status) || isStatusDitolak($ganti->status)) ? 'mt-5' : '' }}">
                            <div class="col-12">
                                <h6 class="riwayat-header">Riwayat</h6>
                            </div>
                            <div class="col-12 mt-3">
                                <ul class="timeline">
                                    @foreach ($riwayat_ganti as $item)
                                        <li class="timeline-item">
                                            <div class="date w-auto">
                                                <div class="header">
                                                    <h6>{{ format_dfh($item->created_at) }}</h6>
                                                </div>
                                                <div class="bottom">
                                                    {{ format_time($item->created_at) }}
                                                </div>
                                            </div>
                                            <div class="circle"></div>
                                            <div class="message-timeline w-auto">
                                                <div class="header">
                                                    <h6 class="status text-capitalize">
                                                        {{ $item->status }}
                                                    </h6>
                                                </div>
                                                <div class="bottom text-capitalize">
                                                    Pengajuan telah
                                                    {{ strtolower($item->status) == 'proses' ? 'di' : '' }}
                                                    {{ $item->status }} oleh {{ roles($item->user->role) }}

                                                    @if ($item->status == 'diajukan')
                                                    <h6 class="status mt-1 mb-1">
                                                        Nama User
                                                    </h6>
                                                    {{ $item->user->nama }}
                                                    <h6 class="status mt-1 mb-1">
                                                        Departemen
                                                    </h6>
                                                    {{ $item->user->departemen }}
                                                    @endif

                                                    @if ($item->status != 'diajukan')
                                                        <h6 class="status mt-1 mb-1">
                                                            Nama Pemroses
                                                        </h6>
                                                        {{ $item->user->nama }}
                                                        @if ($item->user->role != "sarana")
                                                        <div class="keterangan">
                                                            <a href="##detail"
                                                                onclick="showReview('{{ $item->alasan }}', '{{ $item->user->nama }}', '{{ roles($item->user->role) }}')">Lihat
                                                                Keterangan</a>
                                                            <x-svg.icon.info />
                                                        </div>
                                                        @else
                                                        <div class="keterangan">
                                                            <a target="_blank" href="{{ asset('storage/rd/' . $item->dokumentasi_sarpras) }}">
                                                                <img src="{{ asset('assets/img/icon/Download.svg') }}" alt="Icon Download">
                                                                Lihat Dokumentasi
                                                            </a>
                                                        </div>
                                                        @endif

                                                    @endif
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif
                @endif
            </div>
        </div>

        @elseif (isKembalikan($rd->jenis))
            <div
            class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-6 mt-3 mt-sm-3 mt-md-3 mt-xl-0 animate__animated animate__fadeInRight">
            <div class="container ms-0 ms-sm-0 ms-md-0 ms-lg-0 ms-xl-5">
                @php
                    $lastOfRiwayat = $riwayat->sortBy('created_at')->last();
                @endphp

                @if (isManagerSection($lastOfRiwayat))
                    <div class="row mb-3">
                        <div class="col-12 popup-text">
                            <h6>Verifikasi Disini</h6>
                        </div>
                        <div class="col-12 mt-2">
                            <div class="d-flex gap-3">
                                <button class="btn btn-warning text-capitalize" data-bs-toggle="modal"
                                    data-bs-target="#modalVerifikasiPengajuan">
                                    Verifikasi
                                </button>
                            </div>
                        </div>
                    </div>
                @endif

                @if (isStaffSection($lastOfRiwayat))
                    <div class="row mb-3">
                        <div class="col-12 popup-text">
                            <h6>Verifikasi Disini</h6>
                        </div>
                        <div class="col-12 mt-2">
                            <div class="d-flex gap-3">
                                <button class="btn btn-warning text-capitalize" data-bs-toggle="modal"
                                    data-bs-target="#modalVerifikasiPengajuan">
                                    Verifikasi
                                </button>
                            </div>
                        </div>
                    </div>
                @endif

                @if (isSaranaSection($lastOfRiwayat))
                    <div class="row mb-3">
                        <div class="col-12 popup-text">
                            <h6>Verifikasi Disini</h6>
                        </div>
                        <div class="col-12 mt-2">
                            <div class="d-flex gap-3">
                                <button class="btn btn-warning text-capitalize" data-bs-toggle="modal"
                                    data-bs-target="#modalVerifikasiPengajuan">
                                    Verifikasi
                                </button>
                            </div>
                        </div>
                    </div>
                @endif

                @if (isMgrAdmSection($lastOfRiwayat))
                    <div class="row mb-3">
                        <div class="col-12 popup-text">
                            <h6>Verifikasi Disini</h6>
                        </div>
                        <div class="col-12 mt-2">
                            <div class="d-flex gap-3">
                                <button class="btn btn-warning text-capitalize" data-bs-toggle="modal"
                                    data-bs-target="#modalVerifikasiPengajuan">
                                    Verifikasi
                                </button>
                            </div>
                        </div>
                    </div>
                @endif

                @if (isAVPAdmSection($lastOfRiwayat))
                    <div class="row mb-3">
                        <div class="col-12 popup-text">
                            <h6>Verifikasi Disini</h6>
                        </div>
                    <div class="col-12 mt-2">
                        <div class="d-flex gap-3">
                              <button class="btn btn-warning text-capitalize" data-bs-toggle="modal"
                                data-bs-target="#modalVerifikasiPengajuan">
                                Verifikasi
                                </button>
                        </div>
                    </div>
                </div>
                @endif

                @if (isUserSection($lastOfRiwayat))
                    <div class="row mb-3">
                        <div class="col-12 popup-text">
                            <h6>Verifikasi Disini</h6>
                        </div>
                    <div class="col-12 mt-2">
                        <div class="d-flex gap-3">
                              <button class="btn btn-warning text-capitalize" data-bs-toggle="modal"
                                data-bs-target="#modalVerifikasiPengajuan">
                                Verifikasi
                                </button>
                        </div>
                    </div>
                </div>
                @endif

                @if (isset($riwayat_kembalikan))
                    @if (count($riwayat_kembalikan) > 0)
                        <div
                            class="row {{ (isStatusDiterima($kembalikan->status) || isStatusDitolak($kembalikan->status)) ? 'mt-5' : '' }}">
                            <div class="col-12">
                                <h6 class="riwayat-header">Riwayat</h6>
                            </div>
                            <div class="col-12 mt-3">
                                <ul class="timeline">
                                    @foreach ($riwayat_kembalikan as $item)
                                        <li class="timeline-item">
                                            <div class="date w-auto">
                                                <div class="header">
                                                    <h6>{{ format_dfh($item->created_at) }}</h6>
                                                </div>
                                                <div class="bottom">
                                                    {{ format_time($item->created_at) }}
                                                </div>
                                            </div>
                                            <div class="circle"></div>
                                            <div class="message-timeline w-auto">
                                                <div class="header">
                                                    <h6 class="status text-capitalize">
                                                        {{ $item->status }}
                                                    </h6>
                                                </div>
                                                <div class="bottom text-capitalize">
                                                    Pengajuan telah
                                                    {{ strtolower($item->status) == 'proses' ? 'di' : '' }}
                                                    {{ $item->status }} oleh {{ roles($item->user->role) }}

                                                    @if ($item->status == 'diajukan')
                                                    <h6 class="status mt-1 mb-1">
                                                        Nama User
                                                    </h6>
                                                    {{ $item->user->nama }}
                                                    <h6 class="status mt-1 mb-1">
                                                        Departemen
                                                    </h6>
                                                    {{ $item->user->departemen }}
                                                    @endif

                                                    @if ($item->status != 'diajukan')
                                                        <h6 class="status mt-1 mb-1">
                                                            Nama Pemroses
                                                        </h6>
                                                        {{ $item->user->nama }}
                                                        @if ($item->user->role != "sarana")
                                                        <div class="keterangan">
                                                            <a href="##detail"
                                                                onclick="showReview('{{ $item->alasan }}', '{{ $item->user->nama }}', '{{ roles($item->user->role) }}')">Lihat
                                                                Keterangan</a>
                                                            <x-svg.icon.info />
                                                        </div>
                                                        @else
                                                        <div class="keterangan">
                                                            <a target="_blank" href="{{ asset('storage/rd/' . $item->dokumentasi_sarpras) }}">
                                                                <img src="{{ asset('assets/img/icon/Download.svg') }}" alt="Icon Download">
                                                                Lihat Dokumentasi
                                                            </a>

                                                        </div>
                                                        @endif

                                                    @endif
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif
                @endif
            </div>
        </div>
        @endif
    </div>

     @if ($rd->jenis === 'Baru')
        <x-modals.admin id="modalVerifikasiPengajuan" action="{{ route('rd.verifikasiBaru', ['id' => $rd->id]) }}"
            class="modal-xl">
            @slot('slotHeader')
                <h5 class="modal-title" id="exampleModalLabel">
                    @if ($baru !== null && isStatusDiajukan($baru->status))
                        Review
                    @else
                        Verifikasi
                    @endif
                    Pengajuan
                </h5>
            @endslot

            @slot('slotBody')
                @if (isManagerSection($lastOfRiwayat))
                    <div class="mb-3">
                        <x-forms.select label="Verifikasi Berkas" name="verifikasi_rd"
                            placeholder="Pilih diterima atau ditolak">
                            <option value="review">Diterima</option>
                            <option value="ditolak">Ditolak</option>
                        </x-forms.select>
                    </div>
                    <div id="onlyDireview" style="display: none;">
                        <div class="mb-3">
                            <x-forms.select label="Pereview" name="peninjau"
                            placeholder="Pilih yang akan melakukan review" isRequired=0>
                            <option value="admin-comrel">Staf Admin 1 - Rekna</option>
                            <option value="admin-csr">Staf Admin 2 - Nomo</option>
                            <option value="admin-staf4">Staf Admin 4 - Wahyu</option>
                            <option value="admin-staf5">Staf Admin 5 - Irzami</option>
                            <option value="admin-staf6">Staf Admin 6 - Putri</option>
                        </x-forms.select>
                        </div>
                    </div>
                    @if (!($lastOfRiwayat->status === 'proses' && $lastOfRiwayat->peninjau === 'am'))
                        <div class="mb-3">
                            <x-forms.textarea name="keterangan" label="Keterangan" placeholder="Masukkan Keterangan" />
                        </div>
                    @endif


                @elseif (isStaffSection($lastOfRiwayat))
                    <div class="mb-3">
                        <x-forms.select label="Verifikasi Berkas" name="verifikasi_rd"
                            placeholder="Pilih diterima atau ditolak">
                            <option value="diterima">Diterima</option>
                            <option value="ditolak">Ditolak</option>
                        </x-forms.select>
                    </div>
                    @if (!($lastOfRiwayat->status === 'proses' && $lastOfRiwayat->peninjau === 'am'))
                        <div class="mb-3">
                            <x-forms.textarea name="keterangan" label="Keterangan" placeholder="Masukkan Keterangan" />
                        </div>
                    @endif

                @elseif (isSaranaSection($lastOfRiwayat))
                    @if (!($lastOfRiwayat->status === 'proses' && $lastOfRiwayat->peninjau === 'am'))
                        <div class="mb-3">
                            <x-forms.file name="dokumentasi_sarpras" label="Dokumentasi" placeholder="Upload File" />
                        </div>
                    @endif

                @elseif (isMgrAdmSection($lastOfRiwayat))
                    <div class="mb-3">
                        <x-forms.select label="Verifikasi Berkas" name="verifikasi_rd"
                            placeholder="Pilih diterima atau ditolak">
                            <option value="diterima">Diterima</option>
                            <option value="ditolak">Ditolak</option>
                        </x-forms.select>
                    </div>
                    @if (!($lastOfRiwayat->status === 'proses' && $lastOfRiwayat->peninjau === 'am'))
                    <div class="mb-3">
                        <x-forms.textarea name="keterangan" label="Keterangan" placeholder="Masukkan Keterangan" />
                    </div>
                    @endif

                @elseif (isAVPAdmSection($lastOfRiwayat))
                    <div class="mb-3">
                        <x-forms.select label="Verifikasi Berkas" name="verifikasi_rd"
                            placeholder="Pilih diterima atau ditolak">
                            <option value="diterima">Diterima</option>
                            <option value="ditolak">Ditolak</option>
                        </x-forms.select>
                    </div>
                    @if (!($lastOfRiwayat->status === 'proses' && $lastOfRiwayat->peninjau === 'am'))
                    <div class="mb-3">
                        <x-forms.textarea name="keterangan" label="Keterangan" placeholder="Masukkan Keterangan" />
                    </div>
                    @endif
                @elseif (isUserSection($lastOfRiwayat))
                    <div class="mb-3">
                        <x-forms.textarea name="keterangan" label="Keterangan" placeholder="Masukkan Keterangan" />
                    </div>
                @endif
            @endslot

            @slot('slotFooter')
                <button type="submit" class="btn btn-primary btn-tutup-modal">Verifikasi berkas</button>
            @endslot
            </x-modal.admin>

            <x-modals.admin id="modalReviewer" class="modal-xl">
                @slot('slotHeader')
                    <h5 class="modal-title" id="exampleModalLabel">Keterangan Review Berkas</h5>
                @endslot

                @slot('slotBody')
                    <div id="containerReviewer">
                        <div class="mb-3">
                            <h4 class="status mb-1" id="role">Staff</h5>
                                <h4 class="status" id="nama">Josep</h5>
                        </div>
                        <div id="review">
                            Hasil
                        </div>
                    </div>
                @endslot

                @slot('slotFooter')
                    <button type="button" data-bs-dismiss="modal" class="btn btn-primary btn-tutup-modal">Tutup</button>
                @endslot
                </x-modal.admin>

    @elseif ($rd->jenis === 'Ganti')
    <x-modals.admin id="modalVerifikasiPengajuan" action="{{ route('rd.verifikasiGanti', ['id' => $rd->id]) }}"
        class="modal-xl">
        @slot('slotHeader')
            <h5 class="modal-title" id="exampleModalLabel">
                @if ($ganti !== null && isStatusDiajukan($ganti->status))
                    Review
                @else
                    Verifikasi
                @endif
                Pengajuan
            </h5>
        @endslot

        @slot('slotBody')
            @if (isManagerSection($lastOfRiwayat))
                <div class="mb-3">
                    <x-forms.select label="Verifikasi Berkas" name="verifikasi_rd"
                        placeholder="Pilih diterima atau ditolak">
                        <option value="review">Diterima</option>
                        <option value="ditolak">Ditolak</option>
                    </x-forms.select>
                </div>
                <div id="onlyDireview" style="display: none;">
                    <div class="mb-3">
                        <x-forms.select label="Pereview" name="peninjau"
                        placeholder="Pilih yang akan melakukan review" isRequired=0>
                        <option value="admin-comrel">Staf Adm 2</option>
                        <option value="admin-csr">Staf Adm 3</option>
                        <option value="admin-staf4">Staf Admin 4 - Wahyu</option>
                            <option value="admin-staf5">Staf Admin 5 - Irzami</option>
                            <option value="admin-staf6">Staf Admin 6 - Putri</option>
                    </x-forms.select>
                    </div>
                </div>
            @if (!($lastOfRiwayat->status === 'proses' && $lastOfRiwayat->peninjau === 'am'))
                <div class="mb-3">
                    <x-forms.textarea name="keterangan" label="Keterangan" placeholder="Masukkan Keterangan" />
                </div>
            @endif

            @elseif (isStaffSection($lastOfRiwayat))
                    <div class="mb-3">
                        <x-forms.select label="Verifikasi Berkas" name="verifikasi_rd"
                            placeholder="Pilih diterima atau ditolak">
                            <option value="diterima">Diterima</option>
                            <option value="ditolak">Ditolak</option>
                        </x-forms.select>
                    </div>
                    @if (!($lastOfRiwayat->status === 'proses' && $lastOfRiwayat->peninjau === 'am'))
                        <div class="mb-3">
                            <x-forms.textarea name="keterangan" label="Keterangan" placeholder="Masukkan Keterangan" />
                        </div>
                    @endif

                    @elseif (isSaranaSection($lastOfRiwayat))
                    @if (!($lastOfRiwayat->status === 'proses' && $lastOfRiwayat->peninjau === 'am'))
                        <div class="mb-3">
                            <x-forms.textarea name="keterangan" label="Keterangan" placeholder="Masukkan Keterangan" />
                        </div>
                    @endif

                    @elseif (isMgrAdmSection($lastOfRiwayat))
                    <div class="mb-3">
                        <x-forms.select label="Verifikasi Berkas" name="verifikasi_rd"
                            placeholder="Pilih diterima atau ditolak">
                            <option value="diterima">Diterima</option>
                            <option value="ditolak">Ditolak</option>
                        </x-forms.select>
                    </div>
                    @if (!($lastOfRiwayat->status === 'proses' && $lastOfRiwayat->peninjau === 'am'))
                    <div class="mb-3">
                        <x-forms.textarea name="keterangan" label="Keterangan" placeholder="Masukkan Keterangan" />
                    </div>
                    @endif

                @elseif (isAVPAdmSection($lastOfRiwayat))
                    <div class="mb-3">
                        <x-forms.select label="Verifikasi Berkas" name="verifikasi_rd"
                            placeholder="Pilih diterima atau ditolak">
                            <option value="diterima">Diterima</option>
                            <option value="ditolak">Ditolak</option>
                        </x-forms.select>
                    </div>
                    @if (!($lastOfRiwayat->status === 'proses' && $lastOfRiwayat->peninjau === 'am'))
                    <div class="mb-3">
                        <x-forms.textarea name="keterangan" label="Keterangan" placeholder="Masukkan Keterangan" />
                    </div>
                    @endif

                    @elseif (isUserSection($lastOfRiwayat))
                    <div class="mb-3">
                        <x-forms.textarea name="keterangan" label="Keterangan" placeholder="Masukkan Keterangan" />
                    </div>

            @endif
        @endslot
        @slot('slotFooter')
            <button type="submit" class="btn btn-primary btn-tutup-modal">Verifikasi berkas</button>
        @endslot
        </x-modal.admin>

        <x-modals.admin id="modalReviewer" class="modal-xl">
            @slot('slotHeader')
                <h5 class="modal-title" id="exampleModalLabel">Keterangan</h5>
            @endslot

            @slot('slotBody')
                <div id="containerReviewer">
                    <div class="mb-3">
                        <h4 class="status mb-1" id="role">Staff</h5>
                            <h4 class="status" id="nama">Josep</h5>
                    </div>
                    <div id="review">
                        Hasil
                    </div>
                </div>
            @endslot

            @slot('slotFooter')
                <button type="button" data-bs-dismiss="modal" class="btn btn-primary btn-tutup-modal">Tutup</button>
            @endslot
            </x-modal.admin>



            @elseif ($rd->jenis === 'Kembalikan')
    <x-modals.admin id="modalVerifikasiPengajuan" action="{{ route('rd.verifikasiKembalikan', ['id' => $rd->id]) }}"
        class="modal-xl">
        @slot('slotHeader')
            <h5 class="modal-title" id="exampleModalLabel">
                @if ($kembalikan !== null && isStatusDiajukan($kembalikan->status))
                    Review
                @else
                    Verifikasi
                @endif
                Pengajuan
            </h5>
        @endslot

        @slot('slotBody')
            @if (isManagerSection($lastOfRiwayat))
                <div class="mb-3">
                    <x-forms.select label="Verifikasi Berkas" name="verifikasi_rd"
                        placeholder="Pilih diterima atau ditolak">
                        <option value="review">Diterima</option>
                        <option value="ditolak">Ditolak</option>
                    </x-forms.select>
                </div>
                <div id="onlyDireview" style="display: none;">
                    <div class="mb-3">
                        <x-forms.select label="Pereview" name="peninjau"
                        placeholder="Pilih yang akan melakukan review" isRequired=0>
                        <option value="admin-comrel">Staf Adm 2</option>
                        <option value="admin-csr">Staf Adm 3</option>
                        <option value="admin-staf4">Staf Admin 4 - Wahyu</option>
                            <option value="admin-staf5">Staf Admin 5 - Irzami</option>
                            <option value="admin-staf6">Staf Admin 6 - Putri</option>
                    </x-forms.select>
                    </div>
                </div>
            @if (!($lastOfRiwayat->status === 'proses' && $lastOfRiwayat->peninjau === 'am'))
                <div class="mb-3">
                    <x-forms.textarea name="keterangan" label="Keterangan" placeholder="Masukkan Keterangan" />
                </div>
            @endif

            @elseif (isStaffSection($lastOfRiwayat))
                    <div class="mb-3">
                        <x-forms.select label="Verifikasi Berkas" name="verifikasi_rd"
                            placeholder="Pilih diterima atau ditolak">
                            <option value="diterima">Diterima</option>
                            <option value="ditolak">Ditolak</option>
                        </x-forms.select>
                    </div>
                    @if (!($lastOfRiwayat->status === 'proses' && $lastOfRiwayat->peninjau === 'am'))
                        <div class="mb-3">
                            <x-forms.textarea name="keterangan" label="Keterangan" placeholder="Masukkan Keterangan" />
                        </div>
                    @endif

                    @elseif (isSaranaSection($lastOfRiwayat))
                    @if (!($lastOfRiwayat->status === 'proses' && $lastOfRiwayat->peninjau === 'am'))
                        <div class="mb-3">
                            <x-forms.textarea name="keterangan" label="Keterangan" placeholder="Masukkan Keterangan" />
                        </div>
                    @endif

                    @elseif (isMgrAdmSection($lastOfRiwayat))
                    <div class="mb-3">
                        <x-forms.select label="Verifikasi Berkas" name="verifikasi_rd"
                            placeholder="Pilih diterima atau ditolak">
                            <option value="diterima">Diterima</option>
                            <option value="ditolak">Ditolak</option>
                        </x-forms.select>
                    </div>
                    @if (!($lastOfRiwayat->status === 'proses' && $lastOfRiwayat->peninjau === 'am'))
                    <div class="mb-3">
                        <x-forms.textarea name="keterangan" label="Keterangan" placeholder="Masukkan Keterangan" />
                    </div>
                    @endif

                @elseif (isAVPAdmSection($lastOfRiwayat))
                    <div class="mb-3">
                        <x-forms.select label="Verifikasi Berkas" name="verifikasi_rd"
                            placeholder="Pilih diterima atau ditolak">
                            <option value="diterima">Diterima</option>
                            <option value="ditolak">Ditolak</option>
                        </x-forms.select>
                    </div>
                    @if (!($lastOfRiwayat->status === 'proses' && $lastOfRiwayat->peninjau === 'am'))
                    <div class="mb-3">
                        <x-forms.textarea name="keterangan" label="Keterangan" placeholder="Masukkan Keterangan" />
                    </div>
                    @endif

                    @elseif (isUserSection($lastOfRiwayat))
                    <div class="mb-3">
                        <x-forms.textarea name="keterangan" label="Keterangan" placeholder="Masukkan Keterangan" />
                    </div>

            @endif
        @endslot
        @slot('slotFooter')
            <button type="submit" class="btn btn-primary btn-tutup-modal">Verifikasi berkas</button>
        @endslot
        </x-modal.admin>

        <x-modals.admin id="modalReviewer" class="modal-xl">
            @slot('slotHeader')
                <h5 class="modal-title" id="exampleModalLabel">Keterangan</h5>
            @endslot

            @slot('slotBody')
                <div id="containerReviewer">
                    <div class="mb-3">
                        <h4 class="status mb-1" id="role">Staff</h5>
                            <h4 class="status" id="nama">Josep</h5>
                    </div>
                    <div id="review">
                        Hasil
                    </div>
                </div>
            @endslot

            @slot('slotFooter')
                <button type="button" data-bs-dismiss="modal" class="btn btn-primary btn-tutup-modal">Tutup</button>
            @endslot
            </x-modal.admin>
    @endif

@endsection

@section('scripts')
    <script>
         ['dokumentasi_sarpras'].forEach(function (id) {
            gambarHandler(id);
        });
        createEditor("#keterangan")
        createEditor("#penolakan")

        currencyInInput("#anggaran")

        gambarHandler("dokumentasi")

        $('#verifikasi_rd').change(function() {
            var value = $(this).val()

            if (value.toLowerCase() === "review") {
                $('#onlyDireview').show()
                $('#onlyDiterima').hide()
            }else {
                $('#onlyDiterima').hide()
                $('#onlyDireview').hide()
            }
        })
    </script>
@endsection
