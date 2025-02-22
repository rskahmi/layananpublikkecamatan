@extends('layout.user')

@section('title', 'Detail Program PUMK')

@section('headers')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
@endsection

@section('content')
    <x-svg.fitur.tjsl />

    <div class="row">
        <div class="col-5">
            <div class="card standart">
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <x-text.PopUpMenu title="Nama Usaha" subtitle="{{ $pumk->nama_usaha }}" />
                        </div>
                        <div class="col-6">
                            <x-text.PopUpMenu title="Nama Pengusaha" subtitle="{{ $pumk->nama_pengusaha }}" />
                        </div>
                        <div class="col-6 mt-3">
                            <x-text.PopUpMenu title="Tanggal Pengajuan" subtitle="{{ $pumk->tanggal }}" />
                        </div>
                        <div class="col-6 mt-3">
                            <x-text.PopUpMenu title="No HP Pengusaha" subtitle="{{ $pumk->contact }}" />
                        </div>
                        <div class="col-6 mt-3">
                            <x-text.PopUpMenu title="Wilayah"
                                subtitle="{{ $pumk->wilayah->alamat . ', ' . $pumk->wilayah->kelurahan . ', ' . $pumk->wilayah->kecamatan }}" />
                        </div>
                        <div class="col-6 mt-3">
                            <x-text.PopUpMenu title="Anggaran" subtitle="{{ formatRupiah($pumk->anggaran) }}" />
                        </div>
                        <div class="col-6 mt-3">
                            <x-text.PopUpMenu title="Lembaga" subtitle="{{ $pumk->lembaga->nama_lembaga }}" />
                        </div>
                        <div class="col-6 mt-3">
                            <x-text.PopUpMenu title="Agunan" subtitle="{{ $pumk->agunan }}" />
                        </div>
                        <div class="col-6 mt-3">
                            <x-text.PopUpMenu title="Jatuh Tempo" subtitle="{{ $pumk->jatuh_tempo }}" />
                        </div>
                        <div class="col-6 mt-3">
                            <div class="popup-text">
                                <h6>Status</h6>
                                <span
                                    class="badge {{ strtolower($pumk->status) === 'lancar' ? 'bg-success' : 'bg-warning' }}">{{ $pumk->status }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- <div class="col-6">
            <div class="card table">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col-6">
                            <h4>Rincian Pembayaran</h4>
                        </div>
                        @if (isAllAdmin())
                            <div class="col-6 d-flex justify-content-end gap-2">
                                @if ($pumk->status != 'Lunas')
                                    <button class="btn btn-primary text-capitalize" data-bs-toggle="modal"
                                        data-bs-target="#tambahRiwayatAnggaran">
                                        <x-svg.icon.addfile />
                                        Tambah Pembayaran
                                    </button>
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
                                <th scope="col">Jumlah Pembayaran</th>
                                <th scope="col">Tanggal</th>
                                <th scope="col">Sisa</th>
                            </tr>
                        @endslot

                        @slot('slotBody')
                            @foreach ($pembayaran as $key => $item)
                                <tr>
                                    <td>
                                        {{ $key + 1 }}
                                    </td>
                                    <td>
                                        {{ formatRupiah($item->jumlah_pembayaran) }}
                                    </td>
                                    <td>
                                        {{ format_dfy($item->tanggal) }}
                                    </td>
                                    <td>
                                        {{ formatRupiah($item->sisa_pembayaran) }}
                                    </td>
                                </tr>
                            @endforeach
                        @endslot
                    </x-table>
                </div>
            </div>

            <x-pagination />
        </div> --}}
    {{-- </div> --}}
{{--
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
                @foreach ($dokumentasiPumk as $item)
                    <div class="item">
                        <x-card.dokumentasi
                            kegiatan="{{ $item->nama_kegiatan }}"
                            tanggal="{{ $item->tanggal }}"
                            gambar="{{ isFileExists('storage/images/dokumentasi-pumk/' . $item->nama_file, asset('assets/img/dafault/default-bg.png')) }}" />
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    @if (isAllAdmin())
        <x-modals.admin id="tambahRiwayatAnggaran" action="{{ route('pumk.pembayaran', ['id' => $pumk->id]) }}">
            @slot('slotHeader')
                <h5 class="modal-title" id="tambahRiwayatAnggaran">Tambah Riwayat Pembayaran</h5>
            @endslot

            @slot('slotBody')
                <div class="mb-3">
                    <x-forms.input label="Jumlah Pembayaran" name="jumlah_pembayaran" type="number"
                        placeholder="Masukkan Jumlah Pembayaran" />
                </div>

                <div class="mb-3">
                    <x-forms.date label="Tanggal" name="tanggal" placeholder="Pilih Tanggal" />
                </div>
            @endslot

            @slot('slotFooter')
                <button type="submit" class="btn btn-primary btn-tutup-modal">Simpan</button>
            @endslot
        </x-modals.admin>

        <x-modals.admin id="tambahDokumentasi" action="{{ route('pumk.dokumentasi', ['id' => $pumk->id]) }}">
            @slot('slotHeader')
                <h5 class="modal-title" id="tambahDokumentasi">Tambah Foto/Video</h5>
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
    @endif --}}
@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
    <script>
        handlerGambar('gambar')
        dataTable(3)
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
                responsive: false,
            });

            $(window).resize(function() {
                $('.owl-carousel').trigger('destroy.owl.carousel');
                $('.owl-carousel').owlCarousel({
                    loop: true,
                    margin: 10,
                    items: calculateItemsToShow(),
                    responsive: false,
                });
            });
        });
    </script>
@endsection
