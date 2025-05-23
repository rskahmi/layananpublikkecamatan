@extends('layout.user')

@section('title', 'Monitoring Berita')

@section('headers')
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
@endsection

@section('content')
    <x-svg.fitur.media />

    <div class="animate__animated animate__fadeInUp">
        <div class="card table">
            <div class="card-header">
                <div class="row align-items-center">
                    <div class="col-12 col-sm-12 col-md-5">
                        <h4>Data Berita</h4>
                    </div>
                    <div class="col-12 col-sm-12 col-md-7 d-flex justify-content-start justify-content-md-end gap-2">
                        <x-search />
                            <button class="btn btn-primary text-capitalize" data-bs-toggle="modal"
                                data-bs-target="#tambahMediaModal">
                                <x-svg.icon.addfile />
                                Tambah Berita
                            </button>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <x-table>
                    @slot('slotHeading')
                        <tr>
                            <th scope="col" class="w-25">JUDUL</th>
                            <th scope="col" class="w-35">DESKRIPSI</th>
                            <th scope="col">Foto</th>
                                <th scope="col" class="text-center">AKSI</th>
                        </tr>
                    @endslot

                    @slot('slotBody')

                        @foreach ($berita as $item)
                            @php
                                $foto = isFileExists('storage/images/berita/' . $item->foto, asset('assets/img/dafault/default-bg.png'))
                            @endphp
                            <tr>
                                <td>
                                    <h5>{{ $item->judul }}</h5>
                                </td>
                                <td>
                                    <div class="limited-text-deskripsi">
                                        {!! limitCharacters($item->deskripsi, 170) !!}
                                    </div>
                                    @if (isLimit($item->deskripsi, 170))
                                        <div class="full-text-deskripsi" style="display: none;">
                                            {!! $item->deskripsi !!}
                                        </div>
                                        <a class="text-decoration-underline" href="##more" onclick="showMore(this)">More</a>
                                    @endif
                                </td>
                                <td>
                                    <ul>
                                        <img width="50" height="100%" src="{{ $foto }}" alt="foto {{ $item->judul }}">
                                    </ul>
                                </td>

                                    {{-- <td>
                                        <div class="aksi d-flex align-items-center justify-content-center">
                                            <a class="editClassed" href="##edit" id="edit"
                                                onclick="modalEditMedia(
                                    '{{ route('media.update', ['id' => $item->id]) }}',
                                    '{{ $item->judul }}',
                                    '{{ $item->deskripsi }}',
                                    '{{ asset('storage/images/rilis/' . $item->gambar) }}',
                                    '{{ $item->jenis }}')"
                                                data-bs-toggle="modal" data-bs-target="#editModal">
                                                <x-svg.icon.edit />
                                            </a>
                                            <x-layout.delete action="{{ route('media.destroy', ['id' => $item->id]) }}" />
                                        </div>
                                    </td> --}}

                            </tr>
                        @endforeach
                    @endslot
                </x-table>
            </div>
        </div>
        <x-pagination />
    </div>


        <!-- Modal -->
        <x-modals.admin id="tambahMediaModal" action="">
            @slot('slotHeader')
                <h5 class="modal-title" id="exampleModalLabel">Tambah Rilis</h5>
            @endslot

            @slot('slotBody')
                <div class="mb-3">
                    <x-forms.input label="Judul" name="judul" placeholder="Masukkan judul rilis"/>
                </div>

                <div class="mb-3">
                    <x-forms.textarea name="deskripsi" label="Deskripsi" placeholder="Masukkan deskripsi rilis" required/>
                </div>

                <div class="mb-3">
                    <x-forms.file name="gambar" label="Gambar" placeholder="Upload Gambar" required/>
                </div>
            @endslot

            @slot('slotFooter')
                <button type="submit" class="btn btn-primary btn-tutup-modal">Simpan</button>
            @endslot
        </x-modals.admin>

        <x-modals.admin id="editModal" action="" isUpdate=true>
            @slot('slotHeader')
                <h5 class="modal-title" id="exampleModalLabel">Edit Rilis</h5>
            @endslot

            @slot('slotBody')
                <div class="mb-3">
                    <x-forms.input label="Judul" name="edtJudul" placeholder="Masukkan judul media" />
                </div>
                <div class="mb-3">
                    <x-forms.textarea name="edtDeskripsiMedia" label="Deskripsi" placeholder="Masukkan deskripsi media" />
                </div>

                <div class="mb-3">
                    <label for="gambarLama">Gambar Lama</label>
                    <img src="" alt="Gambar lama" width="100%" height="129" id="gambarLama">
                </div>
                <div class="mb-3">
                    <x-forms.file name="edtGambar" label="Gambar Baru" isRequired=0 placeholder="Upload Gambar" />
                </div>
            @endslot

            @slot('slotFooter')
                <button type="submit" class="btn btn-primary btn-tutup-modal">Simpan</button>
            @endslot
        </x-modals.admin>

@endsection
@section('scripts')
    <script src="https://cdn.ckeditor.com/ckeditor5/41.2.0/classic/ckeditor.js"></script>
    <script>
        gambarHandler('gambar')
        gambarHandler('edtGambar')

        dataTable(5)
        createEditor("#deskripsi")
        createEditor("#edtDeskripsiMedia")

        addNewInput("#tautan-plus", "#tautanContainer", false)

        $(".editClassed").click(() => {
            addNewInput("#edt-tautan-plus", "#edtTautanContainer", true)
        })

        removeNewInput('.tautan-min', '.input-group')
        removeNewInput('.edt-tautan-min', '.input-group')
    </script>
@endsection
