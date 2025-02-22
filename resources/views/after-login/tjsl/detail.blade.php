@extends('layout.user')

@section('title', 'Detail Program')

@section('headers')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
@endsection

@section('content')
    <x-svg.fitur.tjsl />
    <div class="row">
        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-6">
            <div class="card standart">
                <div class="card-body">
                    <div class="row">
                        <div
                            class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-6 mt-2 mt-sm-2 mt-md-0 mt-lg-0 mt-xl-0 mt-md-3">
                            <x-text.PopUpMenu title="Nama Program" subtitle="{{ $tjsl->nama }}" />
                        </div>
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-6 mt-2 mt-sm-2 mt-xl-0 mt-md-3">
                            <x-text.PopUpMenu title="Wilayah"
                                subtitle="{{ $tjsl->wilayah->alamat . ', ' . $tjsl->wilayah->kelurahan . ', ' . $tjsl->wilayah->kecamatan }}" />
                        </div>
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-6 mt-2 mt-sm-2 mt-xl-0 mt-md-3">
                            <x-text.PopUpMenu title="Tanggal" subtitle="{{ format_dfy($tjsl->tanggal) }}" />
                        </div>
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-6 mt-2 mt-sm-2 mt-xl-0 mt-md-3 mt-3">
                            <x-text.PopUpMenu title="Lembaga" subtitle="{{ $tjsl->lembaga->nama_lembaga }}" />
                        </div>
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-6 mt-2 mt-sm-2 mt-xl-0 mt-md-3 mt-3">
                            <x-text.PopUpMenu title="PIC" subtitle="{{ $tjsl->pic }}" />
                        </div>
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-6 mt-2 mt-sm-2 mt-xl-0 mt-md-3 mt-3">
                            <x-text.PopUpMenu title="Anggaran" subtitle="{{ formatRupiah($tjsl->anggaran) }}" />
                        </div>
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-6 mt-2 mt-sm-2 mt-xl-0 mt-md-3 mt-3">
                            <x-text.PopUpMenu title="No HP PIC" subtitle="{{ $tjsl->contact }}" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-6 mt-3 mt-sm-3 mt-md-3 mt-xl-0">
            <div class="card table">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col-6">
                            <h4>Rincian Anggaran</h4>
                        </div>
                        @if (isAllAdmin())
                            <div class="col-6 d-flex justify-content-end gap-2">
                                @if ($anggaranTjsl->isEmpty())
                                    <button class="btn btn-primary text-capitalize" data-bs-toggle="modal"
                                        data-bs-target="#tambahAnggaran">
                                        <x-svg.icon.addfile />
                                        Tambah Anggaran
                                    </button>
                                @endif
                                @if ($anggaranTjsl->isNotEmpty())
                                    @if($anggaranTjsl->first()->sisa_anggaran != 0)
                                            <button class="btn btn-primary text-capitalize" data-bs-toggle="modal"
                                                data-bs-target="#tambahAnggaran">
                                                <x-svg.icon.addfile />
                                                Tambah Anggaran
                                            </button>
                                        @endif
                                @endif
                            </div>

                        @endif
                    </div>
                </div>
                <div class="card-body">
                    <x-table>
                        @slot('slotHeading')
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Tujuan Anggaran</th>
                                <th scope="col">Tanggal</th>
                                <th scope="col">Nominal</th>
                                <th scope="col">Sisa Anggaran</th>
                            </tr>
                        @endslot

                        @slot('slotBody')
                            @foreach ($anggaranTjsl as $key => $item)
                                <tr>
                                    <td>
                                        {{ $key + 1 }}
                                    </td>
                                    <td>
                                        {{ $item->tujuan }}
                                    </td>
                                    <td>
                                        {{ format_dfy($item->tanggal) }}
                                    </td>
                                    <td>
                                        {{ formatRupiah($item->nominal) }}
                                    </td>
                                    <td>
                                        {{ formatRupiah($item->sisa_anggaran) }}
                                    </td>
                                </tr>
                            @endforeach
                        @endslot
                    </x-table>
                </div>
            </div>

            <x-pagination />
        </div>
    </div>


    <div class="card container-dokumentasi mt-3">
        <div class="card-header">
            <div class="row align-items-center">
                <div class="col-6">
                    <h4>Gambar</h4>
                </div>
                @if (isAllAdmin())
                    <div class="col-6 d-flex justify-content-end gap-2">
                        <button class="btn btn-primary text-capitalize" data-bs-toggle="modal"
                            data-bs-target="#tambahDokumentasi">
                            <x-svg.icon.addfile />
                            Tambah
                        </button>
                    </div>
                @endif
            </div>
        </div>
        <div class="card-body">
            <div class="owl-carousel">
                @foreach ($dokumentasTjsl as $item)
                    <div class="item">
                        <x-card.dokumentasi kegiatan="{{ $item->nama_kegiatan }}"
                            tanggal="{{ format_dfy($item->tanggal) }}"
                            gambar="{{ isFileExists('storage/images/dokumentasi-tjsl/' . $item->nama_file, asset('assets/img/dafault/default-bg.png')) }}" />
                    </div>
                @endforeach
            </div>
        </div>
    </div>


    @if (isAllAdmin())
        <x-modals.admin id="tambahAnggaran" action="{{ route('anggaran.tjsl.store', ['id' => $tjsl->id]) }}">
            @slot('slotHeader')
                <h5 class="modal-title" id="tambahAnggaran">Tambah Anggaran</h5>
            @endslot

            @slot('slotBody')
                <div class="mb-3">
                    <x-forms.input label="Tujuan Anggaran" name="tujuan" placeholder="Masukkan Tujuan Anggaran" />
                </div>

                <div class="mb-3">
                    <x-forms.date label="Tanggal" name="tanggal" placeholder="Pilih Tanggal" />
                </div>

                <div class="mb-3">
                    <x-forms.input label="Nominal" name="nominal" placeholder="Masukkan Nominal" />
                </div>
            @endslot

            @slot('slotFooter')
                <button type="submit" class="btn btn-primary btn-tutup-modal">Simpan</button>
            @endslot
        </x-modals.admin>

        <x-modals.admin id="tambahDokumentasi" action="{{ route('tjsl.dokumentasi', ['id' => $tjsl->id]) }}">
            @slot('slotHeader')
                <h5 class="modal-title" id="tambahDokumentasi">Tambah Gambar</h5>
            @endslot

            @slot('slotBody')
                <div class="mb-3">
                    <x-forms.input label="Nama Kegiatan" name="nama_kegiatan" placeholder="Masukkan Nama Kegiatan" />
                </div>

                <div class="mb-3">
                    <x-forms.date label="Tanggal" name="tanggal" placeholder="Pilih Tanggal" />
                </div>

                <div class="mb-3">
                    <x-forms.file name="gambar" label="Gambar" placeholder="Upload Gambar" />
                </div>
            @endslot

            @slot('slotFooter')
                <button type="submit" class="btn btn-primary btn-tutup-modal">Simpan</button>
            @endslot
        </x-modals.admin>
    @endif
@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
    <script>
        handlerGambar('gambar')
        dataTable(3)
        currencyInInput("#nominal")

        $(document).ready(function() {
            function calculateItemsToShow() {
                var bodyWidth = $('body').width();
                if (bodyWidth >= 1920) {
                    return 10;
                } else if (bodyWidth >= 1000) {
                    return 5;
                } else if (bodyWidth >= 600) {
                    return 3;
                } else {
                    return 1;
                }
            }


            var itemsCount = $('.owl-carousel .item').length;
            $('.owl-carousel').owlCarousel({
                loop: itemsCount > 3,
                margin: 10,
                items: calculateItemsToShow(),
                responsive: false, // Disable built-in responsive feature
            });

            $(window).resize(function() {
                $('.owl-carousel').trigger('destroy.owl.carousel'); // Destroy the existing carousel
                $('.owl-carousel').owlCarousel({
                    loop: true,
                    margin: 10,
                    items: calculateItemsToShow(),
                    responsive: false, // Disable built-in responsive feature
                });
            });
        });
    </script>
@endsection
