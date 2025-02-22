@extends('layout.user')

@section('title', 'Monitoring PUMK')

@section('headers')
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
@endsection

@section('content')
<x-svg.fitur.pumk />

<div class="animate__animated animate__fadeInUp">
    <div class="card table">
        <div class="card-header">
            <div class="row align-items-center">
                <div class="col-12 col-sm-12 col-md-5">
                    <h4>Aksi Pengajuan</h4>
                </div>
                <div class="col-12 col-sm-12 col-md-7 d-flex justify-content-start justify-content-md-end gap-2">
                    <x-search />
                    @if (isAllAdmin())
                        <button class="btn btn-primary text-capitalize" data-bs-toggle="modal" data-bs-target="#tambahModal">
                            <x-svg.icon.addfile />
                            Tambah PUMK
                        </button>
                    @endif
                </div>
            </div>
        </div>
        <div class="card-body">
            <x-table>
                @slot('slotHeading')
                <tr>
                    <th scope="col" class="w-25">NAMA USAHA</th>
                    <th scope="col" class="w-15">NAMA PENGUSAHA</th>
                    <th scope="col">AGUNAN</th>
                    <th scope="col">ANGGARAN</th>
                    <th scope="col">JATUH TEMPO</th>
                    <th scope="col">STATUS</th>
                    @if (isAllAdmin())
                        <th scope="col" class="text-center">AKSI</th>
                    @endif
                </tr>
                @endslot

            @slot('slotBody')

            @foreach ($pumk as $item)
            <tr>
                <td class="w-25">
                    <h5><b>{{ $item->nama_usaha }}</b></h5>
                    <span>{{ $item->wilayah->alamat }}, {{ $item->wilayah->kelurahan }}, {{ $item->wilayah->kecamatan }}</span>
                </td>
                <td class="w-20">
                    <h5><b>{{ $item->nama_pengusaha }}</b></h5>
                    <span>
                        <a target="_blank" href="https://wa.me/{{ checkNumber($item->contact) }}" class="text-decoration-underline">{{ checkNumber($item->contact) }}</a>
                    </span>
                </td>
                <td>
                    {{ $item->agunan }}
                </td>
                <td>
                    {{ formatRupiah($item->anggaran) }}
                </td>
                <td>
                    <span>{{ format_dfy($item->jatuh_tempo) }}</span>
                </td>
                <td>
                    <span class="badge text-capitalize {{ strtolower($item->status) === 'lunas' ? 'bg-success' : 'bg-warning' }}">{{ $item->status }}</span>

                </td>
                @if (isAllAdmin())
                    <td>
                        <div class="aksi">
                            <a href="##edit" id="edit" onclick="modalEditPumk(
                                `{{ route('pumk.update',
                                ['id' => $item->id]) }}`,
                                '{{$item->nama_usaha}}',
                                '{{$item->contact}}',
                                '{{$item->nama_pengusaha}}',
                                '{{$item->agunan}}',
                                '{{$item->tanggal}}',
                                '{{$item->jatuh_tempo}}',
                                '{{ $item->wilayah->id }}',
                                '{{$item->lembaga->id}}',
                                '{{ $item->anggaran }}')">
                                <x-svg.icon.edit/>
                            </a>

                            <a href="{{ route('pumk.detail', ['id' => $item->id]) }}">
                                <x-svg.icon.info />
                            </a>
                            <x-layout.delete action="{{ route('pumk.destroy', ['id' => $item->id]) }}" />
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
    <x-modals.admin action="{{route('pumk.store')}}" id="tambahModal">
        @slot('slotHeader')
        <h5 class="modal-title" id="editModalLabel">Tambah PUMK</h5>
        @endslot

        @slot('slotBody')
            <div class="alert alert-success mt-2" style="display: none" role="alert" id="alertWilayahModal">
            </div>
            <div class="alert alert-success mt-2" style="display: none" role="alert" id="alertWilayahModal">
            </div>
            <div class="mb-3">
                <x-forms.input
                    label="Nama Usaha"
                    name="nama_usaha"
                    placeholder="Masukkan Nama Usaha"
                />
            </div>
            <div class="mb-3">
                <x-forms.input
                    label="Nama Pengusaha"
                    name="nama_pengusaha"
                    placeholder="Masukkan Nama Pengusaha"
                />
            </div>
            <div class="mb-3">
                <x-forms.input
                    label="No HP Pengusaha"
                    name="contact"
                    placeholder="Masukkan No HP Pengusaha"
                />
            </div>
            <div class="mb-3">
                <x-forms.input
                    label="Jumlah Anggaran"
                    name="anggaran"
                    placeholder="Masukkan Jumlah Anggaran"
                />
            </div>
            <div class="mb-3">
                <x-forms.input
                    label="Agunan"
                    name="agunan"
                    placeholder="Masukkan Agunan"
                />
            </div>
            <div class="mb-3">
                <x-forms.date
                    label="Tanggal"
                    name="tanggal"
                    placeholder="Pilih Tanggal"
                />
            </div>
            <div class="mb-3">
                <x-forms.date
                    label="Jatuh Tempo"
                    name="jatuh_tempo"
                    placeholder="Pilih Jatuh Tempo"
                />
            </div>
            <div class="mb-3">
                <x-forms.select2
                    label="Wilayah"
                    name="wilayah_select"
                >
                @foreach ($wilayah as $item )
                    <option value={{ $item->id }}>{{$item->alamat}}, {{ $item->kelurahan }}, {{ $item->kecamatan }} </option>
                @endforeach
                </x-forms.select2>
            </div>
            <div class="mb-3">
                <x-forms.select2
                    label="Lembaga"
                    name="lembaga_select"
                    placeholder="Pilih Lembaga Pemohon"
                >
                @foreach ($lembaga as $item )
                    <option value={{ $item->id }}>{{$item->nama_lembaga}} </option>
                @endforeach
                </x-forms.select2>
            </div>
        @endslot

        @slot('slotFooter')
            <button type="submit" class="btn btn-primary btn-tutup-modal">Simpan</button>
        @endslot
    </x-modals.admin>

    <x-modals.admin id="editModal" action="{{ route('pumk') }}" isUpdate=true>
        <div class="alert alert-danger mt-2" style="display: none" role="alert" id="alertWilayahModal">
        </div>
        @slot('slotHeader')
            <h5 class="modal-title" id="exampleModalLabel">Edit PUMK</h5>
        @endslot

        @slot('slotBody')
            <div class="alert alert-success mt-2" style="display: none" role="alert" id="alertWilayahModal">
            </div>
            <div class="mb-3">
                <x-forms.input
                    label="Nama Usaha"
                    name="edtNama"
                    placeholder="Masukkan Nama Usaha"
                />
            </div>
            <div class="mb-3">
                <x-forms.input
                    label="Nama Pengusaha"
                    name="edtUsaha"
                    placeholder="Masukkan Nama Pengusaha"
                />
            </div>
            <div class="mb-3">
                <x-forms.input
                    label="No HP Pengusaha"
                    name="edtContact"
                    placeholder="Masukkan No HP Pengusaha"
                />
            </div>
            <div class="mb-3">
                <x-forms.input
                    label="Jumlah Anggaran"
                    name="edtAnggaran"
                    placeholder="Masukkan Jumlah Anggaran"
                />
            </div>
            {{-- <div class="mb-3">
                <x-forms.input
                    label="Agunan"
                    name="edtAgunan"
                    placeholder="Masukkan Agunan"
                />
            </div> --}}
            <div class="mb-3">
                <x-forms.date
                    label="Tanggal"
                    name="edtTanggal"
                    placeholder="Pilih Tanggal"
                />
            </div>
            <div class="mb-3">
                <x-forms.date
                    label="Jatuh Tempo"
                    name="edtTempo"
                    placeholder="Pilih Jatuh Tempo"
                />
            </div>
            <div class="mb-3">
                <x-forms.select2
                    label="Wilayah"
                    name="edt_wilayah_select"
                >
                @foreach ($wilayah as $item )
                    <option value={{ $item->id }}>{{$item->alamat}}, {{ $item->kelurahan }}, {{ $item->kecamatan }} </option>
                @endforeach
                </x-forms.select2>
            </div>
            <div class="mb-3">
                <x-forms.select2
                    label="Lembaga"
                    name="edt_lembaga_select"
                >
                @foreach ($lembaga as $item )
                    <option value={{ $item->id }}>{{$item->nama_lembaga}} </option>
                @endforeach
                </x-forms.select2>
            </div>
        @endslot

        @slot('slotFooter')
            <button type="submit" class="btn btn-primary btn-tutup-modal">Simpan</button>
        @endslot
    </x-modals.admin>

    <x-layout.wilayah modal="#tambahModal"/>
