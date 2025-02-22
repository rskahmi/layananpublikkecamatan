@extends('layout.user')

@section('headers')
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
@endsection

@section('title', 'Pengajuan Berkas')
@section('content')
    <x-svg.fitur.berkas />

    <div class="animate__animated animate__fadeInUp">
        <div class="card table">
            <div class="card-header">
                <div class="row align-items-center">
                    <div class="col-12 col-sm-12 col-md-5">
                        <h4>Aksi Pengajuan</h4>
                    </div>
                    <div class="col-12 col-sm-12 col-md-7 d-flex justify-content-start justify-content-md-end gap-2">
                        <x-search />
                        @if (isAdmin())
                            <button class="btn btn-primary text-capitalize" data-bs-toggle="modal"
                                data-bs-target="#exampleModal">
                                <x-svg.icon.addfile />
                                Tambah Berkas
                            </button>
                        @endif
                    </div>
                </div>
            </div>
            <div class="card-body">
                <x-table>
                    @slot('slotHeading')
                        <tr>
                            <th scope="col" class="w-30">BERKAS</th>
                            <th scope="col">JENIS</th>
                            <th scope="col">NAMA</th>
                            <th scope="col">NO HP</th>
                            <th scope="col">ANGGARAN</th>
                            <th scope="col">BATAS KONFIRMASI</th>
                            <th scope="col">STATUS</th>
                            @if (isAllAdmin())
                                <th class="text-center">AKSI</th>
                            @endif
                        </tr>
                    @endslot

                    @slot('slotBody')

                        @foreach ($berkas as $item)
                            <tr>
                                <td class="w-30">
                                    <h5>{{ $item->nama_berkas }}</h5>
                                    <span>{{ $item->nomor_berkas }}, {{ format_dfy($item->tanggal) }}</span>
                                </td>
                                <td>
                                    {{ $item->jenis }}
                                </td>
                                <td>
                                    <h6>{{ $item->nama_pengirim }}</h6>
                                    @if ($item->proposal)
                                        <span>{{ $item->proposal->lembaga->nama_lembaga }}</span>
                                    @endif
                                </td>
                                <td>
                                    <a target="_blank" href="https://wa.me/{{ checkNumber($item->contact) }}" class="text-decoration-underline">{{ checkNumber($item->contact) }}</a>
                                </td>
                                <td>
                                    {{ $item->proposal !== null ? formatRupiah($item->proposal->anggaran) : '-' }}
                                </td>
                                <td>
                                    {{ format_dfy($item->batas_konfirmasi) }}
                                </td>
                                <td>
                                    @if ($item->proposal !== null)
                                        <span
                                            class="badge text-capitalize {{ isStatusDiterima($item->proposal->status) ? 'bg-success' : (isStatusProses($item->proposal->status) ? 'bg-warning' : (isStatusDiajukan($item->proposal->status) ? 'bg-warning-subtle text-dark' : 'bg-danger')) }}">{{ $item->proposal->status }}</span>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    <div class="aksi">
                                        @if (isAllAdmin())
                                            @if (isAdmin())
                                                <a href="##edit" id="edit"
                                                    @if (!$item->proposal) onclick="modalEditBerkas('{{ route('berkas.update', ['id' => $item->id]) }}',
                                                '{{ $item->nomor_berkas }}',
                                                '{{ $item->nama_berkas }}',
                                                '{{ $item->nama_pengirim }}',
                                                '{{ $item->tanggal }}',
                                                '{{ $item->jenis }}',
                                                '{{ $item->contact }}')"
                                                @else
                                                onclick="modalEditBerkas('{{ route('berkas.update', ['id' => $item->id]) }}',
                                                '{{ $item->nomor_berkas }}',
                                                '{{ $item->nama_berkas }}',
                                                '{{ $item->nama_pengirim }}',
                                                '{{ $item->tanggal }}',
                                                '{{ $item->jenis }}',
                                                '{{ $item->contact }}',
                                                '{{ $item->proposal->lembaga->id }}',
                                                '{{ $item->proposal->wilayah->id }}',
                                                '{{ $item->proposal->jenis }}')" @endif
                                                    data-bs-toggle="modal" data-bs-target="#editModal">
                                                    <x-svg.icon.edit />
                                                </a>
                                            @endif
                                            <a href="{{ route('berkas.detail', ['id' => $item->id]) }}">
                                                <x-svg.icon.info />
                                            </a>
                                            @if (isAdmin())
                                                <x-layout.delete action="{{ route('berkas.destroy', ['id' => $item->id]) }}" />
                                            @endif
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


    @if (isAllAdmin())
        <!-- Modal -->
        <x-modals.admin action="{{ route('berkas.store') }}">
            @slot('slotHeader')
                <h5 class="modal-title" id="exampleModalLabel">Tambah Pengajuan</h5>
            @endslot

            @slot('slotBody')
                <div class="alert alert-success mt-2" style="display: none" role="alert" id="alertWilayahModal">
                </div>
                <div class="mb-3">
                    <x-forms.input label="Nomor Berkas" name="nomor_berkas" placeholder="Masukkan Nomor Berkas" />
                </div>

                <div class="mb-3">
                    <x-forms.input label="Nama Berkas" name="nama_berkas" placeholder="Masukkan Nama Berkas" />
                </div>
                <div class="mb-3">
                    <x-forms.file name="file_berkas" label="File Berkas" placeholder="Upload File" />
                </div>
                <div class="mb-3">
                    <x-forms.select label="Jenis Berkas" name="jenis" placeholder="Masukkan Jenis Berkas">
                        <option value="Surat">Surat</option>
                        <option value="Proposal">Proposal</option>
                        <option value="Undangan">Undangan</option>
                    </x-forms.select>
                </div>
                <div id="proposal-only" class="animate__animated animate__fadeInUp" style="display: none;">
                    <div class="mb-3">
                        <x-forms.select label="Jenis Program" name="jenis_kegiatan" placeholder="Masukkan Jenis Program">
                            <option value="terprogram">Tjsl Terprogram</option>
                            <option value="tidak terprogram">Tjsl Tidak Terprogram</option>
                            <option value="sponsorship">Sponsorship</option>
                        </x-forms.select>
                    </div>
                    <div class="mb-3">
                        <x-forms.select2 label="Lembaga" name="lembaga-select">
                            @foreach ($lembaga as $item)
                                <option value={{ $item->id }}>{{ $item->nama_lembaga }}</option>
                            @endforeach
                        </x-forms.select2>
                    </div>
                    <div class="mb-3">
                        <x-forms.select2 label="Wilayah" name="wilayah-select">
                            @foreach ($wilayah as $item)
                                <option value={{ $item->id }}>{{ $item->alamat }},{{ $item->kelurahan }},
                                    {{ $item->kecamatan }} </option>
                            @endforeach
                        </x-forms.select2>
                    </div>
                </div>
                <div class="mb-3">
                    <x-forms.input label="Nama Pemohon" name="nama_pemohon" placeholder="Masukkan Nama Pemohon" />
                </div>
                <div class="mb-3">
                    <x-forms.input label="No HP Pemohon" name="contact" placeholder="Masukkan No HP Pemohon" />
                </div>
                <div class="mb-3">
                    <x-forms.date label="Tanggal Pengajuan" name="tanggal" placeholder="Pilih Tanggal" />
                </div>
            @endslot

            @slot('slotFooter')
                <button type="submit" class="btn btn-primary btn-tutup-modal">Simpan</button>
            @endslot
        </x-modals.admin>

        <x-modals.admin action="{{ route('berkas') }}" id="editModal" isUpdate=true>
            @slot('slotHeader')
                <h5 class="modal-title" id="editModalLabel">Edit Pengajuan</h5>
            @endslot

            @slot('slotBody')
                <div class="alert alert-success mt-2" style="display: none" role="alert" id="alertWilayahModal">
                </div>
                <div class="mb-3">
                    <x-forms.input label="Nomor Berkas" name="edtNomorBerkas" placeholder="Masukkan Nomor Berkas" />
                </div>
                <div class="mb-3">
                    <x-forms.input label="Nama Berkas" name="edtNamaBerkas" placeholder="Masukkan Nama Berkas" />
                </div>
                <div class="mb-3">
                    <x-forms.select label="Jenis Berkas" name="edtJenis" placeholder="Masukkan Jenis Berkas">
                        <option value="Surat">Surat</option>
                        <option value="Proposal">Proposal</option>
                        <option value="Undangan">Undangan</option>
                    </x-forms.select>
                </div>
                <div id="edt-proposal-only" class="d-none">
                    <div class="mb-3">
                        <x-forms.select label="Jenis Program" name="edtJenis" placeholder="Masukkan Jenis Program">
                            <option value="terprogram">Tjsl Terprogram</option>
                            <option value="tidak terprogram">Tjsl Tidak Terprogram</option>
                            <option value="sponsorship">Sponsorship</option>
                        </x-forms.select>
                    </div>
                    <div class="mb-3" id="containerEdtLembaga">
                        <x-forms.select2 label="Lembaga" name="edt-lembaga-select">
                            @foreach ($lembaga as $item)
                                <option value={{ $item->id }}>{{ $item->nama_lembaga }}</option>
                            @endforeach
                        </x-forms.select2>
                    </div>
                    <div class="mb-3" id="containerEdtWilayah">
                        <x-forms.select2 label="Wilayah" name="edt-wilayah-select">
                            @foreach ($wilayah as $item)
                                <option value={{ $item->id }}>{{ $item->alamat }}, {{ $item->kelurahan }},
                                    {{ $item->kecamatan }} </option>
                            @endforeach
                        </x-forms.select2>
                    </div>

                </div>
                <div class="mb-3">
                    <x-forms.date label="Tanggal Pengajuan" name="edtTanggal" placeholder="Pilih Tanggal" />
                </div>

                <div class="mb-3">
                    <x-forms.input label="Nama Pemohon" name="edtNamaPemohon" placeholder="Masukkan Nama Pemohon" />
                </div>
                <div class="mb-3">
                    <x-forms.input label="No HP Pemohon" name="edtContact" placeholder="Masukkan No HP Pemohon" />
                </div>

            @endslot

            @slot('slotFooter')
                <button type="submit" class="btn btn-primary btn-tutup-modal">Simpan</button>
            @endslot
        </x-modals.admin>

        <x-layout.wilayah modal="#exampleModal" />
    @endif

