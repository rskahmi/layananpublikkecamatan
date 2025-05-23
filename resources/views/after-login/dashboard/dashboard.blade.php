@extends('layout.user')

@section('headers')
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
@endsection

@section('title', 'Dashboard Masyarakat')
@section('content')
<x-svg.fitur.tjsl />
<div class="row">
    <div class="col-12 col-sm-6 col-md-4 col-lg-3 col-xxl-2 mb-2 mb-lg-0">
        <x-card.summary header="Jumlah Pengajuan Surat" value="{{formatRibuan($total_surat)}}"
            footer="Total di Tahun Ini" id="allUsers">
            <x-svg.icon.users />
        </x-card.summary>
    </div>
    <div class="col-12 col-sm-6 col-md-4 col-lg-3 col-xxl-2 mb-2 mb-lg-0">
        <x-card.summary header="Jumlah Pengaduan" color="red" value="{{formatRibuan($total_pengaduan)}}"
            footer="Total di Tahun Ini" id="akunManager">
            <x-svg.icon.manager />
        </x-card.summary>
    </div>
</div>


<div class="animate__animated animate__fadeInUp">
    <div class="card table mt-2 mt-lg-3">
        <div class="card-header">
            <div class="row align-items-center">
                <div class="col-6">
                    <h4>List Pengajuan Surat</h4>
                </div>
                <div class="col-6 d-flex justify-content-end gap-2">
                    <x-search />
                    <button class="btn btn-primary text-capitalize" data-bs-toggle="modal"
                        data-bs-target="#modalTambahSurat">
                        <x-svg.icon.addfile />
                        Tambah
                    </button>
                </div>
            </div>
        </div>
        <div class="card-body">
            <x-table>
                @slot('slotHeading')
                <tr>
                    <th scope="col">TANGGAL</th>
                    <th scope="col">JENIS</th>
                    <th scope="col">STATUS</th>
                    <th scope="col" class="text-center">ACTION</th>
                </tr>
                @endslot

                @slot('slotBody')
                @foreach ($surat as $item )
                <tr>
                    <td>{{ $item->tanggal }}</td>
                    <td>
                        {{ $item->jenis }}
                    </td>
                    <td>
                        @if ($item->bbm !== null)
                        <span
                            class="badge text-capitalize {{ isStatusDiterima($item->bbm->status) ? 'bg-success' : (isStatusProses($item->bbm->status) ? 'bg-warning' : (isStatusDiajukan($item->bbm->status) ? 'bg-warning-subtle text-dark' : 'bg-danger')) }}">{{ $item->bbm->status }}</span>
                        @elseif ($item->ktp !== null)
                        <span
                            class="badge text-capitalize {{ isStatusDiterima($item->ktp->status) ? 'bg-success' : (isStatusProses($item->ktp->status) ? 'bg-warning' : (isStatusDiajukan($item->ktp->status) ? 'bg-warning-subtle text-dark' : 'bg-danger')) }}">{{ $item->ktp->status }}</span>
                        @elseif ($item->kk !== null)
                        <span
                            class="badge text-capitalize {{ isStatusDiterima($item->kk->status) ? 'bg-success' : (isStatusProses($item->kk->status) ? 'bg-warning' : (isStatusDiajukan($item->kk->status) ? 'bg-warning-subtle text-dark' : 'bg-danger')) }}">{{ $item->kk->status }}</span>
                        @elseif ($item->sktm !== null)
                        <span
                            class="badge text-capitalize {{ isStatusDiterima($item->sktm->status) ? 'bg-success' : (isStatusProses($item->sktm->status) ? 'bg-warning' : (isStatusDiajukan($item->sktm->status) ? 'bg-warning-subtle text-dark' : 'bg-danger')) }}">{{ $item->sktm->status }}</span>
                        @else
                        -
                        @endif

        </div>
        </td>

        <td>

            <div class="aksi">
                @if (isMasyarakat())
                <a href="##edit" id="edit" @if ($item->bbm)
                    onclick="modalEditSurat(
                    '{{ route('surat.update', ['id' => $item->id]) }}',
                    '{{ addslashes($item->jenis) }}',
                    '{{ addslashes($item->ktp_bbm) }}',
                    '{{ addslashes($item->nimb_bbm) }}'
                    )"
                    @elseif ($item->ktp)
                    onclick="modalEditSurat(
                    '{{ route('surat.update', ['id' => $item->id]) }}',
                    '{{ addslashes($item->jenis) }}',
                    '{{ addslashes($item->kk_ktp) }}',
                    '{{ addslashes($item->suratkelurahan_ktp) }}',
                    )"
                    @elseif ($item->kk)
                    onclick="modalEditSurat(
                    '{{ route('surat.update', ['id' => $item->id]) }}',
                    '{{ addslashes($item->jenis) }}',
                    '{{ addslashes($item->ktp_kk) }}',
                    '{{ addslashes($item->suratkelurahan_kk) }}',
                    )"
                    @elseif ($item->sktm)
                    onclick="modalEditSurat(
                    '{{ route('surat.update', ['id' => $item->id]) }}',
                    '{{ addslashes($item->jenis) }}',
                    '{{ addslashes($item->ktm_sktm) }}',
                    '{{ addslashes($item->suratkelurahan_sktm) }}',
                    )"
                    @endif
                    data-bs-toggle="modal" data-bs-target="#editSurat">
                    <x-svg.icon.edit />
                </a>

                <a href="{{route('surat.detail', ['id' => $item->id])}}">
                    <x-svg.icon.info />
                </a>
                @endif
            </div>


        </td>


        </tr>
        @endforeach
        @endslot
        </x-table>
    </div>
