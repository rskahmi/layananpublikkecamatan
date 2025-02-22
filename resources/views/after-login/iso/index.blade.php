@extends('layout.user')

@section('title', 'Tata Kerja Organisasi')

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
                    <h4>Data Tata Kerja Organisasi</h4>
                </div>
                <div class="col-12 col-sm-12 col-md-7 d-flex justify-content-start justify-content-md-end gap-2">
                <x-search />
                @if (isAllAdmin())
                    <button class="btn btn-primary text-capitalize" data-bs-toggle="modal" data-bs-target="#tambahISO">
                        <x-svg.icon.addfile />
                        Tambah TKO
                    </button>
                @endif
            </div>
        </div>
    </div>
    <div class="card-body">
        <x-table>
            @slot('slotHeading')
            <tr>
                <th scope="col">NAMA</th>
                <th scope="col">JENIS</th>
                <th scope="col">Tanggal Aktif</th>
                <th scope="col">MASA BERLAKU</th>
                <th scope="col">TANGGAL BERAKHIR</th>
                <th scope="col">STATUS</th>
                @if (isAdmin())
                    <th scope="col" class="text-center">AKSI</th>
                @endif
            </tr>
            @endslot

            @slot('slotBody')
            @foreach ($iso as $item)
            <tr>
                    <td class="w-35">
                        <h5>{{ $item->nama }}</h5>
                        <span>{{ format_dfy($item->created_at) }}</span>
                    </td>
                    <td>
                        {{ $item->jenis }}
                    </td>
                    <td>
                        {{ format_dfy($item->tgl_aktif) }}
                    </td>
                    <td>
                        {{ $item->masa_berlaku }} Tahun
                    </td>
                    <td>
                        {{ format_dfy($item->tgl_berakhir) }}
                    </td>
                    <td>
                        <span class="badge {{ (strtolower($item->status) == 'aktif' ? 'bg-success' : (strtolower($item->status) == 'tidak aktif' ? 'bg-danger' : 'bg-warning' )) }}">{{ $item->status }}</span>
                    </td>
                    @if (isAdmin())
                        <td>
                            <div class="aksi">
                                <a href="##edit" id="edit"
                                    onclick="modalEditIso(`{{route('iso.update', ['id' => $item->id])}}`, `{{$item->nama}}`, `{{$item->jenis}}`, `{{$item->tgl_aktif}}`, `{{$item->masa_berlaku}}`)">
                                    <x-svg.icon.edit/>
                                </a>
                                <x-layout.delete action="{{ route('iso.destroy', ['id' => $item->id]) }}" />
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
    <x-modals.admin action="{{ route('iso.store')}}" id="tambahISO">

        @slot('slotHeader')
            <h5 class="modal-title" id="exampleModalLabel">Tambah ISO</h5>
        @endslot

        @slot('slotBody')
            <div class="mb-3">
                <x-forms.input
                    label="Nama"
                    name="nama"
                    placeholder="Masukkan Nama ISO"
                />
            </div>
            <div class="mb-3">
                <x-forms.input
                    label="Jenis"
                    name="jenis"
                    placeholder="Masukkan Jenis ISO"
                />
            </div>
            <div class="mb-3">
                <x-forms.date
                    label="Tanggal Aktif"
                    name="tgl_aktif"
                    placeholder="Masukkan Tanggal Aktif ISO"
                />
            </div>
            <div class="mb-3">
                <x-forms.input
                    label="Masa Berlaku"
                    name="masa_berlaku"
                    type="number"
                    placeholder="Masukkan Masa Berlaku ISO"
                />
            </div>
        @endslot

        @slot('slotFooter')
            <button type="submit" class="btn btn-primary btn-tutup-modal">Simpan</button>
        @endslot
    </x-modals.admin>

    <x-modals.admin id="editISO" action="{{ route('iso') }}" isUpdate=true>
        @slot('slotHeader')
            <h5 class="modal-title" id="editISOLabel">Edit Program</h5>
        @endslot

        @slot('slotBody')
            <div class="mb-3">
                <x-forms.input
                    label="Nama"
                    name="edtNama"
                    placeholder="Masukkan Nama ISO"
                />
            </div>
            <div class="mb-3">
                <x-forms.input
                    label="Jenis"
                    name="edtJenis"
                    placeholder="Masukkan Jenis ISO"
                />
            </div>
            <div class="mb-3">
                <x-forms.date
                    label="Tanggal Aktif"
                    name="edtTglAktif"
                    placeholder="Masukkan Tanggal Aktif ISO"
                />
            </div>
            <div class="mb-3">
                <x-forms.input
                    label="Masa Berlaku"
                    name="edtMasaBerlaku"
                    type="number"
                    placeholder="Masukkan Masa Berlaku ISO"
                />
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
        dataTable(10)
    </script>
@endsection
