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
                        @if (isAVPAdm())
                            <button class="btn btn-primary text-capitalize" data-bs-toggle="modal"
                                data-bs-target="#exampleModal">
                                <x-svg.icon.addfile />
                                Tambah Pengajuan Rotasi
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
                            <th scope="col">STATUS</th>
                            @if (isAllAdmin())
                                <th class="text-center">AKSI</th>
                            @endif
                        </tr>
                    @endslot

                    @slot('slotBody')
                        @foreach ($rotasi as $item )
                            <tr>
                                <td class="w-30">

                                    {{ format_dfy($item->tanggal) }}
                                </td>
                                <td>
                                    <span class="badge text-capitalize {{ isStatusDiterima($item->status) ? 'bg-success' : (isStatusProses($item->status) ? 'bg-warning' : (isStatusDiajukan($item->status) ? 'bg-warning-subtle text-dark' : 'bg-danger')) }}">{{ $item->status }}</span>
                                </td>
                                <td>
                                    <div class="aksi">
                                        @if (isAllAdmin())
                                            @if (isAVPAdm())
                                                <a href="##edit" id="edit"
                                                    onclick="modalEditRotasi(
                                                        '{{ route('rotasi.update', ['id' => $item->id]) }}',
                                                        '{{ addslashes($item->lampiran) }}',
                                                    )"
                                                    data-bs-toggle="modal" data-bs-target="#editModal">
                                                    <x-svg.icon.edit />
                                                </a>
                                            @endif

                                            <a href="{{route('rotasi.detail', ['id' => $item->id])}}">
                                                <x-svg.icon.info />
                                            </a>
                                            {{-- @if (isAVPAdm())
                                                <x-layout.delete action="{{route('rotasi.destroy', ['id' => $item->id])}}" />
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
        <x-modals.admin action="{{route('rotasi.store')}}">
            @slot('slotHeader')
                <h5 class="modal-title" id="exampleModalLabel">Tambah Pengajuan</h5>
            @endslot

            @slot('slotBody')
                <div class="mb-3">
                    <x-forms.file name="memoteo" label="Lampiran Memo TEO" placeholder="Upload File" />
                </div>
            @endslot

            @slot('slotFooter')
                <button type="submit" class="btn btn-primary btn-tutup-modal">Simpan</button>
            @endslot
        </x-modals.admin>

        <x-modals.admin action="{{route('rotasi')}}" id="editModal" isUpdate=true>
            @slot('slotHeader')
                <h5 class="modal-title" id="editModalLabel">Edit Pengajuan</h5>
            @endslot

            @slot('slotBody')
            <div class="mb-3">
                <x-forms.file name="edtmemoteo" label="Memo TEO" placeholder="Upload File" />
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
    ['memoteo', 'edtmemoteo'].forEach(function (id) {
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
