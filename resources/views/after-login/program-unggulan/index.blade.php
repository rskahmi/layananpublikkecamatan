@extends('layout.user')

@section('title', 'Kegiatan Kantor Camat')

@section('headers')
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
@endsection

@section('content')
    <x-svg.fitur.tjsl />
    <div class="animate__animated animate__fadeInUp">
        <div class="card table">
            <div class="card-header">
                <div class="row align-items-center">
                    <div class="col-12 col-sm-12 col-md-5">
                        <h4>Daftar - Daftar Kegiatan Yang Telah Dilakukan</h4>
                    </div>
                    <div class="col-12 col-sm-12 col-md-7 d-flex justify-content-start justify-content-md-end gap-2">
                        <x-search />
                            <button class="btn btn-primary text-capitalize" data-bs-toggle="modal" data-bs-target="#tambahProgram">
                                <x-svg.icon.addfile />
                                Tambah Program
                            </button>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <x-table>
                    @slot('slotHeading')
                        <tr>
                            <th scope="col">NAMA KEGIATAN</th>
                            <th scope="col">MITRA</th>
                            <th scope="col">ALAMAT</th>
                            <th scope="col">DESKRIPSI</th>
                            <th scope="col">PIC</th>
                            <th scope="col">GAMBAR</th>
                                <th scope="col" class="text-center">AKSI</th>
                        </tr>
                    @endslot

                    @slot('slotBody')
                        @foreach ($program_unggulan as $item)
                        @php
                            $gambar = isFileExists('storage/images/program-unggulan/' . $item->gambar, asset('assets/img/dafault/default-bg.png'));
                        @endphp
                        <tr>
                            <td class="w">
                                <h5>{{ $item->nama_kegiatan }}</h5>
                                <span>
                                    {{ format_dfy($item->created_at) }}
                                </span>
                            </td>
                            <td>
                                <a>{{ $item->mitra }}</a>
                            </td>
                            <td>
                                <h5>{{ $item->nama_kelompok }}</h5>
                            </td>
                            <td class="w-25">
                                <span>
                                    <div class="limited-text-deskripsi">
                                        {!! limitCharacters($item->deskripsi, 140) !!}
                                    </div>
                                    @if (isLimit($item->deskripsi, 140))
                                        <div class="full-text-deskripsi" style="display: none;">
                                            {!! $item->deskripsi !!}
                                        </div>
                                        <a class="text-decoration-underline" href="##more" onclick="showMore(this)">More</a>
                                    @endif
                                </span>
                            </td>
                            <td>
                                <span>{{ $item->pic }}</span>
                            </td>
                            <td>
                                <img src="{{ $gambar }}" alt="" width="157"
                                    height="73">
                            </td>
                                <td>
                                    <div class="aksi">
                                        <a href="##edit" id="edit" onclick="modalEditProgramUnggulan(
                                            '{{ route('program-unggulan.update', ['id' => $item->id]) }}',
                                            '{{ $item->nama_kegiatan }}',
                                            '{{ $item->nama_kelompok }}',
                                            '{{ $item->mitra }}',
                                            '{{ $item->contact }}',
                                            '{{ $item->pic }}',
                                            '{{ $item->deskripsi }}',
                                            '{{ $gambar }}'
                                        )">
                                            <x-svg.icon.edit />
                                        </a>

                                        <x-layout.delete action="{{ route('program-unggulan.destroy', ['id' => $item->id]) }}" />
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

        <x-modals.admin action="{{ route('program-unggulan.store') }}" id="tambahProgram">

            @slot('slotHeader')
                <h5 class="modal-title" id="exampleModalLabel">Tambah Program</h5>
            @endslot

            @slot('slotBody')
                <div class="mb-3">
                    <x-forms.input label="Nama Program" name="nama_kegiatan" placeholder="Masukkan Nama Program" />
                </div>
                <div class="mb-3">
                    <x-forms.input label="Mitra Binaan" name="mitra" placeholder="Masukkan Mitra Binaan" />
                </div>
                <div class="mb-3">
                    <x-forms.input label="Nama Kelompok" name="nama_kelompok" placeholder="Masukkan Nama Kelompok" />
                </div>
                <div class="mb-3">
                    <x-forms.input label="No Telepon Ketua Kelompok" name="contact"
                        placeholder="Masukkan No Telepon" />
                </div>
                <div class="mb-3">
                    <x-forms.input label="PIC" name="pic" placeholder="Masukkan Nama PIC" />
                </div>
                <div class="mb-4">
                    <x-forms.textarea label="Deskripsi" name="deskripsi" placeholder="Masukkan Deskripsi"/>
                </div>
                <div class="mb-3">
                    <x-forms.file
                        name="gambar"
                        label="Gambar"
                        placeholder="Pilih Gambar"
                    />
                </div>
            @endslot

            @slot('slotFooter')
                <button type="submit" class="btn btn-primary btn-tutup-modal ld-ext-right" >Simpan</button>
            @endslot
        </x-modals.admin>

        <x-modals.admin id="editProgram" action="{{ route('program-unggulan') }}" isUpdate=true>
            @slot('slotHeader')
                <h5 class="modal-title" id="editProgramLabel">Edit Program</h5>
            @endslot

            @slot('slotBody')
                <div class="mb-3">
                    <x-forms.input label="Nama Program" name="edtNamaProgram" placeholder="Masukkan Nama Program" />
                </div>
                <div class="mb-3">
                    <x-forms.input label="Mitra Binaan" name="edtMitraBinaan" placeholder="Masukkan Mitra Binaan" />
                </div>
                <div class="mb-3">
                    <x-forms.input label="Nama Kelompok" name="edtNamaKelompok" placeholder="Masukkan Nama Kelompok" />
                </div>
                <div class="mb-3">
                    <x-forms.input label="Ketua Kelompok" name="edtKetuaKelompok" placeholder="Masukkan Nama Ketua Kelompok" />
                </div>
                <div class="mb-3">
                    <x-forms.input label="No Telepon Ketua Kelompok" name="edtContact"
                        placeholder="Masukkan No Telepon" />
                </div>
                <div class="mb-3">
                    <x-forms.input label="PIC" name="edtPic" placeholder="Masukkan Nama PIC" />
                </div>
                <div class="mb-4">
                    <x-forms.textarea label="Deskripsi" name="edtDeskripsi" placeholder="Masukkan deskripsi"/>
                </div>
                <div class="mb-3">
                    <label for="gambarLama">Gambar Lama</label>
                    <img src="" alt="Gambar lama" width="100%" height="129" id="gambarLama">
                </div>
                <div class="mb-3">
                    <x-forms.file
                        name="edtGambar"
                        label="Gambar"
                        placeholder="Pilih Gambar"
                        isRequired=0
                    />
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
        dataTable(5)

        createEditor("#deskripsi")
        createEditor("#edtDeskripsi")
        gambarHandler('gambar')
        gambarHandler('edtGambar')

    </script>
@endsection