</div>

<x-pagination />
</div>



<br>





<div class="animate__animated animate__fadeInUp">
    <div class="card table mt-2 mt-lg-3">
        <div class="card-header">
            <div class="row align-items-center">
                <div class="col-6">
                    <h4>List Pengaduan</h4>
                </div>
                <div class="col-6 d-flex justify-content-end gap-2">
                    <x-search />
                    <button class="btn btn-primary text-capitalize" data-bs-toggle="modal"
                        data-bs-target="#modalTambahPengaduan">
                        <x-svg.icon.addfile />
                        Tambah
                    </button>
                </div>
            </div>
        </div>
        <div class="card-body">
            <x-table>
                @slot('slotHeading')
                <tr>
                    <th scope="col">TANGGAL</th>
                    <th scope="col">STATUS</th>
                    <th scope="col" class="w-30">DESKRIPSI</th>
                    <th scope="col" class="text-center">ACTION</th>
                </tr>
                @endslot

                @slot('slotBody')
                @foreach ($pengaduan as $item2)
                <tr>
                    <td>{{ $item2->tanggal }}</td>
                    <td>
                        <span
                            class="badge text-capitalize {{ isStatusDiterima($item2->status) ? 'bg-success' : (isStatusProses($item2->status) ? 'bg-warning' : (isStatusDiajukan($item2->status) ? 'bg-warning-subtle text-dark' : 'bg-danger')) }}">{{ $item2->status }}</span>
                    </td>
                    <td>
                        {{ ($item2->deskripsi) }}
                    </td>

                    <td>

                        <div class="aksi">
                            @if (isMasyarakat())
                            <a href="##edit" id="edit" onclick="modalEditPengaduan(
                                                        '{{ route('pengaduan.update', ['id' => $item->id]) }}',
                                                        '{{ addslashes($item->deskripsi) }}',
                                                        '{{ asset('storage/images/pengaduan/' . $item->bukti) }}'
                                                    )" data-bs-toggle="modal" data-bs-target="#editPengaduan">
                                <x-svg.icon.edit />
                            </a>
                            @endif

                            <a href="{{route('pengaduan.detail', ['id' => $item2->id])}}">
                                <x-svg.icon.info />
                            </a>
                        </div>


                    </td>


                </tr>
                @endforeach
                @endslot
            </x-table>
        </div>
    </div>

    <x-pagination />
</div>


