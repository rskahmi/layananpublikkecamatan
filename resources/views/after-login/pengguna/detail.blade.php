@extends('layout.user')

@section('title', 'Detail Pengguna')
@section('headers')
    <script src="https://cdn.ckeditor.com/ckeditor5/41.2.0/classic/ckeditor.js"></script>
@endsection
@section('content')
    <x-svg.fitur.berkas />
    <div class="row detail-pengajuan">
        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-6 animate__animated animate__fadeInLeft">
            <div class="card standart">
                <div class="card-body">
                    <div class="row">
                        <div
                            class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-6 mt-2 mt-sm-2 mt-md-0 mt-lg-0 mt-xl-0 mt-md-3">
                            <x-text.PopUpMenu title="Nama Lengkap" subtitle="{{ $user->nama }}" />
                        </div>
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-6 mt-2 mt-sm-2 mt-xl-0 mt-md-3">
                            <x-text.PopUpMenu title="Email" subtitle="{{ $user->email }}" />
                        </div>
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-6 mt-2 mt-sm-2 mt-md-3">
                            <x-text.PopUpMenu title="Departemen" subtitle="{{ $user->departemen }}" />
                        </div>
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-6 mt-2 mt-sm-2 mt-md-3">
                            <x-text.PopUpMenu title="NIK" subtitle="{{ $user->nip }}" />
                        </div>
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-6 mt-2 mt-sm-2 mt-md-3 popup-text">
                            <h6>Status</h6>
                            <span class="badge text-capitalize
                            {{ isStatusVerify($user->status) ? 'bg-success' :
                            (isStatusNonVerify($user->status) ? 'bg-warning' :
                            (isStatusDitolak($user->status) ? 'bg-danger' : 'bg-secondary')) }}">
                            {{ $user->status }}
                        </span>                        </div>
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-6 mt-2 mt-sm-2 mt-md-3">
                            <x-text.PopUpMenu title="Role Akses" subtitle="{{ roles($user->role )}}" />
                        </div>
                    </div>
                </div>
            </div>
        </div>


        @if ($user->status === 'non-verify')
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-6 mt-3 mt-sm-3 mt-md-3 mt-xl-0 animate__animated animate__fadeInRight">
                <div class="container ms-0 ms-sm-0 ms-md-0 ms-lg-0 ms-xl-5">
                    <div class="row mb-3">
                        <div class="col-12 popup-text">
                            <h6>Verifikasi Disini</h6>
                        </div>
                        <div class="col-12 mt-2">
                            <div class="d-flex gap-3">
                                <button class="btn btn-warning text-capitalize" data-bs-toggle="modal"
                                        data-bs-target="#modalVerifikasiPengguna">
                                    Verifikasi
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif


    </div>

    @if ($user->status === 'non-verify')
    <x-modals.admin id="modalVerifikasiPengguna" action="{{ route('pengguna.verifikasi', ['id' => $user->id]) }}"
        class="modal-xl">
        @slot('slotHeader')
            <h5 class="modal-title" id="exampleModalLabel">Keterangan Review Berkas</h5>
        @endslot

        @slot('slotBody')
            <div class="mb-3">
                <x-forms.select label="Verifikasi Pengguna" name="verifikasi"
                    placeholder="Pilih verifikasi pengguna">
                    <option value="verify">Diterima</option>
                    <option value="ditolak">Ditolak</option>
                </x-forms.select>
            </div>
        @endslot

        @slot('slotFooter')
            <button type="submit" class="btn btn-primary btn-tutup-modal">Verifikasi Pengguna</button>
        @endslot
    </x-modals.admin>
@endif


@endsection

{{-- @section('scripts')
    <script>
        createEditor("#keterangan")
        createEditor("#penolakan")

        currencyInInput("#anggaran")

        gambarHandler("dokumen")

        $('#verifikasi_berkas').change(function() {
            var value = $(this).val()

            if (value.toLowerCase() === "diterima") {
                $('#onlyDiterima').show()
                $('#onlyDireview').hide()
            }else if (value.toLowerCase() === "review") {
                $('#onlyDireview').show()
                $('#onlyDiterima').hide()
            }else {
                $('#onlyDiterima').hide()
                $('#onlyDireview').hide()
            }
        })
    </script>
@endsection --}}
