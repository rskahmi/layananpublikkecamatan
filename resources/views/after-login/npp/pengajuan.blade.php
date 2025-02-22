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
                                Tambah Pengajuan NPP
                            </button>
                        @endif
                    </div>
                </div>
            </div>
            <div class="card-body">
                <x-table>
                    @slot('slotHeading')
                        <tr>
                            <th scope="col" class="w-30">TANGGAL</th>
                            <th scope="col">JENIS</th>
                            <th scope="col">STATUS</th>
                            {{-- <th scope="col">STATUS VERIFIKASI</th> --}}
                            @if (isAllAdmin())
                                <th class="text-center">AKSI</th>
                            @endif
                        </tr>
                    @endslot

                    @slot('slotBody')

                        @foreach ($npp as $item)
                            <tr>
                                <td class="w-30">
                                    <h5>{{ $item->tanggal }}</h5>
                                    {{-- <span>{{ $item->nomor_berkas }}, {{ format_dfy($item->tanggal) }}</span> --}}
                                </td>
                                <td>
                                    {{ $item->jenis }}
                                </td>

                                <td>
                                    @if ($item->reim !== null)
                                        <span class="badge text-capitalize {{ isStatusDiterima($item->reim->status) ? 'bg-success' : (isStatusProses($item->reim->status) ? 'bg-warning' : (isStatusDiajukan($item->reim->status) ? 'bg-warning-subtle text-dark' : 'bg-danger')) }}">{{ $item->reim->status }}</span>
                                    @elseif ($item->umd !== null)
                                        <span class="badge text-capitalize {{ isStatusDiterima($item->umd->status) ? 'bg-success' : (isStatusProses($item->umd->status) ? 'bg-warning' : (isStatusDiajukan($item->umd->status) ? 'bg-warning-subtle text-dark' : 'bg-danger')) }}">{{ $item->umd->status }}</span>
                                    @else
                                        -
                                    @endif
                                </td>
                                {{-- <td>

                                </td> --}}
                                <td>
                                    <div class="aksi">
                                        @if (isAllAdmin())
                                            @if (isAdmin())
                                                <a href="##edit" id="edit"
                                                @if ($item->umd)
                                                    onclick="modalEditNPP(
                                                        '{{ route('npp.update', ['id' => $item->id]) }}',
                                                        '{{ addslashes($item->jenis) }}',
                                                        '{{ addslashes($item->berkasrab) }}'
                                                    )"
                                                @elseif ($item->reim)
                                                    onclick="modalEditNPP(
                                                        '{{ route('npp.update', ['id' => $item->id]) }}',
                                                        '{{ addslashes($item->jenis) }}',
                                                        '{{ addslashes($item->berkasnpp) }}',
                                                        '{{ addslashes($item->nota) }}',
                                                        '{{ addslashes($item->kwitansi) }}',
                                                        '{{ addslashes($item->dokumenpersetujuan) }}'
                                                    )"
                                                @endif

                                                    data-bs-toggle="modal" data-bs-target="#editModal">
                                                    <x-svg.icon.edit />
                                                </a>
                                            @endif

                                            <a href="{{route('npp.detail', ['id' => $item->id])}}">
                                                <x-svg.icon.info />
                                            </a>
                                            {{-- @if (isAdmin())
                                                <x-layout.delete action="{{route('npp.destroy', ['id' => $item->id])}}" />
                                            @endif --}}
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
        <x-modals.admin action="{{route('npp.store')}}">
            @slot('slotHeader')
                <h5 class="modal-title" id="exampleModalLabel">Tambah Pengajuan NPP</h5>
            @endslot

            @slot('slotBody')

                <div class="mb-3">
                    <x-forms.select label="Jenis NPP" name="jenis" placeholder="Pilih Jenis Berkas">
                        <option value="UMD">UMD</option>
                        <option value="Reim">Reimburstment</option>
                    </x-forms.select>
                </div>

                <div id="umd-only" class="animate__animated animate__fadeInUp" style="display: none;">
                    <div class="mb-3">
                        <x-forms.file name="berkasrab" label="Berkas RAB" placeholder="Upload File" />
                    </div>
                </div>

                <div id="reim-only" class="animate__animated animate__fadeInUp" style="display: none;">
                    <div class="mb-3">
                        <x-forms.file name="berkasnpp" label="Berkas NPP" placeholder="Upload File" />
                    </div>
                    <div class="mb-3">
                        <x-forms.file name="nota" label="Nota" placeholder="Upload File" />
                    </div>
                    <div class="mb-3">
                        <x-forms.file name="kwitansi" label="Kwitansi" placeholder="Upload File" />
                    </div>
                    <div class="mb-3">
                        <x-forms.file name="dokumenpersetujuan" label="Dokumen Persetujuan" placeholder="Upload File" />
                    </div>
                </div>

            @endslot

            @slot('slotFooter')
                <button type="submit" class="btn btn-primary btn-tutup-modal">Simpan</button>
            @endslot
        </x-modals.admin>

        <x-modals.admin action="{{route('npp')}}" id="editModal" isUpdate=true>
            @slot('slotHeader')
                <h5 class="modal-title" id="editModalLabel">Edit Pengajuan</h5>
            @endslot

            @slot('slotBody')
            <div class="mb-3">
                <x-forms.select label="Jenis NPP" name="edtJenis" placeholder="Pilih Jenis Berkas">
                    <option value="UMD">UMD</option>
                    <option value="Reim">Reimburstment</option>
                </x-forms.select>
            </div>

            <div id="edt-umd-only" class="animate__animated animate__fadeInUp" style="display: none;">
                <div class="mb-3">
                    <x-forms.file name="edtberkasrab" label="Berkas RAB" placeholder="Upload File" />
                </div>
            </div>

            <div id="edt-reim-only" class="animate__animated animate__fadeInUp" style="display: none;">
                <div class="mb-3">
                    <x-forms.file name="edtberkasnpp" label="Berkas NPP" placeholder="Upload File" />
                </div>
                <div class="mb-3">
                    <x-forms.file name="edtnota" label="Nota" placeholder="Upload File" />
                </div>
                <div class="mb-3">
                    <x-forms.file name="edtkwitansi" label="Kwitansi" placeholder="Upload File" />
                </div>
                <div class="mb-3">
                    <x-forms.file name="edtdokumenpersetujuan" label="Dokumen Persetujuan" placeholder="Upload File" />
                </div>
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
    ['berkasrab', 'berkasnpp', 'nota', 'kwitansi', 'dokumenpersetujuan', 'edtberkasrab','edtberkasnpp','edtnota','edtkwitansi','edtdokumenpersetujuan'].forEach(function (id) {
            gambarHandler(id);
    });
    select2wilayah("wilayah-select", "exampleModal")
        select2lembaga("lembaga-select", "exampleModal")
        select2wilayah("edt-wilayah-select", "editModal")
        select2lembaga("edt-lembaga-select", "editModal")
        dataTable(7)

        // Check if users select a proposal or surat & undangan
        $('#jenis').change(function() {
            var value = $(this).val()

            if (value.toLowerCase() === "umd") {
                $('#umd-only').show()
            } else if (value.toLowerCase() === "reim") {
                $('#reim-only').show()
            }
            else {
                $('#umd-only').hide()
                $('#reim-only').hide()
            }
        })

        $('#edtJenis').change(function() {
            var value = $(this).val()

            if (value.toLowerCase() === "umd") {
                $('#edt-umd-only').show()
            } else if (value.toLowerCase() === "reim") {
                $('#edt-reim-only').show()
            }
            else {
                $('#edt-umd-only').hide()
                $('#edt-reim-only').hide()
            }
        }
    )


    </script>
@endsection