@endsection
@section('scripts')
    <script type='text/javascript'
        src='https://www.bing.com/api/maps/mapcontrol?callback=GetMap&key={{ env('BING_API_KEY') }}' async defer></script>
    <script src="{{ asset('assets/user/js/maps.js') }}"></script>
    <script>
        gambarHandler('file_berkas')
        select2wilayah("wilayah-select", "exampleModal")
        select2lembaga("lembaga-select", "exampleModal")
        select2wilayah("edt-wilayah-select", "editModal")
        select2lembaga("edt-lembaga-select", "editModal")
        dataTable(7)

        // Check if users select a proposal or surat & undangan
        $('#jenis').change(function() {
            var value = $(this).val()

            if (value.toLowerCase() === "proposal") {
                $('#proposal-only').show()
            } else {
                $('#proposal-only').hide()
            }
        })

        $('#edtJenis').change(function() {
            var value = $(this).val()

            if (value.toLowerCase() === "proposal") {
                if ($("#edt-proposal-only").hasClass("d-none")) {
                    $("#edt-proposal-only").removeClass("d-none");
                }
            } else {
                if (!$("#edt-proposal-only").hasClass("d-none")) {
                    $("#edt-proposal-only").addClass("d-none");
                }
            }
        })

        document.addEventListener("DOMContentLoaded", function() {
            Echo.channel('channel-wilayah')
                .listen('WilayahEvent', (e) => {
                    var data = e.data;

                    var value = data.id
                    var text = data.alamat + ", " + data.kelurahan + ", " + data.kecamatan
                    addDataToSelect2([{
                        value: value,
                        text: text
                    }], '#wilayah-select')

                    addDataToSelect2([{
                        value: value,
                        text: text
                    }], '#edt-wilayah-select')
                });
        })
    </script>
@endsection
