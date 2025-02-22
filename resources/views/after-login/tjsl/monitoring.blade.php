@extends('layout.user')

@section('title', 'Monitoring Program')

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
                        <h4>Daftar - Daftar Program</h4>
                    </div>
                    <div class="col-12 col-sm-12 col-md-7 d-flex justify-content-start justify-content-md-end gap-2">
                        <x-search />
                        @if (isAllAdmin())
                            <button class="btn btn-primary text-capitalize" data-bs-toggle="modal"
                                data-bs-target="#tambahProgramModal">
                                <x-svg.icon.addfile />
                                Tambah Program
                            </button>
                        @endif
                    </div>
                </div>
            </div>
            <div class="card-body">
                <x-table>
                    @slot('slotHeading')
                        <tr>
                            <th scope="col" class="w-25">NAMA PROGRAM</th>
                            <th scope="col">JENIS</th>
                            <th scope="col">STAKEHOLDER</th>
                            <th scope="col">ANGGARAN</th>
                            <th scope="col">PIC</th>
                            @if (isAllAdmin())
                                <th scope="col" class="text-center">AKSI</th>
                            @endif
                        </tr>
                    @endslot

                    @slot('slotBody')
                        @foreach ($tjsl as $item)
                            <tr>
                                <td>
                                    <h5>{{ $item->nama }}</h5>
                                    <span>{{ format_dfy($item->tanggal) }}</span>
                                </td>
                                <td class="text-capitalize">
                                    {{ $item->jenis }}
                                </td>
                                <td class="w-25">
                                    <h5> {{ $item->lembaga->nama_lembaga }} </h5>
                                    <span>
                                        {{ $item->wilayah->alamat }},
                                        {{ $item->wilayah->kelurahan }},
                                        {{ $item->wilayah->kecamatan }}
                                    </span>
                                </td>
                                <td>
                                    {{ formatRupiah($item->anggaran) }}
                                </td>
                                <td>
                                    <h6>{{ $item->pic }}</h6>
                                    <span>
                                        <a target="_blank" href="https://wa.me/{{ checkNumber($item->contact) }}" class="text-decoration-underline">{{ checkNumber($item->contact) }}</a>
                                    </span>
                                </td>
                                @if (isAllAdmin())
                                    <td>
                                        <div class="aksi">
                                            <a href="##edit" id="edit"
                                                onclick="modalEditTjsl(
                                                    '{{ route('tjsl.update', ['id' => $item->id]) }}',
                                                    '{{ $item->nama }}',
                                                    '{{ $item->wilayah->id }}',
                                                    '{{ $item->lembaga->id }}',
                                                    '{{ $item->anggaran }}',
                                                    '{{ $item->pic }}',
                                                    '{{ $item->contact }}',
                                                    '{{ $item->tanggal }}',
                                                    '{{ $item->jenis }}')">
                                                <x-svg.icon.edit />
                                            </a>
                                            <a href="{{ route('tjsl.detail', ['id' => $item->id]) }}">
                                                <x-svg.icon.info />
                                            </a>
                                            <x-layout.delete action="{{ route('tjsl.destroy', ['id' => $item->id]) }}" />
                                        </div>
                                    </td>
                                @endif
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
        <x-modals.admin action="{{ route('tjsl.store') }}" id="tambahProgramModal">
            @slot('slotHeader')
                <h5 class="modal-title" id="exampleModalLabel">Tambah Program</h5>
            @endslot

            @slot('slotBody')
                <div class="alert alert-success mt-2" style="display: none" role="alert" id="alertWilayahModal">
                </div>
                <div class="mb-3">
                    <x-forms.input label="Nama program" name="nama" isRequired="false"
                        placeholder="Masukkan Nama program" />
                </div>
                <div class="mb-3">
                    <x-forms.select2 label="Wilayah" name="wilayah_select">
                        @foreach ($wilayah as $item)
                            <option value={{ $item->id }}>{{ $item->alamat }}, {{ $item->kelurahan }},
                                {{ $item->kecamatan }} </option>
                        @endforeach
                    </x-forms.select2>
                </div>
                <div class="mb-3">
                    <x-forms.select label="Lembaga" name="lembaga_select" placeholder="Masukkan Lembaga Pemohon">
                        @foreach ($lembaga as $item)
                            <option value={{ $item->id }}>{{ $item->nama_lembaga }}</option>
                        @endforeach
                    </x-forms.select>
                </div>
                <div class="mb-3">
                    <x-forms.input label="Anggaran" name="anggaran" placeholder="Masukkan Anggaran" />
                </div>
                <div class="mb-3">
                    <x-forms.input label="PIC" name="pic" placeholder="Masukkan PIC" />
                </div>
                <div class="mb-3">
                    <x-forms.input label="No HP PIC" name="contact" placeholder="Masukkan No HP PIC" />
                </div>
                <div class="mb-3">
                    <x-forms.date label="Tanggal" name="tanggal" placeholder="Pilih Tanggal" />
                </div>
                <div class="mb-3">
                    <x-forms.select label="Jenis" name="jenis" placeholder="Masukkan Jenis Program">
                        <option value="sponsorship">Sponsorship</option>
                        <option value="terprogram">Tjsl Terprogram</option>
                        <option value="tidak terprogram">Tjsl Tidak Terprogram</option>
                        </x-forms.select2>
                </div>
            @endslot

            @slot('slotFooter')
                <button type="submit" class="btn btn-primary btn-tutup-modal">Simpan</button>
            @endslot
        </x-modals.admin>

        <x-modals.admin id="editModal" action="{{ route('tjsl') }}" isUpdate=true>
            @slot('slotHeader')
                <h5 class="modal-title" id="editModalLabel">Edit Program</h5>
            @endslot

            @slot('slotBody')
                <div class="alert alert-success mt-2" style="display: none" role="alert" id="alertWilayahModal">
                </div>
                <div class="mb-3">
                    <x-forms.input label="Nama program" name="edtNamaProgram" placeholder="Masukkan Nama program" />
                </div>
                <div class="mb-3">
                    <x-forms.select2 label="Wilayah" name="edt_wilayah_select">
                        @foreach ($wilayah as $item)
                            <option value={{ $item->id }}>{{ $item->alamat }}, {{ $item->kelurahan }},
                                {{ $item->kecamatan }} </option>
                        @endforeach
                    </x-forms.select2>
                </div>
                <div class="mb-3">
                    <x-forms.select2 label="Lembaga" name="edt_lembaga_select">
                        @foreach ($lembaga as $item)
                            <option value={{ $item->id }}>{{ $item->nama_lembaga }} </option>
                        @endforeach
                    </x-forms.select2>
                </div>
                <div class="mb-3">
                    <x-forms.input label="Anggaran" name="edtAnggaran" placeholder="Masukkan Anggaran" />
                </div>
                <div class="mb-3">
                    <x-forms.input label="PIC" name="edtPic" placeholder="Masukkan PIC" />
                </div>
                <div class="mb-3">
                    <x-forms.input label="No HP PIC" name="edtContact" placeholder="Masukkan No HP PIC" />
                </div>
                <div class="mb-3">
                    <x-forms.date label="Tanggal" name="edtTanggal" placeholder="Pilih Tanggal" />
                </div>
                <div class="mb-3">
                    <x-forms.select label="Jenis" name="edtJenis" placeholder="Masukkan Jenis Program">
                        <option value="sponsorship">Sponsorship</option>
                        <option value="terprogram">Tjsl Terprogram</option>
                        <option value="tidak terprogram">Tjsl Tidak Terprogram</option>
                        </x-forms.select2>
                </div>
            @endslot

            @slot('slotFooter')
                <button type="submit" class="btn btn-primary btn-tutup-modal">Simpan</button>
            @endslot
        </x-modals.admin>

        <x-layout.wilayah modal="#tambahProgramModal" />
    @endif

@endsection

@section('scripts')
    <script type='text/javascript'
        src='https://www.bing.com/api/maps/mapcontrol?callback=GetMap&key={{ env('BING_API_KEY') }}' async defer></script>
    <script src="{{ asset('assets/user/js/maps.js') }}"></script>
    <script>
        dataTable(6)
        select2wilayah("wilayah_select", "tambahProgramModal")
        select2wilayah("edt_wilayah_select", "editModal")
        select2lembaga("lembaga-select", "exampleModal")
        select2lembaga("edt-lembaga-select", "editModal")

        currencyInInput("#anggaran")
        currencyInInput("#edtAnggaran")

        document.addEventListener("DOMContentLoaded", function() {
            Echo.channel('channel-wilayah')
                .listen('WilayahEvent', (e) => {
                    var data = e.data;

                    var value = data.id
                    var text = data.alamat + ", " + data.kelurahan + ", " + data.kecamatan
                    addDataToSelect2([{
                        value: value,
                        text: text
                    }], '#wilayah_select')

                    addDataToSelect2([{
                        value: value,
                        text: text
                    }], '#edt_wilayah_select')
                });
        })
    </script>
@endsection
