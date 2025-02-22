@extends('layout.user')

@section('headers')
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
@endsection

@section('title', 'Penerbitan SIMRD')
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
                        {{-- @if (isAdmin())
                            <button class="btn btn-primary text-capitalize" data-bs-toggle="modal"
                                data-bs-target="#exampleModal">
                                <x-svg.icon.addfile />
                                Tambah Pengajuan RD
                            </button>
                        @endif --}}
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
                            @if (isAllAdmin())
                                <th class="text-center">AKSI</th>
                            @endif
                        </tr>
                    @endslot

                    @slot('slotBody')

                        @foreach($penerbitan as $item)
                            <tr>
                                <td class="w-30">
                                    <h5>{{ $item->tanggal}}</h5>
                                </td>
                                <td>
                                    {{ $item->jenis }}
                                </td>
                                <td>
                                    <span class="badge text-capitalize {{ isStatusDiterima($item->status) ? 'bg-success' : (isStatusProses($item->status) ? 'bg-warning' : (isStatusDiajukan($item->status) ? 'bg-warning-subtle text-dark' : 'bg-danger')) }}">{{ $item->status }}</span>
                                </td>
                                <td>
                                    <div class="aksi">
                                        @if (isAllAdmin())
                                            @if (isAdmin())
                                                <a href="##edit" id="edit"
                                                {{-- @if ($item->baru)
                                                    onclick="modalEditRD(
                                                        '{{ route('rd.update', ['id' => $item->id]) }}',
                                                        '{{ addslashes($item->jenis) }}',
                                                        '{{ addslashes($item->suratpermohonanbaru) }}'
                                                    )"
                                                @elseif ($item->ganti)
                                                    onclick="modalEditRD(
                                                        '{{ route('rd.update', ['id' => $item->id]) }}',
                                                        '{{ addslashes($item->jenis) }}',
                                                        '{{ addslashes($item->suratpermohonanganti) }}',
                                                        '{{ addslashes($item->simrd) }}'
                                                    )"
                                                @elseif ($item->kembalikan)
                                                    onclick="modalEditRD(
                                                        '{{ route('rd.update', ['id' => $item->id]) }}',
                                                        '{{ addslashes($item->jenis) }}',
                                                        '{{ addslashes($item->suratpermohonankembalikan) }}'
                                                    )"
                                                @endif --}}

                                                    data-bs-toggle="modal" data-bs-target="#editModal">
                                                    <x-svg.icon.edit />
                                                </a>
                                            @endif

                                            <a href="{{route('penerbitan.detail', ['id' => $item->id])}}">
                                                <x-svg.icon.info />
                                            </a>
                                            {{-- @if (isAdmin())
                                                <x-layout.delete action="{{route('rd.destroy', ['id' => $item->id])}}" />
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
        <x-modals.admin action="">
            @slot('slotHeader')
                <h5 class="modal-title" id="exampleModalLabel">Tambah Pengajuan RD</h5>
            @endslot

            @slot('slotBody')

                <div class="mb-3">
                    <x-forms.select label="Jenis RD" name="jenis" placeholder="Pilih Jenis Berkas">
                        <option value="Baru">Pengajuan Baru RD</option>
                        <option value="Ganti">Penggantian RD</option>
                        <option value="Kembalikan">Pengembalian RD</option>
                    </x-forms.select>
                </div>

                <div id="baru-only" class="animate__animated animate__fadeInUp" style="display: none;">
                    <div class="mb-3">
                        <x-forms.file name="suratpermohonanbaru" label="Surat Permohonan Pengajuan RD" placeholder="Upload File" />
                    </div>
                </div>

                <div id="ganti-only" class="animate__animated animate__fadeInUp" style="display: none;">
                    <div class="mb-3">
                        <x-forms.file name="suratpermohonanganti" label="Surat Permohonan Penggantian RD" placeholder="Upload File" />
                    </div>
                    <div class="mb-3">
                        <x-forms.file name="simrd" label="SIMRD" placeholder="Upload File" />
                    </div>
                </div>

                <div id="kembalikan-only" class="animate__animated animate__fadeInUp" style="display: none;">
                    <div class="mb-3">
                        <x-forms.file name="suratpermohonankembalikan" label="Surat Permohonan Pengembalian RD" placeholder="Upload File" />
                    </div>
                </div>

            @endslot

            @slot('slotFooter')
                <button type="submit" class="btn btn-primary btn-tutup-modal">Simpan</button>
            @endslot
        </x-modals.admin>

        <x-modals.admin action="" id="editModal" isUpdate=true>
            @slot('slotHeader')
                <h5 class="modal-title" id="editModalLabel">Edit Pengajuan</h5>
            @endslot

            @slot('slotBody')
            <div class="mb-3">
                <x-forms.select label="Jenis NPP" name="edtJenis" placeholder="Pilih Jenis Berkas">
                    <option value="Baru">Pengajuan RD Baru</option>
                    <option value="Ganti">Penggantian RD</option>
                    <option value="Kembalikan">Pengembalian RD</option>
                </x-forms.select>
            </div>

            <div id="edt-baru-only" class="animate__animated animate__fadeInUp" style="display: none;">
                <div class="mb-3">
                    <x-forms.file name="edtsuratpermohonanbaru" label="Surat Permohonan Pengajuan RD" placeholder="Upload File" />
                </div>
            </div>

            <div id="edt-ganti-only" class="animate__animated animate__fadeInUp" style="display: none;">
                <div class="mb-3">
                    <x-forms.file name="edtsuratpermohonanganti" label="Surat Permohonan Penggantian RD" placeholder="Upload File" />
                </div>
                <div class="mb-3">
                    <x-forms.file name="edtsimrd" label="SIMRD" placeholder="Upload File" />
                </div>
            </div>

            <div id="edt-kembalikan-only" class="animate__animated animate__fadeInUp" style="display: none;">
                <div class="mb-3">
                    <x-forms.file name="edtsuratpermohonankembalikan" label="Surat Permohonan Pengembalian RD" placeholder="Upload File" />
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
    ['suratpermohonanbaru', 'suratpermohonanganti', 'simrd', 'suratpermohonankembalikan', 'edtsuratpermohonanbaru', 'edtsuratpermohonanganti', 'edtsimrd', 'edtsuratpermohonankembalikan'].forEach(function (id) {
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

            if (value.toLowerCase() === "baru") {
                $('#baru-only').show()
            } else if (value.toLowerCase() === "ganti") {
                $('#ganti-only').show()
            }
            else if (value.toLowerCase() === "kembalikan") {
                $('#kembalikan-only').show()
            }
            else {
                $('#baru-only').hide()
                $('#ganti-only').hide()
                $('#kembalikan-only').hide()
            }
        })

        $('#edtJenis').change(function() {
            var value = $(this).val()

            if (value.toLowerCase() === "baru") {
                $('#edt-baru-only').show()
            } else if (value.toLowerCase() === "ganti") {
                $('#edt-ganti-only').show()
            }
            else if (value.toLowerCase() === "kembalikan") {
                $('#edt-kembalikan-only').show()
            }
            else {
                $('#edt-baru-only').hide()
                $('#edt-ganti-only').hide()
                $('#edt-kembalikan-only').hide()
            }
        }
    )


    </script>
@endsection
