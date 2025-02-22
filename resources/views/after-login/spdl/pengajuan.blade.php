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
                                Tambah Pengajuan SPDL
                            </button>
                        @endif
                    </div>
                </div>
            </div>
            <div class="card-body">
                <x-table>
                    @slot('slotHeading')
                        <tr>
                            <th scope="col" class="w-30">TANGGAL BERANGKAT & PULANG</th>

                            <th scope="col" class="w-30">TUJUAN</th>
                            <th scope="col">STATUS</th>
                            @if (isAllAdmin())
                                <th class="text-center">AKSI</th>
                            @endif
                        </tr>
                    @endslot

                    @slot('slotBody')

                        @foreach ($spdl as $item )
                            <tr>
                                <td class="w-30">
                                    {{ format_dfy($item->tanggalberangkat) }} -
                                    {{ format_dfy($item->tanggalpulang) }}
                                </td>
                                <td class="w-30">
                                    {{ ($item->tujuan) }}
                                </td>
                                <td>
                                    <span class="badge text-capitalize {{ isStatusDiterima($item->status) ? 'bg-success' : (isStatusProses($item->status) ? 'bg-warning' : (isStatusDiajukan($item->status) ? 'bg-warning-subtle text-dark' : 'bg-danger')) }}">{{ $item->status }}</span>
                                </td>
                                <td>
                                    <div class="aksi">
                                        @if (isAllAdmin())
                                            @if (isAdmin())
                                                <a href="##edit" id="edit"
                                                    onclick="modalEditSPDL(
                                                        '{{ route('spdl.update', ['id' => $item->id]) }}',
                                                        '{{($item->tanggalberangkat) }}',
                                                        '{{($item->tanggalpulang) }}',
                                                        '{{ ($item->tujuan) }}',
                                                        '{{ ($item->lampiran) }}',
                                                    )"
                                                    data-bs-toggle="modal" data-bs-target="#editModal">
                                                    <x-svg.icon.edit />
                                                </a>
                                            @endif

                                            <a href="{{route('spdl.detail', ['id' => $item->id])}}">
                                                <x-svg.icon.info />
                                            </a>
                                            {{-- @if (isAdmin())
                                                <x-layout.delete action="{{route('spdl.destroy', ['id' => $item->id])}}" />
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
        <x-modals.admin action="{{route('spdl.store')}}">
            @slot('slotHeader')
                <h5 class="modal-title" id="exampleModalLabel">Tambah Pengajuan</h5>
            @endslot

            @slot('slotBody')
                <div class="mb-3">x
                    <x-forms.date label="Tanggal Berangkat" name="tanggalberangkat" placeholder="Masukkan Tanggal Berangkat" />
                </div>
                <div class="mb-3">
                    <x-forms.date label="Tanggal Pulang" name="tanggalpulang" placeholder="Masukkan Tanggal Pulang" />
                </div>
                <div class="mb-3">
                    <x-forms.input label="Tujuan" name="tujuan" placeholder="Masukkan Tujuan" />
                </div>
                <div class="mb-3">
                    <x-forms.file name="lampiran" label="Lampiran Email dan Data Pelaku Perjalanan" placeholder="Upload File" />
                </div>
            @endslot

            @slot('slotFooter')
                <button type="submit" class="btn btn-primary btn-tutup-modal">Simpan</button>
            @endslot
        </x-modals.admin>

        <x-modals.admin action="{{ route('spdl') }}" id="editModal" isUpdate=true>
            @slot('slotHeader')
                <h5 class="modal-title" id="editModalLabel">Edit Pengajuan</h5>
            @endslot

            @slot('slotBody')
            <div class="mb-3">
                <x-forms.date label="Tanggal Berangkat" name="edttanggalberangkat" placeholder="Masukkan Tanggal Berangkat" />
            </div>
            <div class="mb-3">
                <x-forms.date label="Tanggal Pulang" name="edttanggalpulang" placeholder="Masukkan Tanggal Pulang" />
            </div>
            <div class="mb-3">
                <x-forms.input label="Tujuan" name="edttujuan" placeholder="Masukkan Tujuan" />
            </div>
            <div class="mb-3">
                <x-forms.file name="edtlampiran" label="Lampiran Email dan Data Pelaku Perjalanan" placeholder="Upload File" />
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
    ['lampiran', 'edtlampiran'].forEach(function (id) {
            gambarHandler(id);
    });
    select2wilayah("wilayah-select", "exampleModal")
        select2lembaga("lembaga-select", "exampleModal")
        select2wilayah("edt-wilayah-select", "editModal")
        select2lembaga("edt-lembaga-select", "editModal")
        dataTable(7)



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
