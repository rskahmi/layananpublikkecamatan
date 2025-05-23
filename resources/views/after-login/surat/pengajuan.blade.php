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
                                Tambah Pengajuan Surat
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
                                <th class="text-center">AKSI</th>
                        </tr>
                    @endslot

                    @slot('slotBody')

                        @foreach ($surat as $item)
                            <tr>
                                <td class="w-30">
                                    <h5>{{ $item->tanggal }}</h5>
                                </td>
                                <td>
                                    {{ $item->jenis }}
                                </td>
                                <td>
                                    @if ($item->bbm !== null)
                                        <span class="badge text-capitalize {{ isStatusDiterima($item->bbm->status) ? 'bg-success' : (isStatusProses($item->bbm->status) ? 'bg-warning' : (isStatusDiajukan($item->bbm->status) ? 'bg-warning-subtle text-dark' : 'bg-danger')) }}">{{ $item->bbm->status }}</span>
                                    @elseif ($item->ktp !== null)
                                        <span class="badge text-capitalize {{ isStatusDiterima($item->ktp->status) ? 'bg-success' : (isStatusProses($item->ktp->status) ? 'bg-warning' : (isStatusDiajukan($item->ktp->status) ? 'bg-warning-subtle text-dark' : 'bg-danger')) }}">{{ $item->ktp->status }}</span>
                                    @elseif ($item->kk !== null)
                                        <span class="badge text-capitalize {{ isStatusDiterima($item->kk->status) ? 'bg-success' : (isStatusProses($item->kk->status) ? 'bg-warning' : (isStatusDiajukan($item->kk->status) ? 'bg-warning-subtle text-dark' : 'bg-danger')) }}">{{ $item->kk->status }}</span>
                                    @elseif ($item->sktm !== null)
                                        <span class="badge text-capitalize {{ isStatusDiterima($item->sktm->status) ? 'bg-success' : (isStatusProses($item->sktm->status) ? 'bg-warning' : (isStatusDiajukan($item->sktm->status) ? 'bg-warning-subtle text-dark' : 'bg-danger')) }}">{{ $item->sktm->status }}</span>

                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    <div class="aksi">
                                            @if (isAll())
                                                <a href="##edit" id="edit"
                                                @if ($item->bbm)
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

                                                    data-bs-toggle="modal" data-bs-target="#editModal">
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


        <!-- Modal -->
        <x-modals.admin action="{{route('surat.store')}}">
            @slot('slotHeader')
                <h5 class="modal-title" id="exampleModalLabel">Tambah Pengajuan</h5>
            @endslot
            @slot('slotBody')
                {{-- <div class="mb-3">
                    <x-forms.select label="Jenis Surat" name="jenis" placeholder="Pilih Jenis Berkas">
                        <option value="BBM">Surat Rekomendasi Pembelian Jenis BBM</option>
                        <option value="KTP">Surat Pengantar Pembuatan KTP</option>
                        <option value="KK">Surat Pengantar Pembuatan KK</option>
                        <option value="SKTM">SKTM</option>
                    </x-forms.select>
                </div> --}}

                <div class="mb-3">
                    <x-forms.select label="Jenis Surat" placeholder="Pilih Jenis Berkas" name="jenis" required>
                        <option value="">-- Pilih Jenis Berkas --</option>
                        <option value="BBM">Surat Rekomendasi Pembelian Jenis BBM</option>
                        <option value="KTP">Surat Pengantar Pembuatan KTP</option>
                        <option value="KK">Surat Pengantar Pembuatan KK</option>
                        <option value="SKTM">SKTM</option>
                    </x-forms.select>


                    {{-- @error('jenis')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror --}}
                </div>


               <div id="bbm-only" class="animate__animated animate__fadeInUp" style="display: none;">
                    <div class="mb-3">
                        <x-forms.file name="ktp_bbm" label="KTP" placeholder="Upload File" :isRequired="true"/>
                    </div>
                    <div class="mb-3">
                        <x-forms.file name="nimb_bbm" label="NIMB" placeholder="Upload File" :isRequired="true"/>
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
        <x-modals.admin action="{{route('surat')}}" id="editModal" isUpdate=true>
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


@endsection
@section('scripts')
    <script type='text/javascript'
        src='https://www.bing.com/api/maps/mapcontrol?callback=GetMap&key={{ env('BING_API_KEY') }}' async defer></script>
    <script src="{{ asset('assets/user/js/maps.js') }}"></script>
    <script>
    ['ktp_bbm', 'nimb_bbm', 'nota', 'edtktp_bbm', 'edtnimb_bbm', 'kk_ktp','suratkelurahan_ktp','edtkk_ktp','edtsuratkelurahan_ktp','ktp_kk','suratkelurahan_kk','edtktp_kk','edtsuratkelurahan_kk','ktm_sktm','suratkelurahan_sktm','edtktm_sktm','edtsuratkelurahan_sktm'].forEach(function (id) {
            gambarHandler(id);
    });
        dataTable(7)

        // Check if users select a proposal or surat & undangan
        $('#jenis').change(function() {
            var value = $(this).val()
            if (value.toLowerCase() === "bbm") {
                $('#bbm-only').show()
            } else if (value.toLowerCase() === "ktp") {
                $('#ktp-only').show()
            } else if (value.toLowerCase() === "kk") {
                $('#kk-only').show()
            } else if (value.toLowerCase() === "sktm") {
                $('#sktm-only').show()
            }
            else {
                $('#bbm-only').hide()
                $('#ktp-only').hide()
                $('#kk-only').hide()
                $('#sktm-only').hide()
        }
        })

        $('#edtJenis').change(function() {
            var value = $(this).val()
            if (value.toLowerCase() === "bbm") {
                $('#edt-bbm-only').show()
            }
            else if (value.toLowerCase() === "ktp") {
                $('#edt-ktp-only').show()
            }
            else if (value.toLowerCase() === "kk") {
                $('#edt-kk-only').show()
            }
            else if (value.toLowerCase() === "sktm") {
                $('#edt-sktm-only').show()
            }
            else {
                $('#edt-umd-only').hide()
                $('#edt-reim-only').hide()
            }
        }
    )


    


    </script>
@endsection
