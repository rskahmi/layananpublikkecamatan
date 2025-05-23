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
                        @if (isMasyarakat())
                            <button class="btn btn-primary text-capitalize" data-bs-toggle="modal"
                                data-bs-target="#exampleModal">
                                <x-svg.icon.addfile />
                                Tambah Pengaduan
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
                            <th scope="col" class="w-30">DESKRIPSI</th>
                            <th scope="col">BUKTI</th>
                            <th scope="col">STATUS</th>
                                <th class="text-center">AKSI</th>
                        </tr>
                    @endslot
                    @slot('slotBody')
                        @foreach ($pengaduan as $item )
                            @php
                                $bukti = isFileExists('storage/images/pengaduan/' . $item->bukti, asset('assets/img/dafault/default-bg.png'))
                            @endphp
                            <tr>
                                <td class="w-30">
                                    {{ format_dfy($item->tanggal) }}
                                </td>
                                <td class="w-30">
                                    {{ ($item->deskripsi) }}
                                </td>
                                <td>
                                    <ul>
                                        <img width="300" height="100%" src="{{ $bukti }}" alt="Gambar {{ $item->bukti }}">
                                    </ul>
                                </td>
                                <td>
                                    <span class="badge text-capitalize {{ isStatusDiterima($item->status) ? 'bg-success' : (isStatusProses($item->status) ? 'bg-warning' : (isStatusDiajukan($item->status) ? 'bg-warning-subtle text-dark' : 'bg-danger')) }}">{{ $item->status }}</span>
                                </td>
                                <td>
                                    <div class="aksi">
                                            @if (isAll())
                                                <a href="##edit" id="edit"
                                                    onclick="modalEditPengaduan(
                                                        '{{ route('pengaduan.update', ['id' => $item->id]) }}',
                                                        '{{ addslashes($item->deskripsi) }}',
                                                        '{{ asset('storage/images/pengaduan/' . $item->bukti) }}'
                                                    )"
                                                    data-bs-toggle="modal" data-bs-target="#editModal">
                                                    <x-svg.icon.edit />
                                                </a>
                                            @endif

                                            <a href="{{route('pengaduan.detail', ['id' => $item->id])}}">
                                                <x-svg.icon.info />
                                            </a>
                                            {{-- @if (isAdmin())
                                                <x-layout.delete action="{{route('spd.destroy', ['id' => $item->id])}}" />
                                            @endif --}}
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


        <!-- Modal -->
        <x-modals.admin action="{{route('pengaduan.store')}}">
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

        <x-modals.admin action="{{route('pengaduan')}}" id="editModal" isUpdate=true>
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
    <script type='text/javascript'
        src='https://www.bing.com/api/maps/mapcontrol?callback=GetMap&key={{ env('BING_API_KEY') }}' async defer></script>
    <script src="{{ asset('assets/user/js/maps.js') }}"></script>
    <script>
    ['lampiran', 'edtlampiran'].forEach(function (id) {
            gambarHandler(id);
    });
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
