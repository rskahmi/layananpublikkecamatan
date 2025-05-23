@extends('layout.user')

@section('title', 'Detail Pengajuan')
@section('headers')
    <script src="https://cdn.ckeditor.com/ckeditor5/41.2.0/classic/ckeditor.js"></script>
@endsection
@section('content')
    <x-svg.fitur.berkas />
    @php
        if(isBBM($surat->jenis)) {
            $bbm = $surat->bbm;
            $riwayat = $surat->bbm->riwayat;
        }
        else if (isKTP($surat->jenis)) {
            $ktp = $surat->ktp;
            $riwayat = $surat->ktp->riwayat;
        }
        else if (isKK($surat->jenis)) {
            $kk = $surat->kk;
            $riwayat = $surat->kk->riwayat;
        }
        else if (isSKTM($surat->jenis)) {
            $sktm = $surat->sktm;
            $riwayat = $surat->sktm->riwayat;
        }
    @endphp

    <div class="row detail-pengajuan">
        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-6 animate__animated animate__fadeInLeft">
            <div class="card standart">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-6 mt-2 mt-sm-2 mt-md-3">
                            <x-text.PopUpMenu title="Jenis" subtitle="{{ $surat->jenis }}" />
                        </div>
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-6 mt-2 mt-sm-2 mt-md-3">
                            <x-text.PopUpMenu title="Tanggal Diajukan" subtitle="{{ format_dfy($surat->tanggal) }}" />
                        </div>
                        @if (isBBM($surat->jenis))
                            @if ( $bbm !== null)
                            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-6 mt-2 mt-sm-2 mt-md-3 popup-text">
                                <h6>KTP</h6>
                                <a target="_blank" href="{{ asset('storage/surat/' . $bbm->ktp_bbm) }}">
                                    <img src="{{ asset('assets/img/icon/Download.svg') }}" alt="Icon Download">
                                    Buka Disini
                                </a>
                            </div>
                            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-6 mt-2 mt-sm-2 mt-md-3 popup-text">
                                <h6>NIMB</h6>
                                <a target="_blank" href="{{ asset('storage/surat/' . $bbm->nimb_bbm) }}">
                                    <img src="{{ asset('assets/img/icon/Download.svg') }}" alt="Icon Download">
                                    Buka Disini
                                </a>
                            </div>
                            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-6 mt-2 mt-sm-2 mt-md-3 popup-text">
                                <h6>Status</h6>
                                <span
                                    class="badge text-capitalize
                                    {{ isStatusDiterima($bbm->status) ? 'bg-success' : (isStatusProses($bbm->status) ? 'bg-warning' : (isStatusDitolak($bbm->status) ? 'bg-danger' : 'bg-warning-subtle text-dark')) }}">{{ $bbm->status }}</span>
                            </div>
                            @endif
                        @elseif (isKTP($surat->jenis))
                            @if ( $ktp !== null)
                            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-6 mt-2 mt-sm-2 mt-md-3 popup-text">
                                <h6>KK</h6>
                                <a target="_blank" href="{{ asset('storage/surat/' . $ktp->kk_ktp) }}">
                                    <img src="{{ asset('assets/img/icon/Download.svg') }}" alt="Icon Download">
                                    Buka Disini
                                </a>
                            </div>
                            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-6 mt-2 mt-sm-2 mt-md-3 popup-text">
                                <h6>Surat Kelurahan</h6>
                                <a target="_blank" href="{{ asset('storage/surat/' . $ktp->suratkelurahan_ktp) }}">
                                    <img src="{{ asset('assets/img/icon/Download.svg') }}" alt="Icon Download">
                                    Buka Disini
                                </a>
                            </div>
                            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-6 mt-2 mt-sm-2 mt-md-3 popup-text">
                                <h6>Status</h6>
                                <span
                                    class="badge text-capitalize
                                    {{ isStatusDiterima($ktp->status) ? 'bg-success' : (isStatusProses($ktp->status) ? 'bg-warning' : (isStatusDitolak($ktp->status) ? 'bg-danger' : 'bg-warning-subtle text-dark')) }}">{{ $ktp->status }}</span>
                            </div>
                            @endif
                        @elseif (isKK($surat->jenis))
                            @if ( $kk !== null)
                            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-6 mt-2 mt-sm-2 mt-md-3 popup-text">
                                <h6>KK</h6>
                                <a target="_blank" href="{{ asset('storage/surat/' . $kk->ktp_kk) }}">
                                    <img src="{{ asset('assets/img/icon/Download.svg') }}" alt="Icon Download">
                                    Buka Disini
                                </a>
                            </div>
                            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-6 mt-2 mt-sm-2 mt-md-3 popup-text">
                                <h6>Surat Kelurahan</h6>
                                <a target="_blank" href="{{ asset('storage/surat/' . $kk->suratkelurahan_kk) }}">
                                    <img src="{{ asset('assets/img/icon/Download.svg') }}" alt="Icon Download">
                                    Buka Disini
                                </a>
                            </div>
                            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-6 mt-2 mt-sm-2 mt-md-3 popup-text">
                                <h6>Status</h6>
                                <span
                                    class="badge text-capitalize
                                    {{ isStatusDiterima($kk->status) ? 'bg-success' : (isStatusProses($kk->status) ? 'bg-warning' : (isStatusDitolak($kk->status) ? 'bg-danger' : 'bg-warning-subtle text-dark')) }}">{{ $kk->status }}</span>
                            </div>
                            @endif
                        @elseif (isSKTM($surat->jenis))
                            @if ( $sktm !== null)
                            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-6 mt-2 mt-sm-2 mt-md-3 popup-text">
                                <h6>KK</h6>
                                <a target="_blank" href="{{ asset('storage/surat/' . $sktm->ktm_sktm) }}">
                                    <img src="{{ asset('assets/img/icon/Download.svg') }}" alt="Icon Download">
                                    Buka Disini
                                </a>
                            </div>
                            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-6 mt-2 mt-sm-2 mt-md-3 popup-text">
                                <h6>Surat Kelurahan</h6>
                                <a target="_blank" href="{{ asset('storage/surat/' . $sktm->suratkelurahan_sktm) }}">
                                    <img src="{{ asset('assets/img/icon/Download.svg') }}" alt="Icon Download">
                                    Buka Disini
                                </a>
                            </div>
                            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-6 mt-2 mt-sm-2 mt-md-3 popup-text">
                                <h6>Status</h6>
                                <span
                                    class="badge text-capitalize
                                    {{ isStatusDiterima($sktm->status) ? 'bg-success' : (isStatusProses($sktm->status) ? 'bg-warning' : (isStatusDitolak($sktm->status) ? 'bg-danger' : 'bg-warning-subtle text-dark')) }}">{{ $sktm->status }}</span>
                            </div>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>


        @if (isBBM($surat->jenis))
        <div
            class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-6 mt-3 mt-sm-3 mt-md-3 mt-xl-0 animate__animated animate__fadeInRight">
            <div class="container ms-0 ms-sm-0 ms-md-0 ms-lg-0 ms-xl-5">
                @php
                    $lastOfRiwayat = $riwayat->sortBy('created_at')->last();
                @endphp

                @if (isPetugasAdministrasiSection($lastOfRiwayat))
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



                @if (isKepalaSeksiSection($lastOfRiwayat))
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

                @if (isSekretarisCamatSection($lastOfRiwayat))
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

                @if (isCamatSection($lastOfRiwayat))
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

                @if (isMasyarakatSection($lastOfRiwayat))
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


                @if (isset($riwayat_bbm))
                    @if (count($riwayat_bbm) > 0)
                        <div
                            class="row {{ (isStatusDiterima($bbm->status) || isStatusDitolak($bbm->status)) ? 'mt-5' : '' }}">
                            <div class="col-12">
                                <h6 class="riwayat-header">Riwayat</h6>
                            </div>
                            <div class="col-12 mt-3">
                                <ul class="timeline">
                                    @foreach ($riwayat_bbm as $item)
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

                                                    @endif

                                                    @if ($item->status != 'diajukan')
                                                        <h6 class="status mt-1 mb-1">
                                                            Nama Pemroses
                                                        </h6>
                                                        {{ $item->user->nama }}
                                                        <div class="keterangan">
                                                            <a href="##detail"
                                                                onclick="showReview('{{ $item->alasan }}', '{{ $item->user->nama }}', '{{ roles($item->user->role) }}')">Lihat
                                                                Keterangan</a>
                                                            <x-svg.icon.info />
                                                        </div>
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

        @elseif (isKTP($surat->jenis))
            <div
            class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-6 mt-3 mt-sm-3 mt-md-3 mt-xl-0 animate__animated animate__fadeInRight">
            <div class="container ms-0 ms-sm-0 ms-md-0 ms-lg-0 ms-xl-5">
                @php
                    $lastOfRiwayat = $riwayat->sortBy('created_at')->last();
                @endphp

                @if (isPetugasAdministrasiSection($lastOfRiwayat))
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



                @if (isKepalaSeksiSection($lastOfRiwayat))
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

                @if (isSekretarisCamatSection($lastOfRiwayat))
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

                @if (isMasyarakatSection($lastOfRiwayat))
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

                @if (isset($riwayat_ktp))
                    @if (count($riwayat_ktp) > 0)
                        <div
                            class="row {{ (isStatusDiterima($ktp->status) || isStatusDitolak($ktp->status)) ? 'mt-5' : '' }}">
                            <div class="col-12">
                                <h6 class="riwayat-header">Riwayat</h6>
                            </div>
                            <div class="col-12 mt-3">
                                <ul class="timeline">
                                    @foreach ($riwayat_ktp as $item)
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

                                                    @endif

                                                    @if ($item->status != 'diajukan')
                                                        <h6 class="status mt-1 mb-1">
                                                            Nama Pemroses
                                                        </h6>
                                                        {{ $item->user->nama }}
                                                        <div class="keterangan">
                                                            <a href="##detail"
                                                                onclick="showReview('{{ $item->alasan }}', '{{ $item->user->nama }}', '{{ roles($item->user->role) }}')">Lihat
                                                                Keterangan</a>
                                                            <x-svg.icon.info />
                                                        </div>
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


        @elseif (isKK($surat->jenis))
            <div
            class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-6 mt-3 mt-sm-3 mt-md-3 mt-xl-0 animate__animated animate__fadeInRight">
            <div class="container ms-0 ms-sm-0 ms-md-0 ms-lg-0 ms-xl-5">
                @php
                    $lastOfRiwayat = $riwayat->sortBy('created_at')->last();
                @endphp

                @if (isPetugasAdministrasiSection($lastOfRiwayat))
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


                @if (isKepalaSeksiSection($lastOfRiwayat))
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

                @if (isSekretarisCamatSection($lastOfRiwayat))
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

                @if (isMasyarakatSection($lastOfRiwayat))
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

                @if (isset($riwayat_kk))
                    @if (count($riwayat_kk) > 0)
                        <div
                            class="row {{ (isStatusDiterima($kk->status) || isStatusDitolak($kk->status)) ? 'mt-5' : '' }}">
                            <div class="col-12">
                                <h6 class="riwayat-header">Riwayat</h6>
                            </div>
                            <div class="col-12 mt-3">
                                <ul class="timeline">
                                    @foreach ($riwayat_kk as $item)
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

                                                    @endif

                                                    @if ($item->status != 'diajukan')
                                                        <h6 class="status mt-1 mb-1">
                                                            Nama Pemroses
                                                        </h6>
                                                        {{ $item->user->nama }}
                                                        <div class="keterangan">
                                                            <a href="##detail"
                                                                onclick="showReview('{{ $item->alasan }}', '{{ $item->user->nama }}', '{{ roles($item->user->role) }}')">Lihat
                                                                Keterangan</a>
                                                            <x-svg.icon.info />
                                                        </div>
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


        @elseif (isSKTM($surat->jenis))
            <div
            class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-6 mt-3 mt-sm-3 mt-md-3 mt-xl-0 animate__animated animate__fadeInRight">
            <div class="container ms-0 ms-sm-0 ms-md-0 ms-lg-0 ms-xl-5">
                @php
                    $lastOfRiwayat = $riwayat->sortBy('created_at')->last();
                @endphp

                @if (isPetugasAdministrasiSection($lastOfRiwayat))
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



                @if (isKepalaSeksiSection($lastOfRiwayat))
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

                @if (isSekretarisCamatSection($lastOfRiwayat))
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

                @if (isMasyarakatSection($lastOfRiwayat))
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

                @if (isset($riwayat_sktm))
                    @if (count($riwayat_sktm) > 0)
                        <div
                            class="row {{ (isStatusDiterima($sktm->status) || isStatusDitolak($sktm->status)) ? 'mt-5' : '' }}">
                            <div class="col-12">
                                <h6 class="riwayat-header">Riwayat</h6>
                            </div>
                            <div class="col-12 mt-3">
                                <ul class="timeline">
                                    @foreach ($riwayat_sktm as $item)
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

                                                    @endif

                                                    @if ($item->status != 'diajukan')
                                                        <h6 class="status mt-1 mb-1">
                                                            Nama Pemroses
                                                        </h6>
                                                        {{ $item->user->nama }}
                                                        <div class="keterangan">
                                                            <a href="##detail"
                                                                onclick="showReview('{{ $item->alasan }}', '{{ $item->user->nama }}', '{{ roles($item->user->role) }}')">Lihat
                                                                Keterangan</a>
                                                            <x-svg.icon.info />
                                                        </div>
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




        {{-- Batas IF Paling atas --}}
        @endif
    </div>

    @if ($surat->jenis === 'BBM')
        <x-modals.admin id="modalVerifikasiPengajuan" action="{{route('surat.verifikasiBBM', ['id' => $surat->id])}}"
            class="modal-xl">
            @slot('slotHeader')
                <h5 class="modal-title" id="exampleModalLabel">
                    @if ($bbm !== null && isStatusDiajukan($bbm->status))
                        Review
                    @else
                        Verifikasi
                    @endif
                    Pengajuan
                </h5>
            @endslot

            @slot('slotBody')
                @if (isPetugasAdministrasiSection($lastOfRiwayat))
                    <div class="mb-3">
                        <x-forms.select label="Verifikasi Berkas" name="verifikasi_surat"
                            placeholder="Pilih diterima atau ditolak">
                            <option value="diterima">Diterima</option>
                            <option value="ditolak">Ditolak</option>
                        </x-forms.select>
                    </div>
                    {{-- @if (!($lastOfRiwayat->status === 'proses' && $lastOfRiwayat->peninjau === 'am')) --}}
                        {{-- <div class="mb-3">
                            <x-forms.textarea name="keterangan" label="Keterangan" placeholder="Masukkan Keterangan" />
                        </div> --}}
                    {{-- @endif --}}



                @elseif (isKepalaSeksiSection($lastOfRiwayat))
                    <div class="mb-3">
                        <x-forms.select label="Verifikasi Berkas" name="verifikasi_surat"
                            placeholder="Pilih diterima atau ditolak">
                            <option value="diterima">Diterima</option>
                            <option value="ditolak">Ditolak</option>
                        </x-forms.select>
                    </div>
                    {{-- @if (!($lastOfRiwayat->status === 'proses' && $lastOfRiwayat->peninjau === 'am')) --}}
                    <div class="mb-3">
                        <x-forms.textarea name="keterangan" label="Keterangan" placeholder="Masukkan Keterangan" />
                    </div>
                    {{-- @endif --}}

                @elseif (isSekretarisCamatSection($lastOfRiwayat))
                    <div class="mb-3">
                        <x-forms.select label="Verifikasi Berkas" name="verifikasi_surat"
                            placeholder="Pilih diterima atau ditolak">
                            <option value="diterima">Diterima</option>
                            <option value="ditolak">Ditolak</option>
                        </x-forms.select>
                    </div>
                    {{-- @if (!($lastOfRiwayat->status === 'proses' && $lastOfRiwayat->peninjau === 'am')) --}}
                    <div class="mb-3">
                        <x-forms.textarea name="keterangan" label="Keterangan" placeholder="Masukkan Keterangan" />
                    </div>
                    {{-- @endif --}}

                @elseif (isCamatSection($lastOfRiwayat))
                    <div class="mb-3">
                        <x-forms.select label="Verifikasi Berkas" name="verifikasi_surat"
                            placeholder="Pilih diterima atau ditolak">
                            <option value="diterima">Diterima</option>
                            <option value="ditolak">Ditolak</option>
                        </x-forms.select>
                    </div>
                    {{-- @if (!($lastOfRiwayat->status === 'proses' && $lastOfRiwayat->peninjau === 'am')) --}}
                    <div class="mb-3">
                        <x-forms.textarea name="keterangan" label="Keterangan" placeholder="Masukkan Keterangan" />
                    </div>
                    {{-- @endif --}}


                @elseif (isMasyarakatSection($lastOfRiwayat))
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

    @elseif ($surat->jenis === 'KTP')
    <x-modals.admin id="modalVerifikasiPengajuan" action="{{route('surat.verifikasiKTP', ['id' => $surat->id])}}"
        class="modal-xl">
        @slot('slotHeader')
            <h5 class="modal-title" id="exampleModalLabel">
                @if ($ktp !== null && isStatusDiajukan($ktp->status))
                    Review
                @else
                    Verifikasi
                @endif
                Pengajuan
            </h5>
        @endslot

        @slot('slotBody')
            @if (isPetugasAdministrasiSection($lastOfRiwayat))
                <div class="mb-3">
                    <x-forms.select label="Verifikasi Berkas" name="verifikasi_surat"
                        placeholder="Pilih diterima atau ditolak">
                        <option value="diterima">Diterima</option>
                        <option value="ditolak">Ditolak</option>
                    </x-forms.select>
                </div>
            {{-- @if (!($lastOfRiwayat->status === 'proses' && $lastOfRiwayat->peninjau === 'am')) --}}
                <div class="mb-3">
                    <x-forms.textarea name="keterangan" label="Keterangan" placeholder="Masukkan Keterangan" />
                </div>
            {{-- @endif --}}


                    @elseif (isKepalaSeksiSection($lastOfRiwayat))
                    <div class="mb-3">
                        <x-forms.select label="Verifikasi Berkas" name="verifikasi_surat"
                            placeholder="Pilih diterima atau ditolak">
                            <option value="diterima">Diterima</option>
                            <option value="ditolak">Ditolak</option>
                        </x-forms.select>
                    </div>
                    {{-- @if (!($lastOfRiwayat->status === 'proses' && $lastOfRiwayat->peninjau === 'am')) --}}
                    <div class="mb-3">
                        <x-forms.textarea name="keterangan" label="Keterangan" placeholder="Masukkan Keterangan" />
                    </div>
                    {{-- @endif --}}

                @elseif (isSekretarisCamatSection($lastOfRiwayat))
                    <div class="mb-3">
                        <x-forms.select label="Verifikasi Berkas" name="verifikasi_surat"
                            placeholder="Pilih diterima atau ditolak">
                            <option value="diterima">Diterima</option>
                            <option value="ditolak">Ditolak</option>
                        </x-forms.select>
                    </div>
                    {{-- @if (!($lastOfRiwayat->status === 'proses' && $lastOfRiwayat->peninjau === 'am')) --}}
                    <div class="mb-3">
                        <x-forms.textarea name="keterangan" label="Keterangan" placeholder="Masukkan Keterangan" />
                    </div>
                    {{-- @endif --}}

                    @elseif (isMasyarakatSection($lastOfRiwayat))
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

            @elseif ($surat->jenis === 'KK')
            <x-modals.admin id="modalVerifikasiPengajuan" action="{{route('surat.verifikasiKK', ['id' => $surat->id])}}"
                class="modal-xl">
                @slot('slotHeader')
                    <h5 class="modal-title" id="exampleModalLabel">
                        @if ($kk !== null && isStatusDiajukan($kk->status))
                            Review
                        @else
                            Verifikasi
                        @endif
                        Pengajuan
                    </h5>
                @endslot

                @slot('slotBody')
                    @if (isPetugasAdministrasiSection($lastOfRiwayat))
                        <div class="mb-3">
                            <x-forms.select label="Verifikasi Berkas" name="verifikasi_surat"
                                placeholder="Pilih diterima atau ditolak">
                                <option value="diterima">Diterima</option>
                                <option value="ditolak">Ditolak</option>
                            </x-forms.select>
                        </div>
                    {{-- @if (!($lastOfRiwayat->status === 'proses' && $lastOfRiwayat->peninjau === 'am')) --}}
                        <div class="mb-3">
                            <x-forms.textarea name="keterangan" label="Keterangan" placeholder="Masukkan Keterangan" />
                        </div>
                    {{-- @endif --}}



                            @elseif (isKepalaSeksiSection($lastOfRiwayat))
                            <div class="mb-3">
                                <x-forms.select label="Verifikasi Berkas" name="verifikasi_surat"
                                    placeholder="Pilih diterima atau ditolak">
                                    <option value="diterima">Diterima</option>
                                    <option value="ditolak">Ditolak</option>
                                </x-forms.select>
                            </div>
                            {{-- @if (!($lastOfRiwayat->status === 'proses' && $lastOfRiwayat->peninjau === 'am')) --}}
                            <div class="mb-3">
                                <x-forms.textarea name="keterangan" label="Keterangan" placeholder="Masukkan Keterangan" />
                            </div>
                            {{-- @endif --}}

                        @elseif (isSekretarisCamatSection($lastOfRiwayat))
                            <div class="mb-3">
                                <x-forms.select label="Verifikasi Berkas" name="verifikasi_surat"
                                    placeholder="Pilih diterima atau ditolak">
                                    <option value="diterima">Diterima</option>
                                    <option value="ditolak">Ditolak</option>
                                </x-forms.select>
                            </div>
                            {{-- @if (!($lastOfRiwayat->status === 'proses' && $lastOfRiwayat->peninjau === 'am')) --}}
                            <div class="mb-3">
                                <x-forms.textarea name="keterangan" label="Keterangan" placeholder="Masukkan Keterangan" />
                            </div>
                            {{-- @endif --}}

                            @elseif (isMasyarakatSection($lastOfRiwayat))
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


                    @elseif ($surat->jenis === 'SKTM')
    <x-modals.admin id="modalVerifikasiPengajuan" action="{{route('surat.verifikasiSKTM', ['id' => $surat->id])}}"
        class="modal-xl">
        @slot('slotHeader')
            <h5 class="modal-title" id="exampleModalLabel">
                @if ($sktm !== null && isStatusDiajukan($sktm->status))
                    Review
                @else
                    Verifikasi
                @endif
                Pengajuan
            </h5>
        @endslot

        @slot('slotBody')
            @if (isPetugasAdministrasiSection($lastOfRiwayat))
                <div class="mb-3">
                    <x-forms.select label="Verifikasi Berkas" name="verifikasi_surat"
                        placeholder="Pilih diterima atau ditolak">
                        <option value="diterima">Diterima</option>
                        <option value="ditolak">Ditolak</option>
                    </x-forms.select>
                </div>
            {{-- @if (!($lastOfRiwayat->status === 'proses' && $lastOfRiwayat->peninjau === 'am')) --}}
                <div class="mb-3">
                    <x-forms.textarea name="keterangan" label="Keterangan" placeholder="Masukkan Keterangan" />
                </div>
            {{-- @endif --}}


                    @elseif (isKepalaSeksiSection($lastOfRiwayat))
                    <div class="mb-3">
                        <x-forms.select label="Verifikasi Berkas" name="verifikasi_surat"
                            placeholder="Pilih diterima atau ditolak">
                            <option value="diterima">Diterima</option>
                            <option value="ditolak">Ditolak</option>
                        </x-forms.select>
                    </div>
                    {{-- @if (!($lastOfRiwayat->status === 'proses' && $lastOfRiwayat->peninjau === 'am')) --}}
                    <div class="mb-3">
                        <x-forms.textarea name="keterangan" label="Keterangan" placeholder="Masukkan Keterangan" />
                    </div>
                    {{-- @endif --}}

                @elseif (isSekretarisCamatSection($lastOfRiwayat))
                    <div class="mb-3">
                        <x-forms.select label="Verifikasi Berkas" name="verifikasi_surat"
                            placeholder="Pilih diterima atau ditolak">
                            <option value="diterima">Diterima</option>
                            <option value="ditolak">Ditolak</option>
                        </x-forms.select>
                    </div>
                    {{-- @if (!($lastOfRiwayat->status === 'proses' && $lastOfRiwayat->peninjau === 'am')) --}}
                    <div class="mb-3">
                        <x-forms.textarea name="keterangan" label="Keterangan" placeholder="Masukkan Keterangan" />
                    </div>
                    {{-- @endif --}}

                    @elseif (isMasyarakatSection($lastOfRiwayat))
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
             {{-- BATAS IF --}}
    @endif

@endsection

@section('scripts')
    <script>
        createEditor("#keterangan")
        createEditor("#penolakan")

        currencyInInput("#anggaran")

        gambarHandler("dokumen")

        $('#verifikasi_npp').change(function() {
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
