@extends('layout.user')

@section('title', 'Anggaran Program')

@section('headers')
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
@endsection

@section('content')
    <x-svg.fitur.tjsl />

    <div class="animate__animated animate__fadeInUp">
        <div class="row">
            <div class="col-2 col-12 col-sm-6 col-md-6 col-lg-3 col-xl-3 col-xxl-2 mt-2 mt-md-1 mt-lg-0 mt-xl-0 mt-xxl-0">
                <x-card.summary header="Jumlah Pengeluaran" color="green" value="{{ formatRupiah($total_riwayat_thn_ini) }}"
                    footer="dari Anggaran di tahun ini">
                    <x-svg.icon.income />
                </x-card.summary>
            </div>
        </div>
    </div>

    <div class="card table mt-5">
        <div class="card-header">
            <div class="row align-items-center">
                <div class="col-6">
                    <h4>Riwayat Anggaran Program Program</h4>
                </div>
                <div class="col-6 d-flex justify-content-end gap-2">
                    <div class="search d-flex">
                        <input id="searchInput" type="text" class="search-input" placeholder="Search" autocomplete="off">
                        <span id="searchButton" class="btn btn-secondary">
                            <x-svg.icon.search />
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <x-table>

                @slot('slotHeading')
                    <tr>
                        <th scope="col">NAMA PROGRAM</th>
                        <th scope="col">TUJUAN ANGGARAN</th>
                        <th scope="col">NOMINAL</th>
                        <th scope="col">SISA ANGGARAN</th>
                        <th scope="COL">JENIS</th>
                    </tr>
                @endslot
                @slot('slotBody')
                    @foreach ($anggaran as $item)
                        <tr>
                            <td>
                                {{ $item->tjsl->nama }}
                            </td>
                            <td>
                                <h5>{{ $item->tujuan }}</h5>
                                <span>{{ format_dfy($item->tanggal) }}</span>
                            </td>
                            <td>
                                {{ formatRupiah($item->nominal) }}
                            </td>
                            <td>
                                {{ formatRupiah($item->sisa_anggaran) }}
                            </td>
                            <td>
                                {{ $item->tjsl->jenis }}
                            </td>
                        </tr>
                    @endforeach
                @endslot
            </x-table>
        </div>
    </div>

    <x-pagination />
    </div>
@endsection

@section('scripts')
    <script>
        dataTable(10)
    </script>
@endsection
