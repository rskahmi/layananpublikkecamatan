@extends('layout.user')
@section('headers')
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap"
        rel="stylesheet">
@endsection
@section('bodyClass', 'profil-kantorcamat-body')
@section('title', 'Profile Kantor Camat')
@section('content')
    <x-svg.fitur.tjsl />
    <div class="row">
        <div class="col-12 mb-3">
            <div class="card customize">
                <div class="card-header d-flex justify-content-end">
                    <a href="#edit-kontak" class="btn-edit" data-bs-toggle="modal" data-bs-target="#editKontak">
                        <x-svg.icon.editGray />
                        Edit
                    </a>
                </div>
                <div class="card-body">
                    <div class="row ps-3 pe-3">
                        <div class="col-12 col-xl-5">
                            <img src="{{ asset('assets/img/logo/logokck.svg') }}" width="137" height="67"
                                alt="Logo Kantor Camat Kundur Barat">
                            <h2 class="sub-header">Kantor Camat Kundur Barat</h2>
                            <table class="deleted-space">
                                <tr>
                                    <td>Telepon</td>
                                    <td>:</td>
                                    <td>{{ $telepon->deskripsi }}</td>
                                </tr>
                                <tr>
                                    <td>Email</td>
                                    <td>:</td>
                                    <td>{{ $email->deskripsi }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-12 col-xl-7">
                            <iframe
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3989.4902651182115!2d103.36607007472372!3d0.7347464992581066!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31d765fcdbb8ef3f%3A0xef9a9d0b1e75d864!2sKantor%20Camat%20Kundur%20Barat!5e0!3m2!1sid!2sid!4v1741668445030!5m2!1sid!2sid"
                                width="100%" height="191" style="border:0;" allowfullscreen="" loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade"></iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="row">
                {{--  --}}
                <div class="col-12 col-xl-7 mb-3 mb-xl-0">
                    <div class="card customize visimisi">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-6">
                                    <h5 class="card-title">Visi & Misi</h5>
                                </div>
                                <div class="col-6 card-header d-flex justify-content-end">
                                    <a href="#edit-visi-misi" class="btn-edit" data-bs-toggle="modal"
                                        data-bs-target="#editVisiMisi">
                                        <x-svg.icon.editGray />
                                        Edit
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="deskripsi">
                                <div class="limited-text-deskripsi-sejarah">
                                    <b>Visi</b>: <br> {{ $visi->deskripsi }}
                                </div>
                                <div class="limited-text-deskripsi-sejarah">
                                    <b>Misi</b>: <br> {{ $misi->deskripsi }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- Batas --}}
                <div class="col-12 col-xl-5">
                    <div class="card customize sekilas-ru-ii">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-6">
                                    <h5 class="card-title">Sejarah Kantor Camat</h5>
                                </div>
                                <div class="col-6 card-header d-flex justify-content-end">
                                    <a href="#edit-kontak" class="btn-edit" data-bs-toggle="modal"
                                        data-bs-target="#editSejarah">
                                        <x-svg.icon.editGray />
                                        Edit
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <img class="w-100"
                                src="{{ isFileExists('storage/images/profil-perusahaan/sejarah/' . $sejarah->gambar, asset('assets/img/dafault/default-bg.png')) }}"
                                alt="Gambar sejarah">
                            <div class="deskripsi">
                                <div class="limited-text-deskripsi-sejarah">
                                    {!! limitCharacters($sejarah->deskripsi, 290) !!}
                                </div>
                                @if (isLimit($sejarah->deskripsi, 290))
                                    <div class="full-text-deskripsi-sejarah" style="display: none;">
                                        {!! $sejarah->deskripsi !!}
                                    </div>
                                @endif
                                @if (isLimit($sejarah->deskripsi, 290))
                                    <div class="text-center">
                                        <a class="btn-more-less" href="#show-more" id="showMoreSejarah">Show More</a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                {{-- Tambahkan Disini Alur Surat dan Pengaduan --}}




            </div>
        </div>
        <div class="col-12 mt-3">
            <div class="row">
                <div class="col-12 col-xl-7">
                    <div class="card customize visimisi">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-6">
                                    <h5 class="card-title">Kelurahan/Desa</h5>
                                </div>
                                <div class="col-6 card-header d-flex justify-content-end gap-2">
                                    <button class="btn btn-primary text-capitalize" data-bs-toggle="modal"
                                        data-bs-target="#tambahProduk">
                                        <x-svg.icon.addfile />
                                        Tambah
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <x-table>
                                @slot('slotHeading')
                                    <tr>
                                        <th scope="col">NAMA</th>
                                        <th scope="col" class="text-center">KATEGORI</th>
                                        <th scope="col">GAMBAR</th>
                                        <th scope="col" class="text-center">ACTION</th>
                                    </tr>
                                @endslot

                                @slot('slotBody')
                                    @foreach ($produk as $item)
                                        <tr>
                                            <td>{{ $item->deskripsi }}</td>
                                            <td class="text-center text-uppercase">{{ $item->kategori }}</td>
                                            <td>
                                                <img width="144" height="52"
                                                    src="{{ isFileExists('storage/images/profil-perusahaan/produk/' . $item->gambar, asset('assets/img/dafault/default-bg.png')) }}"
                                                    alt="{{ $item->kategori }}">
                                            </td>
                                            <td>
                                                <div class="aksi">
                                                    <a href="##edit"
                                                    onclick="modalEditProduk(
                                                    '{{ route('profile.update.produk', ['id' => $item->id]) }}',
                                                    '{{ $item->deskripsi }}',
                                                    '{{ $item->kategori }}')">
                                                        <x-svg.icon.edit />
                                                    </a>

                                                    <x-layout.delete
                                                        action="{{ route('profile.delete.produk', $item->id) }}" />
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endslot
                            </x-table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Edit Kontak profil --}}
    <x-modals.admin action="{{ route('profile.update.kontak') }}" id="editKontak" isUpdate=true>
        @slot('slotHeader')
            <h5 class="modal-title" id="exampleModalLabel">Edit Kontak</h5>
        @endslot

        @slot('slotBody')
            <div class="mb-3">
                <x-forms.input label="Telepon" name="telepon" placeholder="Masukkan Nomor Telepon"
                    value="{{ $telepon->deskripsi }}" />
            </div>
            <div class="mb-3">
                <x-forms.input label="Email" name="email" type="email" placeholder="Masukkan Email"
                    value="{{ $email->deskripsi }}" />
            </div>
        @endslot

        @slot('slotFooter')
            <button type="submit" class="btn btn-primary btn-tutup-modal">Simpan</button>
        @endslot
    </x-modals.admin>

    <x-modals.admin action="{{ route('profile.update.visi-misi') }}" id="editVisiMisi" isUpdate=true>
        @slot('slotHeader')
            <h5 class="modal-title" id="exampleModalLabel">Edit Visi & Misi</h5>
        @endslot

        @slot('slotBody')
            <div class="mb-3">
                <x-forms.textarea label="Visi" name="visi" placeholder="Masukkan Visi Perusahaan"
                    value="{{ $visi->deskripsi }}" />
            </div>
            <div class="mb-3">
                <x-forms.textarea label="Misi" name="misi" placeholder="Masukkan Misi Perusahaan"
                    value="{{ $misi->deskripsi }}" />
            </div>
        @endslot

        @slot('slotFooter')
            <button type="submit" class="btn btn-primary btn-tutup-modal">Simpan</button>
        @endslot
    </x-modals.admin>

    <x-modals.admin action="{{ route('profile.update.sejarah') }}" id="editSejarah" isUpdate=true>
        @slot('slotHeader')
            <h5 class="modal-title" id="exampleModalLabel">Edit Sejarah</h5>
        @endslot

        @slot('slotBody')
            <div class="mb-3">
                <x-forms.file name="gambarSejarah" label="Gambar Baru" placeholder="Upload Gambar" isRequired=0 />
            </div>

            <div class="mb-3">
                <x-forms.textarea name="deskripsiSejarah" label="Deskripsi"
                placeholder="Masukkan deskripsi media" value="{{ $sejarah->deskripsi }}"/>
            </div>
        @endslot

        @slot('slotFooter')
            <button type="submit" class="btn btn-primary btn-tutup-modal">Simpan</button>
        @endslot
    </x-modals.admin>







    <x-modals.admin action="{{ route('profile.update.struktur') }}" id="editStruktur" isUpdate=true>
        @slot('slotHeader')
            <h5 class="modal-title" id="exampleModalLabel">Ubah Struktur</h5>
        @endslot

        @slot('slotBody')
            <div class="mb-3">
                <x-forms.select label="Tingkatan jabatan" name="tingkatan" placeholder="Pilih tingkatan ex: 1 For GM">
                    <option value="1">#1 General Manager</option>
                    <option value="2">#2 Area Manager Comm, Rel & CSR</option>
                    <option value="3">#3 Sr Officer 1 Comm, Rel</option>
                    <option value="4">#4 Jr Officer 1 CSR</option>
                    </x-forms.select2>
            </div>
            <div class="mb-3">
                <x-forms.input label="Nama" name="namaPejabat" placeholder="Masukkan nama" />
            </div>
            <div class="mb-3">
                <x-forms.input label="Jabatan" name="jabatan" placeholder="Masukkan jabatan" />
            </div>
            <div class="mb-3">
                <x-forms.file name="foto" label="Foto" placeholder="Upload foto" isRequired=0 />
            </div>
        @endslot

        @slot('slotFooter')
            <button type="submit" class="btn btn-primary btn-tutup-modal">Simpan</button>
        @endslot
    </x-modals.admin>

    <x-modals.admin action="{{ route('profile.store.produk') }}" id="tambahProduk">
        @slot('slotHeader')
            <h5 class="modal-title" id="exampleModalLabel">Tambah Produk</h5>
        @endslot

        @slot('slotBody')
            <div class="mb-3">
                <x-forms.input label="Nama produk" name="nama" placeholder="Masukkan Nama Produk" />
            </div>
            <div class="mb-3">
                <x-forms.file name="gambarProduk" label="Gambar Produk" placeholder="Upload Gambar" />
            </div>

            <div class="mb-3">
                <x-forms.select label="Kategori" name="kategori" placeholder="Masukkan Jenis Program">
                    <option value="BBM">BBM</option>
                    <option value="NON BBM">NON BBM</option>
                    </x-forms.select2>
            </div>
        @endslot

        @slot('slotFooter')
            <button type="submit" class="btn btn-primary btn-tutup-modal">Simpan</button>
        @endslot
    </x-modals.admin>

    <x-modals.admin action="{{ route('profile') }}" id="editProduk" isUpdate=true>
        @slot('slotHeader')
            <h5 class="modal-title" id="exampleModalLabel">Edit Produk</h5>
        @endslot

        @slot('slotBody')
            <div class="mb-3">
                <x-forms.input label="Nama produk" name="edtNama" placeholder="Masukkan Nama Produk" />
            </div>
            <div class="mb-3">
                <x-forms.file name="edtGambarProduk" label="Gambar Produk" placeholder="Upload Gambar" isRequired=0 />
            </div>

            <div class="mb-3">
                <x-forms.select label="Kategori" name="edtKategori" placeholder="Masukkan Jenis Program">
                    <option value="BBM">BBM</option>
                    <option value="NON BBM">NON BBM</option>
                    </x-forms.select2>
            </div>
        @endslot

        @slot('slotFooter')
            <button type="submit" class="btn btn-primary btn-tutup-modal">Simpan</button>
        @endslot
    </x-modals.admin>