<x-modals.admin action="{{ route('surat.store') }}" id="modalTambahSurat">

    @slot('slotHeader')
    <h5 class="modal-title" id="exampleModalLabel">Tambah Pengajuan</h5>
    @endslot

    @slot('slotBody')
    <div class="mb-3">
        <x-forms.select label="Jenis Surat" name="jenis" placeholder="Pilih Jenis Berkas">
            <option value="BBM">Surat Rekomendasi Pembelian Jenis BBM</option>
            <option value="KTP">Surat Pengantar Pembuatan KTP</option>
            <option value="KK">Surat Pengantar Pembuatan KK</option>
            <option value="SKTM">SKTM</option>
        </x-forms.select>
    </div>

    <div id="bbm-only" class="animate__animated animate__fadeInUp" style="display: none;">
        <div class="mb-3">
            <x-forms.file name="ktp_bbm" label="KTP" placeholder="Upload File" />
        </div>
        <div class="mb-3">
            <x-forms.file name="nimb_bbm" label="NIMB" placeholder="Upload File" />
        </div>
    </div>

    <div id="ktp-only" class="animate__animated animate__fadeInUp" style="display: none;">
        <div class="mb-3">
            <x-forms.file name="kk_ktp" label="KK" placeholder="Upload File" />
        </div>
        <div class="mb-3">
            <x-forms.file name="suratkelurahan_ktp" label="Surat Kelurahan" placeholder="Upload File" />
        </div>
    </div>

    <div id="kk-only" class="animate__animated animate__fadeInUp" style="display: none;">
        <div class="mb-3">
            <x-forms.file name="ktp_kk" label="KTP" placeholder="Upload File" />
        </div>
        <div class="mb-3">
            <x-forms.file name="suratkelurahan_kk" label="Surat Kelurahan" placeholder="Upload File" />
        </div>
    </div>

    <div id="sktm-only" class="animate__animated animate__fadeInUp" style="display: none;">
        <div class="mb-3">
            <x-forms.file name="ktm_sktm" label="KTM/Kartu Pelajar" placeholder="Upload File" />
        </div>
        <div class="mb-3">
            <x-forms.file name="suratkelurahan_sktm" label="Surat Kelurahan" placeholder="Upload File" />
        </div>
    </div>
    @endslot

    @slot('slotFooter')
    <button type="submit" class="btn btn-primary btn-tutup-modal">Simpan</button>
    @endslot
</x-modals.admin>

<x-modals.admin action="{{route('surat')}}" id="editSurat" isUpdate=true>
    @slot('slotHeader')
    <h5 class="modal-title" id="editModalLabel">Edit Pengajuan</h5>
    @endslot
    @slot('slotBody')
    <div class="mb-3">
        <x-forms.select label="Jenis Surat" name="edtJenis" placeholder="Pilih Jenis Berkas">
            <option value="BBM">Surat Rekomendasi Pembelian Jenis BBM</option>
            <option value="KTP">Surat Pengantar Pembuatan KTP</option>
            <option value="KK">Surat Pengantar Pembuatan KK</option>
            <option value="SKTM">SKTM</option>
        </x-forms.select>
    </div>
    <div id="edt-bbm-only" class="animate__animated animate__fadeInUp" style="display: none;">
        <div class="mb-3">
            <x-forms.file name="edtktp_bbm" label="KTP" placeholder="Upload File" />
        </div>
        <div class="mb-3">
            <x-forms.file name="edtnimb_bbm" label="NIMB" placeholder="Upload File" />
        </div>
    </div>
    <div id="edt-ktp-only" class="animate__animated animate__fadeInUp" style="display: none;">
        <div class="mb-3">
            <x-forms.file name="edtkk_ktp" label="KK" placeholder="Upload File" />
        </div>
        <div class="mb-3">
            <x-forms.file name="edtsuratkelurahan_ktp" label="Surat Kelurahan" placeholder="Upload File" />
        </div>
    </div>
    <div id="edt-kk-only" class="animate__animated animate__fadeInUp" style="display: none;">
        <div class="mb-3">
            <x-forms.file name="edtktp_kk" label="KTP" placeholder="Upload File" />
        </div>
        <div class="mb-3">
            <x-forms.file name="edtsuratkelurahan_kk" label="Surat Kelurahan" placeholder="Upload File" />
        </div>
    </div>
    <div id="edt-sktm-only" class="animate__animated animate__fadeInUp" style="display: none;">
        <div class="mb-3">
            <x-forms.file name="edtktm_sktm" label="KTM" placeholder="Upload File" />
        </div>
        <div class="mb-3">
            <x-forms.file name="edtsuratkelurahan_sktm" label="Surat Kelurahan" placeholder="Upload File" />
        </div>
    </div>

    @endslot
    @slot('slotFooter')
    <button type="submit" class="btn btn-primary btn-tutup-modal">Simpan</button>
    @endslot
