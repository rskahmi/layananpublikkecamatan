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
                                Tambah Pengajuan SIJ
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
                            @if (isAllAdmin())
                                <th class="text-center">AKSI</th>
                            @endif
                        </tr>
                    @endslot

                    @slot('slotBody')
                        @foreach ($sij as $item )
                            <tr>
                                <td class="w-30">
                                    {{ $item->tanggal}}
                                </td>
                                <td>
                                    {{ $item->jenis }}
                                </td>
                                <td>
                                    @if ($item->melayat !== null)
                                        <span class="badge text-capitalize {{ isStatusDiterima($item->melayat->status) ? 'bg-success' : (isStatusProses($item->melayat->status) ? 'bg-warning' : (isStatusDiajukan($item->melayat->status) ? 'bg-warning-subtle text-dark' : 'bg-danger')) }}">{{ $item->melayat->status }}</span>
                                    @elseif ($item->sakit !== null)
                                        <span class="badge text-capitalize {{ isStatusDiterima($item->sakit->status) ? 'bg-success' : (isStatusProses($item->sakit->status) ? 'bg-warning' : (isStatusDiajukan($item->sakit->status) ? 'bg-warning-subtle text-dark' : 'bg-danger')) }}">{{ $item->sakit->status }}</span>
                                    @elseif ($item->dinas !== null)
                                        <span class="badge text-capitalize {{ isStatusDiterima($item->dinas->status) ? 'bg-success' : (isStatusProses($item->dinas->status) ? 'bg-warning' : (isStatusDiajukan($item->dinas->status) ? 'bg-warning-subtle text-dark' : 'bg-danger')) }}">{{ $item->dinas->status }}</span>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    <div class="aksi">
                                        @if (isAllAdmin())
                                            @if (isAdmin())
                                                <a href="##edit" id="edit"
                                                @if ($item->melayat)
                                                    onclick="modalEditSIJ(
                                                        '{{ route('sij.update', ['id' => $item->id]) }}',
                                                        '{{ addslashes($item->jenis) }}',
                                                        '{{ addslashes($item->emailberitaduka) }}'
                                                    )"
                                                @elseif ($item->sakit)
                                                    onclick="modalEditSIJ(
                                                        '{{ route('sij.update', ['id' => $item->id]) }}',
                                                        '{{ addslashes($item->jenis) }}',
                                                        '{{ addslashes($item->suratrujukan) }}',
                                                        '{{ addslashes($item->suratpengantar) }}'
                                                    )"
                                                @elseif ($item->dinas)
                                                    onclick="modalEditSIJ(
                                                        '{{ route('sij.update', ['id' => $item->id]) }}',
                                                        '{{ addslashes($item->jenis) }}',
                                                        '{{ addslashes($item->lampiran) }}'
                                                    )"
                                                @endif

                                                    data-bs-toggle="modal" data-bs-target="#editModal">
                                                    <x-svg.icon.edit />
                                                </a>
                                            @endif

                                            <a href="{{route('sij.detail', ['id'=>$item->id])}}">
                                                <x-svg.icon.info />
                                            </a>
                                            {{-- @if (isAdmin())
                                                <x-layout.delete action="{{route('sij.destroy', ['id'=>$item->id])}}" />
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
        <x-modals.admin action="{{route('sij.store')}}">
            @slot('slotHeader')
                <h5 class="modal-title" id="exampleModalLabel">Tambah Pengajuan SIJ</h5>
            @endslot

            @slot('slotBody')

                <div class="mb-3">
                    <x-forms.select label="Jenis RD" name="jenis" placeholder="Pilih Jenis Berkas">
                        <option value="Melayat">Melayat</option>
                        <option value="Sakit">Sakit</option>
                        <option value="Dinas">Dinas</option>
                    </x-forms.select>
                </div>

                <div id="melayat-only" class="animate__animated animate__fadeInUp" style="display: none;">
                    <div class="mb-3">
                        <x-forms.file name="emailberitaduka" label="Email Berita Duka" placeholder="Upload File" />
                    </div>
                </div>

                <div id="sakit-only" class="animate__animated animate__fadeInUp" style="display: none;">
                    <div class="mb-3">
                        <x-forms.file name="suratrujukan" label="Surat Rujukan Dokter" placeholder="Upload File" />
                    </div>
                    <div class="mb-3">
                        <x-forms.file name="suratpengantar" label="Surat Pengantar dari Divisi HC" placeholder="Upload File" />
                    </div>
                </div>

                <div id="dinas-only" class="animate__animated animate__fadeInUp" style="display: none;">
                    <div class="mb-3">
                        <x-forms.file name="lampiran" label="Lampiran Email dan Data Pelaku Perjalanan" placeholder="Upload File" />
                    </div>
                </div>

            @endslot

            @slot('slotFooter')
                <button type="submit" class="btn btn-primary btn-tutup-modal">Simpan</button>
            @endslot
        </x-modals.admin>

        <x-modals.admin action="{{route('sij')}}" id="editModal" isUpdate=true>
            @slot('slotHeader')
                <h5 class="modal-title" id="editModalLabel">Edit Pengajuan</h5>
            @endslot

            @slot('slotBody')
            <div class="mb-3">
                <x-forms.select label="Jenis RD" name="edtJenis" placeholder="Pilih Jenis Berkas">
                    <option value="Melayat">Melayat</option>
                    <option value="Sakit">Sakit</option>
                    <option value="Dinas">Dinas</option>
                </x-forms.select>
            </div>

            <div id="edt-melayat-only" class="animate__animated animate__fadeInUp" style="display: none;">
                <div class="mb-3">
                    <x-forms.file name="edtemailberitaduka" label="Email Berita Duka" placeholder="Upload File" />
                </div>
            </div>

            <div id="edt-sakit-only" class="animate__animated animate__fadeInUp" style="display: none;">
                <div class="mb-3">
                    <x-forms.file name="edtsuratrujukan" label="Surat Rujukan Dokter" placeholder="Upload File" />
                </div>
                <div class="mb-3">
                    <x-forms.file name="edtsuratpengantar" label="Surat Pengantar dari Divisi HC" placeholder="Upload File" />
                </div>
            </div>

            <div id="edt-dinas-only" class="animate__animated animate__fadeInUp" style="display: none;">
                <div class="mb-3">
                    <x-forms.file name="edtlampiran" label="Lampiran Email dan Data Pelaku Perjalanan" placeholder="Upload File" />
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
    ['suratrujukan', 'suratpengantar', 'lampiran', 'emailberitaduka', 'edtsuratrujukan', 'edtsuratpengantar', 'edtlampiran', 'edtemailberitaduka'].forEach(function (id) {
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

            if (value.toLowerCase() === "melayat") {
                $('#melayat-only').show()
            } else if (value.toLowerCase() === "sakit") {
                $('#sakit-only').show()
            }
            else if (value.toLowerCase() === "dinas") {
                $('#dinas-only').show()
            }
            else {
                $('#melayat-only').hide()
                $('#sakit-only').hide()
                $('#dinas-only').hide()
            }
        })

        $('#edtJenis').change(function() {
            var value = $(this).val()

            if (value.toLowerCase() === "melayat") {
                $('#edt-melayat-only').show()
            } else if (value.toLowerCase() === "sakit") {
                $('#edt-sakit-only').show()
            }
            else if (value.toLowerCase() === "dinas") {
                $('#edt-dinas-only').show()
            }
            else {
                $('#edt-melayat-only').hide()
                $('#edt-sakit-only').hide()
                $('#edt-dinas-only').hide()
            }
        }
    )


    </script>
@endsection
