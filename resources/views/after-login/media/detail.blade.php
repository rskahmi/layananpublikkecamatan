@extends('layout.user')

@section('title', 'Detail Rilis')
@section('headers')
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
@endsection
@section('content')
    <x-svg.fitur.berkas />

    <div class="row detail-pengajuan">
        <div class="col-11">
            <div class="card standart">
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <div class="row">
                                <div class="col-12 mb-2">
                                    <x-text.PopUpMenu title="Judul" subtitle="{{ $rilis->judul }}" />
                                </div>
                                <div class="col-12 mb-2">
                                    <x-text.PopUpMenu title="Deskripsi" subtitle="{!! $rilis->deskripsi !!}" />
                                </div>
                                <div class="col-12 mb-2">
                                    <div class="popup-text">
                                        <h6>Jenis Media</h6>
                                    </div>

                                    <div class="progress-bar-berita mt-2">
                                        <div class="row d-flex align-items-center">
                                            <div class="col-5">
                                                <div class="progress">
                                                    <div class="progress-bar bg-progress-warning" role="progressbar"
                                                        style="width: {{ parseToPercentage($jumlah_berita_online, $jumlah_berita) }}%;"
                                                        aria-valuenow="{{ $jumlah_berita_online }}" aria-valuemin="0"
                                                        aria-valuemax="{{ $jumlah_berita }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-1">
                                                <span class="value">{{ $rilis['jumlah_berita_online'] }}</span>
                                            </div>
                                        </div>
                                        <span class="title"> {{ $jumlah_berita_online}} Online</span>
                                        <div class="row d-flex align-items-center">
                                            <div class="col-5">
                                                <div class="progress">
                                                    <div class="progress-bar bg-progress-semi-danger" role="progressbar"
                                                        style="width: {{ parseToPercentage($jumlah_berita_cetak, $jumlah_berita) }}%;"
                                                        aria-valuenow="{{ $jumlah_berita_cetak }}" aria-valuemin="0"
                                                        aria-valuemax="{{ $jumlah_berita }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-1">
                                                <span class="value">{{ $rilis['jumlah_berita_cetak'] }}</span>
                                            </div>
                                        </div>
                                        <span class="title"> {{ $jumlah_berita_cetak }} Cetak</span>
                                        <div class="row d-flex align-items-center">
                                            <div class="col-5">
                                                <div class="progress">
                                                    <div class="progress-bar bg-progress-more-warning" role="progressbar"
                                                        style="width: {{ parseToPercentage($jumlah_berita_elektronik, $jumlah_berita) }}%;"
                                                        aria-valuenow="{{ $jumlah_berita_elektronik }}" aria-valuemin="0"
                                                        aria-valuemax="{{ $jumlah_berita }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-1">
                                                <span class="value">{{ $rilis['jumlah_berita_elektronik'] }}</span>
                                            </div>
                                        </div>
                                        <span class="title"> {{ $jumlah_berita_elektronik }} Elektronik</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="popup-text">
                                <h6>Gambar</h6>
                            </div>
                            <img class="rounded mt-1"
                                src="{{ isFileExists('storage/images/rilis/' . $rilis->gambar, asset('assets/img/dafault/default-bg.png')) }}"
                                width="302" height="158" alt="Gambar {{ $rilis->judul }}">
                        </div>

                        <div class="col-8">
                            <div class="card table">
                                <div class="card-header">
                                    <div class="row align-items-center">
                                        <div class="col-12 col-sm-12 col-md-5">
                                            <h4>Data Pemberitaan</h4>
                                        </div>
                                        <div
                                            class="col-12 col-sm-12 col-md-7 d-flex justify-content-start justify-content-md-end gap-2">
                                            @if (isAllAdmin())
                                                <button class="btn btn-primary text-capitalize" data-bs-toggle="modal"
                                                    data-bs-target="#tambahPemberitaan">
                                                    <x-svg.icon.addfile />
                                                    Tambah
                                                </button>
                                                <select class="form-select" id="jenisMedia" style="max-width: 180px">
                                                    <option selected value="media online">Media Online</option>
                                                    <option value="media cetak">Media Cetak</option>
                                                    <option value="media elektronik">Media Elektronik</option>
                                                </select>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div id="media-online-container">
                                        <x-table id="media-online-dataTable">
                                            @slot('slotHeading')
                                                <tr>
                                                    <th scope="col" class="w-25">LINK</th>
                                                    <th scope="col" class="w-35">RESPON</th>
                                                    <th scope="col">JENIS MEDIA</th>
                                                    @if (isAllAdmin())
                                                        <th scope="col" class="text-center">AKSI</th>
                                                    @endif
                                                </tr>
                                            @endslot


                                            @slot('slotBody')
                                                @foreach ($pemberitaan_online as $item)
                                                    <tr>
                                                        <td>
                                                            <a
                                                                href="{{ $item->tautan }}">{{ getDomainOnly($item->tautan) }}</a>
                                                        </td>
                                                        <td>
                                                            @php
                                                                $respon = $item->respon;
                                                            @endphp

                                                            <span
                                                                class="badge text-uppercase {{ strtolower($respon) == 'positif'
                                                                    ? 'bg-success'
                                                                    : (strtolower($respon) == 'negatif'
                                                                        ? 'bg-danger'
                                                                        : (strtolower($respon) == 'netral'
                                                                            ? 'bg-primary'
                                                                            : '')) }}">{{ $respon }}
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <span class="badge text-uppercase bg-progress-warning">
                                                                {{ $item->jenis }}
                                                            </span>
                                                        </td>
                                                        @if (isAllAdmin())
                                                            <td>
                                                                <div
                                                                    class="aksi d-flex align-items-center justify-content-center">
                                                                    <a class="editClassed" href="##edit" id="edit"
                                                                        data-bs-toggle="modal" data-bs-target="#editModal"
                                                                        onclick="updatePemberitaan(
                                                                        '{{ route('media.pemberitaan.update', ['id' => $item->id]) }}',
                                                                        'media online',
                                                                        'positif',
                                                                        '{{ $item->tautan }}'
                                                                    )">
                                                                        <x-svg.icon.edit />
                                                                    </a>
                                                                    <x-layout.delete
                                                                        action="{{ route('media.pemberitaan.destroy', ['id' => $item->id]) }}" />
                                                                </div>
                                                            </td>
                                                        @endif
                                                    </tr>
                                                @endforeach
                                            @endslot
                                        </x-table>

                                        <x-pagination id="media-online-dataTable" />
                                    </div>

                                    <div id="media-cetak-container" style="display: none;">
                                        <x-table id="media-cetak-dataTable">
                                            @slot('slotHeading')

                                                <tr>
                                                    <th scope="col" class="w-25">GAMBAR</th>
                                                    <th scope="col" class="w-35">RESPON</th>
                                                    <th scope="col">JENIS MEDIA</th>
                                                    @if (isAllAdmin())
                                                        <th scope="col" class="text-center">AKSI</th>
                                                    @endif
                                                </tr>
                                            @endslot

                                            @slot('slotBody')
                                                @foreach ($pemberitaan_cetak as $item)
                                                    @php
                                                        $gambar = isFileExists(
                                                            'storage/images/pemberitaan/' . $item->gambar,
                                                            asset('assets/img/dafault/default-bg.png'),
                                                        );
                                                    @endphp
                                                    <tr>
                                                        <td>
                                                            <img class="rounded"
                                                                src="{{ $gambar }}"
                                                                width="170" height="83" alt="">
                                                        </td>
                                                        <td>
                                                            @php
                                                                $respon = $item->respon;
                                                            @endphp
                                                            <span
                                                                class="badge text-uppercase {{ strtolower($respon) == 'positif'
                                                                    ? 'bg-success'
                                                                    : (strtolower($respon) == 'negatif'
                                                                        ? 'bg-danger'
                                                                        : (strtolower($respon) == 'netral'
                                                                            ? 'bg-primary'
                                                                            : '')) }}">{{ $respon }}
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <span class="badge text-uppercase bg-progress-semi-danger">
                                                                {{ $item->jenis }}

                                                            </span>
                                                        </td>
                                                        @if (isAllAdmin())
                                                            <td>
                                                                <div
                                                                    class="aksi d-flex align-items-center justify-content-center">
                                                                    <a class="editClassed" href="##edit" id="edit"
                                                                        data-bs-toggle="modal" data-bs-target="#editModal"
                                                                        onclick="updatePemberitaan(
                                                                        '{{ route('media.pemberitaan.update', ['id' => $item->id]) }}',
                                                                        'media cetak',
                                                                        'positif',
                                                                        '{{ $gambar }}'
                                                                    )">
                                                                        <x-svg.icon.edit />
                                                                    </a>
                                                                    <x-layout.delete
                                                                        action="{{ route('media.pemberitaan.destroy', ['id' => $item->id]) }}" />
                                                                </div>
                                                            </td>
                                                        @endif
                                                    </tr>
                                                @endforeach
                                            @endslot
                                        </x-table>
                                        <x-pagination id="media-cetak-dataTable" />
                                    </div>
                                    <div id="media-elektronik-container" style="display: none;">
                                        <x-table id="media-elektronik-dataTable">
                                            @slot('slotHeading')

                                                <tr>
                                                    <th scope="col" class="w-25">GAMBAR</th>
                                                    <th scope="col" class="w-35">RESPON</th>
                                                    <th scope="col">JENIS MEDIA</th>
                                                    @if (isAllAdmin())
                                                        <th scope="col" class="text-center">AKSI</th>
                                                    @endif
                                                </tr>
                                            @endslot


                                            @slot('slotBody')
                                                @foreach ($pemberitaan_elektronik as $item)
                                                    @php
                                                        $gambar = isFileExists(
                                                            'storage/images/pemberitaan/' . $item->gambar,
                                                            asset('assets/img/dafault/default-bg.png'),
                                                        );
                                                    @endphp
                                                    <tr>
                                                        <td>
                                                            <img class="rounded"
                                                                src="{{ $gambar }}"
                                                                width="170" height="83" alt="">
                                                        </td>
                                                        <td>
                                                            @php
                                                                $respon = $item->respon;
                                                            @endphp
                                                            <span
                                                                class="badge text-uppercase {{ strtolower($respon) == 'positif'
                                                                    ? 'bg-success'
                                                                    : (strtolower($respon) == 'negatif'
                                                                        ? 'bg-danger'
                                                                        : (strtolower($respon) == 'netral'
                                                                            ? 'bg-primary'
                                                                            : '')) }}">{{ $respon }}
                                                            </span>
                                                        </td>
                                                        <td>
                                                            @php
                                                                $jenis = 'Media Elektronik';
                                                            @endphp
                                                            <span class="badge text-uppercase bg-progress-more-warning">
                                                                {{ $item->jenis }}

                                                            </span>
                                                        </td>
                                                        @if (isAllAdmin())
                                                            <td>
                                                                <div
                                                                    class="aksi d-flex align-items-center justify-content-center">
                                                                    <a class="editClassed" href="##edit" id="edit"
                                                                        data-bs-toggle="modal" data-bs-target="#editModal"
                                                                        onclick="updatePemberitaan(
                                                                        '{{ route('media.pemberitaan.update', ['id' => $item->id]) }}',
                                                                        'media elektronik',
                                                                        'positif',
                                                                        '{{ $gambar }}'
                                                                    )">
                                                                        <x-svg.icon.edit />
                                                                    </a>
                                                                    <x-layout.delete
                                                                        action="{{ route('media.pemberitaan.destroy', ['id' => $item->id]) }}" />
                                                                </div>
                                                            </td>
                                                        @endif
                                                    </tr>
                                                @endforeach
                                            @endslot
                                        </x-table>
                                        <x-pagination id="media-elektronik-dataTable" />
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if (isAllAdmin())
        <!-- Modal -->
        <x-modals.admin id="tambahPemberitaan" action="{{ route('media.pemberitaan.store', ['id' => $rilis->id]) }}">
            @slot('slotHeader')
                <h5 class="modal-title" id="exampleModalLabel">Tambah Data</h5>
            @endslot

            @slot('slotBody')
                <div class="mb-3">
                    <x-forms.select label="Jenis" name="jenis" placeholder="Masukkan Jenis">
                        <option value="media online">Media Online</option>
                        <option value="media cetak">Media Cetak</option>
                        <option value="media elektronik">Media Elektronik</option>
                    </x-forms.select>
                </div>

                <div class="mb-3">
                    <x-forms.select label="Respon" name="respon" placeholder="Masukkan Respon">
                        <option value="netral">Netral</option>
                        <option value="positif">Positif</option>
                        <option value="negatif">Negatif</option>
                    </x-forms.select>
                </div>

                <div class="mb-3" id="inputTautanContainer" style="display: none">
                    <x-forms.input type="url" label="Tautan" name="tautan" placeholder="Masukkan tautan media"
                        isRequired=0 />
                </div>

                <div class="mb-3" id="inputGambarContainer" style="display: none">
                    <x-forms.file name="gambar" label="Gambar" placeholder="Upload Gambar" isRequired=0 />
                </div>
            @endslot

            @slot('slotFooter')
                <button type="submit" class="btn btn-primary btn-tutup-modal">Simpan</button>
            @endslot
        </x-modals.admin>

        <x-modals.admin id="editModal" action="{{ route('media') }}" isUpdate=true>
            @slot('slotHeader')
                <h5 class="modal-title" id="exampleModalLabel">Ubah Data</h5>
            @endslot

            @slot('slotBody')
                <div class="mb-3">
                    <x-forms.select label="Jenis" name="edtJenis" placeholder="Masukkan Jenis">
                        <option value="media online">Media Online</option>
                        <option value="media cetak">Media Cetak</option>
                        <option value="media elektronik">Media Elektronik</option>
                    </x-forms.select>
                </div>

                <div class="mb-3">
                    <x-forms.select label="Respon" name="edtRespon" placeholder="Masukkan Respon">
                        <option value="netral">Netral</option>
                        <option value="positif">Positif</option>
                        <option value="negatif">Negatif</option>
                    </x-forms.select>
                </div>

                <div class="mb-3" id="edtInputTautanContainer" style="display: none">
                    <x-forms.input type="url" label="Tautan" name="edtTautan" placeholder="Masukkan tautan media"
                        isRequired=0 />
                </div>


                <div id="edtInputGambarContainer" style="display: none">
                    <div class="mb-3" id="containerGambarLama">
                        <label>Gambar Lama</label> <br>
                        <img id="gambarLama" src="" alt="Gambar lama">
                    </div>
                    <div class="mb-3">
                        <x-forms.file name="edtGambar" label="Gambar" placeholder="Upload Gambar" isRequired=0 />
                    </div>
                </div>
            @endslot

            @slot('slotFooter')
                <button type="submit" class="btn btn-primary btn-tutup-modal">Simpan</button>
            @endslot
        </x-modals.admin>
    @endif
