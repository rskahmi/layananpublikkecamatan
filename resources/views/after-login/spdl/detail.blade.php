@extends('layout.user')

@section('title', 'Detail Pengajuan')
@section('headers')
    <script src="https://cdn.ckeditor.com/ckeditor5/41.2.0/classic/ckeditor.js"></script>
@endsection
@section('content')
    <x-svg.fitur.berkas />

    {{-- @php
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
    @endphp --}}
    @php
        $riwayat = $spdl->riwayat;
    @endphp

    <div class="row detail-pengajuan">
        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-6 animate__animated animate__fadeInLeft">
            <div class="card standart">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-6 mt-2 mt-sm-2 mt-md-3">
                            <x-text.PopUpMenu title="Tanggal Diajukan" subtitle="{{ format_dfy($spdl->tanggal) }}" />
                        </div>
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-6 mt-2 mt-sm-2 mt-md-3">
                            <x-text.PopUpMenu title="Tanggal Berangkat" subtitle="{{ format_dfy($spdl->tanggalberangkat) }}" />
                        </div>
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-6 mt-2 mt-sm-2 mt-md-3">
                            <x-text.PopUpMenu title="Tanggal Pulang" subtitle="{{ format_dfy($spdl->tanggalpulang) }}" />
                        </div>
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-6 mt-2 mt-sm-2 mt-md-3">
                            <x-text.PopUpMenu title="Tujuan" subtitle="{{ $spdl->tujuan }}" />
                        </div>
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-6 mt-2 mt-sm-2 mt-md-3 popup-text">
                            <h6>Lampiran Email dan Data Pelaku Perjalanan </h6>
                            <a target="_blank" href="{{ asset('storage/spdl/' . $spdl->lampiran) }}">
                                <img src="{{ asset('assets/img/icon/Download.svg') }}" alt="Icon Download">
                                Buka Disini
                            </a>
                        </div>
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-6 mt-2 mt-sm-2 mt-md-3 popup-text">
                            <h6>Status</h6>
                            <span
                                class="badge text-capitalize
                                {{ isStatusDiterima($spdl->status) ? 'bg-success' : (isStatusProses($spdl->status) ? 'bg-warning' : (isStatusDitolak($spdl->status) ? 'bg-danger' : 'bg-warning-subtle text-dark')) }}">{{ $spdl->status }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>



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


                @if (isset($riwayat_spdl))
                    @if (count($riwayat_spdl) > 0)
                        <div
                            class="row {{ (isStatusDiterima($spdl->status) || isStatusDitolak($spdl->status)) ? 'mt-5' : '' }}">
                            <div class="col-12">
                                <h6 class="riwayat-header">Riwayat</h6>
                            </div>
                            <div class="col-12 mt-3">
                                <ul class="timeline">
                                    @foreach ($riwayat_spdl as $item)
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
    </div>


        <x-modals.admin id="modalVerifikasiPengajuan" action="{{ route('spdl.verifikasi', ['id' => $spdl->id]) }}"
            class="modal-xl">
            @slot('slotHeader')
                <h5 class="modal-title" id="exampleModalLabel">
                    @if ($spdl !== null && isStatusDiajukan($spdl->status))
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
                        <x-forms.select label="Verifikasi Berkas" name="verifikasi"
                            placeholder="Pilih diterima atau ditolak">
                            <option value="review">Diterima</option>
                            <option value="ditolak">Ditolak</option>
                        </x-forms.select>
                    </div>
                    <div id="onlyDireview" style="display: none;">
                        <div class="mb-3">
                            <x-forms.select label="Pereview" name="peninjau"
                            placeholder="Pilih yang akan melakukan review" isRequired=0>
                            <option value="admin-comrel">Staf Admin 2 - Rekna</option>
                            <option value="admin-csr">Staf Admin 3 - Nomo</option>
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
                        <x-forms.select label="Verifikasi Berkas" name="verifikasi"
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

                @elseif (isMgrAdmSection($lastOfRiwayat))
                    <div class="mb-3">
                        <x-forms.select label="Verifikasi Berkas" name="verifikasi"
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
                        <x-forms.select label="Verifikasi Berkas" name="verifikasi"
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



@endsection

@section('scripts')
    <script>
        createEditor("#keterangan")
        createEditor("#penolakan")

        currencyInInput("#anggaran")

        gambarHandler("dokumentasi")

        $('#verifikasi').change(function() {
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