@endsection

@section('scripts')
    <script>
        const dataSejarah = {!! json_encode($sejarah->deskripsi) !!}

        gambarHandler('gambarSejarah')
        createEditor("#deskripsiSejarah", dataSejarah)

        gambarHandler('gambarProduk')
        gambarHandler('edtGambarProduk')


        $("#showMoreSekilas, #showLessSekilas").click(function() {
            if ($(this).attr('id') === 'showMoreSekilas') {
                document.querySelector('.limited-text-deskripsi-sekilas').style.display = 'none';
                document.querySelector('.full-text-deskripsi-sekilas').style.display = 'block';

                $(this).attr('id', 'showLessSekilas');
                $(this).html('Show Less');
            } else {
                document.querySelector('.limited-text-deskripsi-sekilas').style.display = 'block';
                document.querySelector('.full-text-deskripsi-sekilas').style.display = 'none';

                $(this).attr('id', 'showMoreSekilas');
                $(this).html('Show More');
            }
        });

        $("#showMoreSejarah, #showLessSejarah").click(function() {
            if ($(this).attr('id') === 'showMoreSejarah') {
                document.querySelector('.limited-text-deskripsi-sejarah').style.display = 'none';
                document.querySelector('.full-text-deskripsi-sejarah').style.display = 'block';

                $(this).attr('id', 'showLessSejarah');
                $(this).html('Show Less');
            } else {
                document.querySelector('.limited-text-deskripsi-sejarah').style.display = 'block';
                document.querySelector('.full-text-deskripsi-sejarah').style.display = 'none';

                $(this).attr('id', 'showMoreSejarah');
                $(this).html('Show More');
            }
        });

    </script>
@endsection