@endif

@endsection
@section('scripts')
    <script type='text/javascript'
    src='https://www.bing.com/api/maps/mapcontrol?callback=GetMap&key={{ env('BING_API_KEY') }}' async defer></script>
    <script src="{{ asset('assets/user/js/maps.js') }}"></script>
    <script>
        select2wilayah("wilayah_select", "tambahModal")
        select2wilayah("edt_wilayah_select", "editModal")
        select2lembaga("lembaga_select", "tambahModal")
        select2lembaga("edt_lembaga_select", "editModal")

        dataTable(5)

        $("#anggaran").on('input', function (event) {
            var value = event.target.value;

            event.target.value = formatInputCurrency(value)
        })

        $("#edtAnggaran").on('input', function (event) {
            var value = event.target.value;

            event.target.value = formatInputCurrency(value)
        })

        document.addEventListener("DOMContentLoaded", function () {
            Echo.channel('channel-wilayah')
                .listen('WilayahEvent', (e) => {
                    var data = e.data;

                    var value = data.id
                    var text = data.alamat + ", " + data.kelurahan + ", " + data.kecamatan
                    addDataToSelect2([
                        {
                            value: value,
                            text: text
                        }
                    ], '#wilayah_select')

                    addDataToSelect2([
                        {
                            value: value,
                            text: text
                        }
                    ], '#edt_wilayah_select')
                });
        })
    </script>
@endsection