</x-modals.admin>



<x-modals.admin action="{{ route('pengaduan.store') }}" id="modalTambahPengaduan">
    @slot('slotHeader')
    <h5 class="modal-title" id="exampleModalLabel">Tambah Pengaduan</h5>
    @endslot

    @slot('slotBody')
    <div class="mb-3">
        <x-forms.input label="Deskripsi" name="deskripsi" placeholder="Masukkan Deskripsi" />
    </div>
    <div class="mb-3">
        <x-forms.file name="bukti" label="Lampiran Bukti" placeholder="Upload File" />
    </div>
    @endslot

    @slot('slotFooter')
    <button type="submit" class="btn btn-primary btn-tutup-modal">Simpan</button>
    @endslot
</x-modals.admin>

<x-modals.admin action="{{route('pengaduan')}}" id="editPengaduan" isUpdate=true>
    @slot('slotHeader')
    <h5 class="modal-title" id="editModalLabel">Edit Pengajuan</h5>
    @endslot

    @slot('slotBody')
    <div class="mb-3">
        <x-forms.input label="Deskripsi" name="edtdeskripsi" placeholder="Masukkan Deskripsi" />
    </div>
    <div class="mb-3">
        <label for="buktiLama">Bukti Lama</label>
        <img src="" alt="Gambar lama" width="100%" height="129" id="buktiLama">
    </div>
    <div class="mb-3">
        <x-forms.file name="edtbukti" label="Lampiran Bukti" placeholder="Upload File" />
    </div>

    @endslot

    @slot('slotFooter')
    <button type="submit" class="btn btn-primary btn-tutup-modal">Simpan</button>
    @endslot
</x-modals.admin>

@endsection

@section('scripts')
{{-- <script>
        dataTable(8)

        document.addEventListener('DOMContentLoaded', function() {
            Echo.channel('test-user-channel')
            .listen('TestUser', (e) => {
                var user = e.data

                dataTables['dataTable'].row.add([
                        user.nama, user.email, user.nip, user.role
                ]).draw(false)

                if (user.role === "am" || user.role === "gm" ){
                    setSummary("#akunManager")
                } else if (user.role === "admin-csr" || user.role === "admin-comrel" ){
                    setSummary("#akunAdmin")
                }

                setSummary("#allUsers")
            });
        });

    </script> --}}
<script>
    ['ktp_bbm', 'nimb_bbm', 'nota', 'edtktp_bbm', 'edtnimb_bbm', 'kk_ktp', 'suratkelurahan_ktp', 'edtkk_ktp',
        'edtsuratkelurahan_ktp', 'ktp_kk', 'suratkelurahan_kk', 'edtktp_kk', 'edtsuratkelurahan_kk', 'ktm_sktm',
        'suratkelurahan_sktm', 'edtktm_sktm', 'edtsuratkelurahan_sktm', 'lampiran', 'edtlampiran'
    ].forEach(function (id) {
        gambarHandler(id);
    });
    dataTable(7)

    // Check if users select a proposal or surat & undangan
    $('#jenis').change(function () {
        var value = $(this).val()
        if (value.toLowerCase() === "bbm") {
            $('#bbm-only').show()
        } else if (value.toLowerCase() === "ktp") {
            $('#ktp-only').show()
        } else if (value.toLowerCase() === "kk") {
            $('#kk-only').show()
        } else if (value.toLowerCase() === "sktm") {
            $('#sktm-only').show()
        } else {
            $('#bbm-only').hide()
            $('#ktp-only').hide()
            $('#kk-only').hide()
            $('#sktm-only').hide()
        }
    })

    $('#edtJenis').change(function () {
            var value = $(this).val()
            if (value.toLowerCase() === "bbm") {
                $('#edt-bbm-only').show()
            } else if (value.toLowerCase() === "ktp") {
                $('#edt-ktp-only').show()
            } else if (value.toLowerCase() === "kk") {
                $('#edt-kk-only').show()
            } else if (value.toLowerCase() === "sktm") {
                $('#edt-sktm-only').show()
            } else {
                $('#edt-umd-only').hide()
                $('#edt-reim-only').hide()
            }
        }



    )

</script>
@endsection