@endsection

@section('scripts')
    <script>
        dataTable(5, "#media-online-dataTable")
        dataTable(5, "#media-cetak-dataTable")

        gambarHandler('gambar')
        gambarHandler('edtGambar')

        $("#jenis").on('change', function() {
            var value = $(this).val();

            if (value === 'media online') {
                $("#inputTautanContainer").show();
                $("#inputGambarContainer").hide();
            } else if (value === 'media cetak' || value === 'media elektronik') {
                $("#inputTautanContainer").hide();
                $("#inputGambarContainer").show();
            } else {
                $("#inputTautanContainer").hide();
                $("#inputGambarContainer").hide();
            }
        })

        $("#edtJenis").on('change', function() {
            var value = $(this).val();

            if (value === 'media online') {
                $("#edtInputTautanContainer").show();
                $("#edtInputGambarContainer").hide();
            } else if (value === 'media cetak' || value === 'media elektronik') {
                $("#edtInputTautanContainer").hide();
                $("#edtInputGambarContainer").show();
                $("#containerGambarLama").hide()
            } else {
                $("#edtInputTautanContainer").hide();
                $("#edtInputGambarContainer").hide();
            }
        })

        $(document).ready(function() {
            $("#jenisMedia").on('change', function() {
                var value = $(this).val()

                if (value === 'media cetak') {
                    $("#media-cetak-container").show()
                    $("#media-online-container").hide()
                    $("#media-elektronik-container").hide()
                } else if (value === 'media elektronik') {
                    $("#media-elektronik-container").show()
                    $("#media-cetak-container").hide()
                    $("#media-online-container").hide()
                } else {
                    $("#media-online-container").show()
                    $("#media-elektronik-container").hide()
                    $("#media-cetak-container").hide()
                }
            })
        })
    </script>
@endsection
