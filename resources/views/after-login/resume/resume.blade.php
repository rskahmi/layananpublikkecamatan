@extends('layout.user')

@section('headers')
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
@endsection

@section('title', 'Resume')
@section('content')
    <x-svg.fitur.berkas />
    {{-- NPP --}}
    <div class="row">
        <div class="col-5 col-12 col-sm-12 col-md-12 col-lg-5 col-xxl-5 mb-2 mb-lg-0">
            <div class="charts">
                <h4>Persentase Jenis UMD & Reimburstment</h4>
                <div class="container-fluid">
                    <canvas id="tjslPieChart" height="211" width="211"></canvas>
                    <div class="label d-flex justify-content-center mt-3">
                        <span>
                            <span class="icon positif"></span>&nbsp; Reimburstment
                        </span>
                        <span>
                            <span class="icon netral"></span>&nbsp; UMD
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-xxl-5">
            <div class="row">
                <div class="col-12 col-md-4 col-lg-6 col-x mb-2">
                    <x-card.summary header="Jumlah NPP UMD Masuk" color="blue"
                    value="{{formatRibuan($total_umd)}}" id="totalProposal"
                    footer="dari Pengajuan di tahun ini">
                    <x-svg.icon.signin />
                    </x-card.summary>
                </div>
                <div class="col-12 col-md-4 col-lg-6 col-x mb-2">
                    <x-card.summary header="Jumlah NPP Reim Masuk" color="blue"
                    value="{{formatRibuan($total_reim)}}" id="totalProposal"
                    footer="dari Pengajuan di tahun ini">
                    <x-svg.icon.signin />
                    </x-card.summary>
                </div>
                <div class="col-12 col-md-4 col-lg-6 col-x mb-2">
                    <x-card.summary header="Jumlah NPP UMD Proses" color="yellow"
                        value="{{formatRibuan($jumlah_status_proses_umd)}}" id="totalPengajuanProses"
                        footer="dari Pengajuan di tahun ini">
                        <x-svg.icon.program-yellow />
                    </x-card.summary>
                </div>
                <div class="col-12 col-md-4 col-lg-6 col-x mb-2">
                    <x-card.summary header="Jumlah NPP Reim Proses" color="yellow"
                        value="{{formatRibuan($jumlah_status_proses_reim)}}" id="totalPengajuanProses"
                        footer="dari Pengajuan di tahun ini">
                        <x-svg.icon.program-yellow />
                    </x-card.summary>
                </div>
                <div class="col-12 col-md-4 col-lg-6 col-x mb-2">
                    <x-card.summary header="Jumlah NPP UMD Selesai" color="green"
                        value="{{formatRibuan($jumlah_status_terima_umd)}}" id="totalProposalBantu"
                        footer="dari Pengajuan di tahun ini">
                        <x-svg.icon.done />
                    </x-card.summary>
                </div>
                <div class="col-12 col-md-4 col-lg-6 col-x mb-2">
                    <x-card.summary header="Jumlah NPP Reim Selesai" color="green"
                        value="{{formatRibuan($jumlah_status_terima_reim)}}" id="totalProposalBantu"
                        footer="dari Pengajuan di tahun ini">
                        <x-svg.icon.done />
                    </x-card.summary>
                </div>
            </div>
        </div>
    </div>
        <div class="row mt-2">
            <div class="col-12">
                <div class="charts keuangan">
                    <div class="title">
                        <div class="row">
                            <div class="col-12 col-md-6 col-xl-5">
                                <h4>Grafik
                                    UMD & Reimburstment Secara Bulanan</h4>
                            </div>
                            <div class="col-12 col-md-6 col-xl-7">
                                <div class="label">
                                    <span>
                                        <span class="icon negatif"></span>&nbsp;UMD
                                    </span>

                                    <span>
                                        <span class="icon netral"></span>&nbsp;Reimburstment
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="container-fluid">
                        <canvas id="ChartNPP"></canvas>
                    </div>
                </div>
            </div>
        </div>



        <br>
        <br>


        {{-- RD --}}
        <div class="row">
            <div class="col-5 col-12 col-sm-12 col-md-12 col-lg-5 col-xxl-5 mb-2 mb-lg-0">
                <div class="charts">
                    <h4>Persentase Jenis Pengajuan, Penggantian dan Pengembalian</h4>
                    <div class="container-fluid">
                        <canvas id="rdPieChart" height="211" width="211"></canvas>
                        <div class="label d-flex justify-content-center mt-3">
                            <span>
                                <span class="icon positif"></span>&nbsp;  Penggantian
                            </span>
                            <span>
                                <span class="icon netral"></span>&nbsp; Pengajuan Baru
                            </span>
                            <span>
                                <span class="icon negatif"></span>&nbsp; Pengembalian
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-xxl-5">
                <div class="row">
                    <div class="col-12 col-md-4 col-lg-6 col-x mb-2">
                        <x-card.summary header="Jumlah Pengajuan Baru" color="blue"
                        value="{{formatRibuan($total_baru)}}" id="totalProposal"
                        footer="dari Pengajuan di tahun ini">
                        <x-svg.icon.signin />
                        </x-card.summary>
                    </div>
                    <div class="col-12 col-md-4 col-lg-6 col-x mb-2">
                        <x-card.summary header="Jumlah Pengajuan Penggantian" color="blue"
                        value="{{formatRibuan($total_ganti)}}" id="totalProposal"
                        footer="dari Pengajuan di tahun ini">
                        <x-svg.icon.signin />
                        </x-card.summary>
                    </div>
                    <div class="col-12 col-md-4 col-lg-6 col-x mb-2">
                        <x-card.summary header="Jumlah Pengajuan Penggantian" color="blue"
                        value="{{formatRibuan($total_kembalikan)}}" id="totalProposal"
                        footer="dari Pengajuan di tahun ini">
                        <x-svg.icon.signin />
                        </x-card.summary>
                    </div>

                    <div class="col-12 col-md-4 col-lg-6 col-x mb-2">
                        <x-card.summary header="Jumlah Pengajuan Baru Proses" color="yellow"
                            value="{{formatRibuan($jumlah_status_proses_baru)}}" id="totalPengajuanProses"
                            footer="dari Pengajuan di tahun ini">
                            <x-svg.icon.program-yellow />
                        </x-card.summary>
                    </div>
                    <div class="col-12 col-md-4 col-lg-6 col-x mb-2">
                        <x-card.summary header="Jumlah Pengajuan Baru Proses" color="yellow"
                            value="{{formatRibuan($jumlah_status_proses_ganti)}}" id="totalPengajuanProses"
                            footer="dari Pengajuan di tahun ini">
                            <x-svg.icon.program-yellow />
                        </x-card.summary>
                    </div>
                    <div class="col-12 col-md-4 col-lg-6 col-x mb-2">
                        <x-card.summary header="Jumlah Pengajuan Baru Proses" color="yellow"
                            value="{{formatRibuan($jumlah_status_proses_kembalikan)}}" id="totalPengajuanProses"
                            footer="dari Pengajuan di tahun ini">
                            <x-svg.icon.program-yellow />
                        </x-card.summary>
                    </div>
                    <div class="col-12 col-md-4 col-lg-6 col-x mb-2">
                        <x-card.summary header="Jumlah Pengajuan Baru Selesai" color="green"
                            value="{{formatRibuan($jumlah_status_terima_baru)}}" id="totalProposalBantu"
                            footer="dari Pengajuan di tahun ini">
                            <x-svg.icon.done />
                        </x-card.summary>
                    </div>
                    <div class="col-12 col-md-4 col-lg-6 col-x mb-2">
                        <x-card.summary header="Jumlah Penggantian Selesai" color="green"
                            value="{{formatRibuan($jumlah_status_terima_ganti)}}" id="totalProposalBantu"
                            footer="dari Pengajuan di tahun ini">
                            <x-svg.icon.done />
                        </x-card.summary>
                    </div>
                    <div class="col-12 col-md-4 col-lg-6 col-x mb-2">
                        <x-card.summary header="Jumlah Pengembalian Selesai" color="green"
                            value="{{formatRibuan($jumlah_status_terima_kembalikan)}}" id="totalProposalBantu"
                            footer="dari Pengajuan di tahun ini">
                            <x-svg.icon.done />
                        </x-card.summary>
                    </div>
                </div>
            </div>
        </div>
            <div class="row mt-2">
                <div class="col-12">
                    <div class="charts keuangan">
                        <div class="title">
                            <div class="row">
                                <div class="col-12 col-md-6 col-xl-5">
                                    <h4>Grafik
                                        Pengajuan, Penggantian dan Pengembalian Secara Bulanan</h4>
                                </div>
                                <div class="col-12 col-md-6 col-xl-7">
                                    <div class="label">
                                        <span>
                                            <span class="icon negatif"></span>&nbsp;Pengajuan Baru
                                        </span>

                                        <span>
                                            <span class="icon netral"></span>&nbsp;Penggantian
                                        </span>

                                        <span>
                                            <span class="icon positif"></span>&nbsp;Pengembalian
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="container-fluid">
                            <canvas id="ChartRD"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <br>
            <br>


         {{-- SPD --}}
         <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-7 col-xxl-7 mb-2 mb-lg-0">
                <div class="row">
                    <div class="col-12 col-sm-6 col-md-4 col-lg-4 col-xxl-4 mb-2">
                        <x-card.summary header="Jumlah SPD Masuk" color="blue"
                        value="{{formatRibuan($total_spd)}}" id="totalProposal"
                        footer="dari Pengajuan di tahun ini">
                        <x-svg.icon.signin />
                        </x-card.summary>
                    </div>
                    <div class="col-12 col-sm-6 col-md-4 col-lg-4 col-xxl-4 mb-2">
                        <x-card.summary header="Jumlah SPD Proses" color="yellow"
                            value="{{formatRibuan($jumlah_status_proses_spd)}}" id="totalPengajuanProses"
                            footer="dari Pengajuan di tahun ini">
                            <x-svg.icon.program-yellow />
                        </x-card.summary>
                    </div>
                    <div class="col-12 col-sm-6 col-md-4 col-lg-4 col-xxl-4 mb-2">
                        <x-card.summary header="Jumlah SPD Selesai" color="green"
                            value="{{formatRibuan($jumlah_status_selesai_spd)}}" id="totalProposalBantu"
                            footer="dari Pengajuan di tahun ini">
                            <x-svg.icon.done />
                        </x-card.summary>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="row mt-2">
                <div class="col-12">
                    <div class="charts keuangan">
                        <div class="title">
                            <div class="row">
                                <div class="col-12 col-md-6 col-xl-5">
                                    <h4>Grafik
                                        SPD Secara Bulanan</h4>
                                </div>
                                <div class="col-12 col-md-6 col-xl-7">
                                    <div class="label">
                                        <span>
                                            <span class="icon netral"></span>&nbsp;SPD
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="container-fluid">
                            <canvas id="SPDChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <br>
            <br>


         {{-- SIJ --}}
         <div class="row">
            <div class="col-5 col-12 col-sm-12 col-md-12 col-lg-5 col-xxl-5 mb-2 mb-lg-0">
                <div class="charts">
                    <h4>Persentase Jenis Melayat, Berobat, & Dinas</h4>
                    <div class="container-fluid">
                        <canvas id="SIJPieChart" height="211" width="211"></canvas>
                        <div class="label d-flex justify-content-center mt-3">
                            <span>
                                <span class="icon positif"></span>&nbsp; Berobat
                            </span>
                            <span>
                                <span class="icon netral"></span>&nbsp; Melayat
                            </span>
                            <span>
                                <span class="icon negatif"></span>&nbsp; Dinas
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-xxl-5">
                <div class="row">
                    <div class="col-12 col-md-4 col-lg-6 col-x mb-2">
                        <x-card.summary header="Jumlah Pengajuan Melayat" color="blue"
                        value="{{formatRibuan($total_melayat)}}" id="totalProposal"
                        footer="dari Pengajuan di tahun ini">
                        <x-svg.icon.signin />
                        </x-card.summary>
                    </div>
                    <div class="col-12 col-md-4 col-lg-6 col-x mb-2">
                        <x-card.summary header="Jumlah Pengajuan Sakit" color="blue"
                        value="{{formatRibuan($total_sakit)}}" id="totalProposal"
                        footer="dari Pengajuan di tahun ini">
                        <x-svg.icon.signin />
                        </x-card.summary>
                    </div>
                    <div class="col-12 col-md-4 col-lg-6 col-x mb-2">
                        <x-card.summary header="Jumlah Pengajuan Dinas" color="blue"
                        value="{{formatRibuan($total_dinas)}}" id="totalProposal"
                        footer="dari Pengajuan di tahun ini">
                        <x-svg.icon.signin />
                        </x-card.summary>
                    </div>

                    <div class="col-12 col-md-4 col-lg-6 col-x mb-2">
                        <x-card.summary header="Jumlah Pengajuan Melayat Proses" color="yellow"
                            value="{{formatRibuan($jumlah_status_proses_melayat)}}" id="totalPengajuanProses"
                            footer="dari Pengajuan di tahun ini">
                            <x-svg.icon.program-yellow />
                        </x-card.summary>
                    </div>
                    <div class="col-12 col-md-4 col-lg-6 col-x mb-2">
                        <x-card.summary header="Jumlah Pengajuan Sakit Proses" color="yellow"
                            value="{{formatRibuan($jumlah_status_proses_sakit)}}" id="totalPengajuanProses"
                            footer="dari Pengajuan di tahun ini">
                            <x-svg.icon.program-yellow />
                        </x-card.summary>
                    </div>
                    <div class="col-12 col-md-4 col-lg-6 col-x mb-2">
                        <x-card.summary header="Jumlah Pengajuan Dinas Proses" color="yellow"
                            value="{{formatRibuan($jumlah_status_proses_sakit)}}" id="totalPengajuanProses"
                            footer="dari Pengajuan di tahun ini">
                            <x-svg.icon.program-yellow />
                        </x-card.summary>
                    </div>
                    <div class="col-12 col-md-4 col-lg-6 col-x mb-2">
                        <x-card.summary header="Jumlah Pengajuan Melayat Selesai" color="green"
                            value="{{formatRibuan($jumlah_status_terima_melayat)}}" id="totalProposalBantu"
                            footer="dari Pengajuan di tahun ini">
                            <x-svg.icon.done />
                        </x-card.summary>
                    </div>
                    <div class="col-12 col-md-4 col-lg-6 col-x mb-2">
                        <x-card.summary header="Jumlah Pengajuan Berobat Selesai" color="green"
                            value="{{formatRibuan($jumlah_status_terima_sakit)}}" id="totalProposalBantu"
                            footer="dari Pengajuan di tahun ini">
                            <x-svg.icon.done />
                        </x-card.summary>
                    </div>
                    <div class="col-12 col-md-4 col-lg-6 col-x mb-2">
                        <x-card.summary header="Jumlah Pengajuan Dinas Selesai" color="green"
                            value="{{formatRibuan($jumlah_status_terima_dinas)}}" id="totalProposalBantu"
                            footer="dari Pengajuan di tahun ini">
                            <x-svg.icon.done />
                        </x-card.summary>
                    </div>
                </div>
            </div>
        </div>
            <div class="row mt-2">
                <div class="col-12">
                    <div class="charts keuangan">
                        <div class="title">
                            <div class="row">
                                <div class="col-12 col-md-6 col-xl-5">
                                    <h4>Grafik
                                        Melayat, Berobat & Dinas Secara Bulanan</h4>
                                </div>
                                <div class="col-12 col-md-6 col-xl-7">
                                    <div class="label">
                                        <span>
                                            <span class="icon negatif"></span>&nbsp;Melayat
                                        </span>

                                        <span>
                                            <span class="icon netral"></span>&nbsp;Berobat
                                        </span>

                                        <span>
                                            <span class="icon positif"></span>&nbsp;Dinas
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="container-fluid">
                            <canvas id="SIJChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <br>
            <br>


         {{-- SPDL --}}
         <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-7 col-xxl-7 mb-2 mb-lg-0">
                <div class="row">
                    <div class="col-12 col-sm-6 col-md-4 col-lg-4 col-xxl-4 mb-2">
                        <x-card.summary header="Jumlah SPDL Masuk" color="blue"
                        value="{{formatRibuan($total_spdl)}}" id="totalProposal"
                        footer="dari Pengajuan di tahun ini">
                        <x-svg.icon.signin />
                        </x-card.summary>
                    </div>
                    <div class="col-12 col-sm-6 col-md-4 col-lg-4 col-xxl-4 mb-2">
                        <x-card.summary header="Jumlah SPDL Proses" color="yellow"
                            value="{{formatRibuan($jumlah_status_proses_spdl)}}" id="totalPengajuanProses"
                            footer="dari Pengajuan di tahun ini">
                            <x-svg.icon.program-yellow />
                        </x-card.summary>
                    </div>
                    <div class="col-12 col-sm-6 col-md-4 col-lg-4 col-xxl-4 mb-2">
                        <x-card.summary header="Jumlah SPDL Selesai" color="green"
                            value="{{formatRibuan($jumlah_status_selesai_spdl)}}" id="totalProposalBantu"
                            footer="dari Pengajuan di tahun ini">
                            <x-svg.icon.done />
                        </x-card.summary>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="row mt-2">
                <div class="col-12">
                    <div class="charts keuangan">
                        <div class="title">
                            <div class="row">
                                <div class="col-12 col-md-6 col-xl-5">
                                    <h4>Grafik
                                        SPDL Secara Bulanan</h4>
                                </div>
                                <div class="col-12 col-md-6 col-xl-7">
                                    <div class="label">
                                        <span>
                                            <span class="icon netral"></span>&nbsp;SPDL
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="container-fluid">
                            <canvas id="SPDLChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <br>
            <br>


         {{-- Rotasi --}}
         <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-7 col-xxl-7 mb-2 mb-lg-0">
                <div class="row">
                    <div class="col-12 col-sm-6 col-md-4 col-lg-4 col-xxl-4 mb-2">
                        <x-card.summary header="Jumlah Pengajuan Rotasi Masuk" color="blue"
                        value="{{formatRibuan($total_rotasi)}}" id="totalProposal"
                        footer="dari Pengajuan di tahun ini">
                        <x-svg.icon.signin />
                        </x-card.summary>
                    </div>
                    <div class="col-12 col-sm-6 col-md-4 col-lg-4 col-xxl-4 mb-2">
                        <x-card.summary header="Jumlah Pengajuan Rotasi Proses" color="yellow"
                            value="{{formatRibuan($jumlah_status_proses_rotasi)}}" id="totalPengajuanProses"
                            footer="dari Pengajuan di tahun ini">
                            <x-svg.icon.program-yellow />
                        </x-card.summary>
                    </div>
                    <div class="col-12 col-sm-6 col-md-4 col-lg-4 col-xxl-4 mb-2">
                        <x-card.summary header="Jumlah Pengajuan Rotasi Selesai" color="green"
                            value="{{formatRibuan($jumlah_status_selesai_rotasi)}}" id="totalProposalBantu"
                            footer="dari Pengajuan di tahun ini">
                            <x-svg.icon.done />
                        </x-card.summary>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="row mt-2">
                <div class="col-12">
                    <div class="charts keuangan">
                        <div class="title">
                            <div class="row">
                                <div class="col-12 col-md-6 col-xl-5">
                                    <h4>Grafik
                                        Rotasi Secara Bulanan</h4>
                                </div>
                                <div class="col-12 col-md-6 col-xl-7">
                                    <div class="label">
                                        <span>
                                            <span class="icon netral"></span>&nbsp;Rotasi
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="container-fluid">
                            <canvas id="RotasiChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <br>
            <br>


         {{-- Mutasi --}}
         <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-7 col-xxl-7 mb-2 mb-lg-0">
                <div class="row">
                    <div class="col-12 col-sm-6 col-md-4 col-lg-4 col-xxl-4 mb-2">
                        <x-card.summary header="Jumlah Pengajuan Mutasi Masuk" color="blue"
                        value="{{formatRibuan($total_mutasi)}}" id="totalProposal"
                        footer="dari Pengajuan di tahun ini">
                        <x-svg.icon.signin />
                        </x-card.summary>
                    </div>
                    <div class="col-12 col-sm-6 col-md-4 col-lg-4 col-xxl-4 mb-2">
                        <x-card.summary header="Jumlah Pengajuan Mutasi Proses" color="yellow"
                            value="{{formatRibuan($jumlah_status_proses_mutasi)}}" id="totalPengajuanProses"
                            footer="dari Pengajuan di tahun ini">
                            <x-svg.icon.program-yellow />
                        </x-card.summary>
                    </div>
                    <div class="col-12 col-sm-6 col-md-4 col-lg-4 col-xxl-4 mb-2">
                        <x-card.summary header="Jumlah Pengajuan Mutasi Selesai" color="green"
                            value="{{formatRibuan($jumlah_status_selesai_mutasi)}}" id="totalProposalBantu"
                            footer="dari Pengajuan di tahun ini">
                            <x-svg.icon.done />
                        </x-card.summary>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="row mt-2">
                <div class="col-12">
                    <div class="charts keuangan">
                        <div class="title">
                            <div class="row">
                                <div class="col-12 col-md-6 col-xl-5">
                                    <h4>Grafik
                                        Mutasi Secara Bulanan</h4>
                                </div>
                                <div class="col-12 col-md-6 col-xl-7">
                                    <div class="label">
                                        <span>
                                            <span class="icon netral"></span>&nbsp;Mutasi
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="container-fluid">
                            <canvas id="MutasiChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <br>
            <br>


         {{-- Promosi --}}
         <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-7 col-xxl-7 mb-2 mb-lg-0">
                <div class="row">
                    <div class="col-12 col-sm-6 col-md-4 col-lg-4 col-xxl-4 mb-2">
                        <x-card.summary header="Jumlah Pengajuan Promosi Masuk" color="blue"
                        value="{{formatRibuan($total_promosi)}}" id="totalProposal"
                        footer="dari Pengajuan di tahun ini">
                        <x-svg.icon.signin />
                        </x-card.summary>
                    </div>
                    <div class="col-12 col-sm-6 col-md-4 col-lg-4 col-xxl-4 mb-2">
                        <x-card.summary header="Jumlah Pengajuan Promosi Proses" color="yellow"
                            value="{{formatRibuan($jumlah_status_proses_promosi)}}" id="totalPengajuanProses"
                            footer="dari Pengajuan di tahun ini">
                            <x-svg.icon.program-yellow />
                        </x-card.summary>
                    </div>
                    <div class="col-12 col-sm-6 col-md-4 col-lg-4 col-xxl-4 mb-2">
                        <x-card.summary header="Jumlah Pengajuan Promosi Selesai" color="green"
                            value="{{formatRibuan($jumlah_status_selesai_promosi)}}" id="totalProposalBantu"
                            footer="dari Pengajuan di tahun ini">
                            <x-svg.icon.done />
                        </x-card.summary>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="row mt-2">
                <div class="col-12">
                    <div class="charts keuangan">
                        <div class="title">
                            <div class="row">
                                <div class="col-12 col-md-6 col-xl-5">
                                    <h4>Grafik
                                        Promosi Secara Bulanan</h4>
                                </div>
                                <div class="col-12 col-md-6 col-xl-7">
                                    <div class="label">
                                        <span>
                                            <span class="icon netral"></span>&nbsp;Mutasi
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="container-fluid">
                            <canvas id="PromosiChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>





@endsection
@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/chartjs-plugin-datalabels/2.0.0/chartjs-plugin-datalabels.min.js">
    </script>

<script>

    // NPP
    var canvas = document.getElementById('ChartNPP');
    var ctx = canvas.getContext('2d');
    var dataUMD = []
    var dataReim = []

    @foreach ($grafik_umd as $item )
        dataUMD.push({{ $item['total_umd'] }})
    @endforeach

    @foreach ($grafik_reim as $item )
        dataReim.push({{ $item['total_reim'] }})
    @endforeach

    var data = {
        labels: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'],
        datasets: [{
                label: 'Jumlah UMD',
                data: dataUMD,
                borderColor: '#D12031',
                borderWidth: 5,
                fill: false,
                backgroundColor: '#D12031',
                tension: 0.5
        },
        {
                label: 'Jumlah Reimburstment',
                data: dataReim,
                borderColor: '#145EA8',
                borderWidth: 5,
                fill: false,
                backgroundColor: '#145EA8',
                tension: 0.5
        }
    ]
    };

    // Define chart options
    var options = {
            responsive: true,
            title: {
                display: true,
                text: 'Valleys and Peaks Line Chart'
            },
            scales: {
                x: {
                    grid: {
                        display: false,
                        drawBorder: false
                    }
                },
                y: {
                    grid: {
                        display: false,
                        drawBorder: false
                    }
                }
            },
            plugins: {
                legend: {
                    display: false
                }
            },
        };

        var lineChart = new Chart(ctx, {
            type: 'line',
            data: data,
            options: options
        });

    // pie chart
    const nppLabel = ["UMD", "Reimburstment"]
        const nppData = [{!! $total_umd !!}, {!! $total_reim !!}]
        console.log(nppData)


        pie("tjslPieChart", nppLabel, nppData)



        // RD
        var canvas = document.getElementById('ChartRD');
    var ctx = canvas.getContext('2d');
    var dataBaru = []
    var dataGanti = []
    var dataKembalikan = []

    @foreach ($grafik_baru as $item )
        dataBaru.push({{ $item['total_baru'] }})
    @endforeach

    @foreach ($grafik_ganti as $item )
        dataGanti.push({{ $item['total_ganti'] }})
    @endforeach

    @foreach ($grafik_kembalikan as $item )
        dataKembalikan.push({{ $item['total_kembalikan'] }})
    @endforeach

    var data = {
        labels: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'],
        datasets: [{
                label: 'Jumlah Pengajuan Baru',
                data: dataBaru,
                borderColor: '#D12031',
                borderWidth: 5,
                fill: false,
                backgroundColor: '#D12031',
                tension: 0.5
        },
        {
                label: 'Jumlah Penggantian',
                data: dataGanti,
                borderColor: '#145EA8',
                borderWidth: 5,
                fill: false,
                backgroundColor: '#145EA8',
                tension: 0.5
        },
        {
                label: 'Jumlah Pengembalian',
                data: dataKembalikan,
                borderColor: '#65AE38',
                borderWidth: 5,
                fill: false,
                backgroundColor: '#65AE38',
                tension: 0.5
        }
    ]
    };

    // Define chart options
    var options = {
            responsive: true,
            title: {
                display: true,
                text: 'Valleys and Peaks Line Chart'
            },
            scales: {
                x: {
                    grid: {
                        display: false,
                        drawBorder: false
                    }
                },
                y: {
                    grid: {
                        display: false,
                        drawBorder: false
                    }
                }
            },
            plugins: {
                legend: {
                    display: false
                }
            },
        };

        var lineChart = new Chart(ctx, {
            type: 'line',
            data: data,
            options: options
        });


        // pie chart
        const rdLabel = ["Pengajuan", "Penggantian", "Pengembalian" ]
        const rdData = [{!! $total_baru !!}, {!! $total_ganti !!}, {!! $total_kembalikan !!}]
        console.log(rdData)


        pie("rdPieChart", rdLabel, rdData)





        // SPD
        var canvas = document.getElementById('SPDChart');
    var ctx = canvas.getContext('2d');
    var dataSPD = []

    @foreach ($grafik_spd as $item )
        dataSPD.push({{ $item['total_spd'] }})
    @endforeach

    var data = {
        labels: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'],
        datasets: [{
                label: 'Jumlah SPD',
                data: dataSPD,
                borderColor: '#145EA8',
                borderWidth: 5,
                fill: false,
                backgroundColor: '#145EA8',
                tension: 0.5
        }
    ]
    };

    // Define chart options
    var options = {
            responsive: true,
            title: {
                display: true,
                text: 'Valleys and Peaks Line Chart'
            },
            scales: {
                x: {
                    grid: {
                        display: false,
                        drawBorder: false
                    }
                },
                y: {
                    grid: {
                        display: false,
                        drawBorder: false
                    }
                }
            },
            plugins: {
                legend: {
                    display: false
                }
            },
        };

        var lineChart = new Chart(ctx, {
            type: 'line',
            data: data,
            options: options
        });



// SIJ

var canvas = document.getElementById('SIJChart');
    var ctx = canvas.getContext('2d');
    var dataMelayat = []
    var dataSakit = []
    var dataDinas = []

    @foreach ($grafik_melayat as $item )
        dataMelayat.push({{ $item['total_melayat'] }})
    @endforeach

    @foreach ($grafik_sakit as $item )
        dataSakit.push({{ $item['total_sakit'] }})
    @endforeach

    @foreach ($grafik_dinas as $item )
        dataDinas.push({{ $item['total_dinas'] }})
    @endforeach

    var data = {
        labels: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'],
        datasets: [{
                label: 'Jumlah Melayat',
                data: dataMelayat,
                borderColor: '#D12031',
                borderWidth: 5,
                fill: false,
                backgroundColor: '#D12031',
                tension: 0.5
        },
        {
                label: 'Jumlah Sakit',
                data: dataSakit,
                borderColor: '#145EA8',
                borderWidth: 5,
                fill: false,
                backgroundColor: '#145EA8',
                tension: 0.5
        },
        {
                label: 'Jumlah Dinas',
                data: dataDinas,
                borderColor: '#65AE38',
                borderWidth: 5,
                fill: false,
                backgroundColor: '#65AE38',
                tension: 0.5
        }
    ]
    };

    // Define chart options
    var options = {
            responsive: true,
            title: {
                display: true,
                text: 'Valleys and Peaks Line Chart'
            },
            scales: {
                x: {
                    grid: {
                        display: false,
                        drawBorder: false
                    }
                },
                y: {
                    grid: {
                        display: false,
                        drawBorder: false
                    }
                }
            },
            plugins: {
                legend: {
                    display: false
                }
            },
        };

        var lineChart = new Chart(ctx, {
            type: 'line',
            data: data,
            options: options
        });


        // pie chart
        const sijLabel = ["Melayat", "Sakit", "Dinas" ]
        const sijData = [{!! $total_melayat !!}, {!! $total_sakit !!}, {!! $total_dinas !!}]
        console.log(sijData)


        pie("SIJPieChart", sijLabel, sijData)





        // SPDL

        var canvas = document.getElementById('SPDLChart');
    var ctx = canvas.getContext('2d');
    var dataSPDL = []

    @foreach ($grafik_spdl as $item )
        dataSPDL.push({{ $item['total_spdl'] }})
    @endforeach

    var data = {
        labels: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'],
        datasets: [{
                label: 'Jumlah SPDL',
                data: dataSPDL,
                borderColor: '#145EA8',
                borderWidth: 5,
                fill: false,
                backgroundColor: '#145EA8',
                tension: 0.5
        }
    ]
    };

    // Define chart options
    var options = {
            responsive: true,
            title: {
                display: true,
                text: 'Valleys and Peaks Line Chart'
            },
            scales: {
                x: {
                    grid: {
                        display: false,
                        drawBorder: false
                    }
                },
                y: {
                    grid: {
                        display: false,
                        drawBorder: false
                    }
                }
            },
            plugins: {
                legend: {
                    display: false
                }
            },
        };

        var lineChart = new Chart(ctx, {
            type: 'line',
            data: data,
            options: options
        });


        // ROtasi
        // grafik chart bulanan
    var canvas = document.getElementById('RotasiChart');
    var ctx = canvas.getContext('2d');
    var dataRotasi = []

    @foreach ($grafik_rotasi as $item )
        dataRotasi.push({{ $item['total_rotasi'] }})
    @endforeach

    var data = {
        labels: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'],
        datasets: [{
                label: 'Jumlah Rotasi',
                data: dataRotasi,
                borderColor: '#145EA8',
                borderWidth: 5,
                fill: false,
                backgroundColor: '#145EA8',
                tension: 0.5
        }
    ]
    };

    // Define chart options
    var options = {
            responsive: true,
            title: {
                display: true,
                text: 'Valleys and Peaks Line Chart'
            },
            scales: {
                x: {
                    grid: {
                        display: false,
                        drawBorder: false
                    }
                },
                y: {
                    grid: {
                        display: false,
                        drawBorder: false
                    }
                }
            },
            plugins: {
                legend: {
                    display: false
                }
            },
        };

        var lineChart = new Chart(ctx, {
            type: 'line',
            data: data,
            options: options
        });


        // Mutaos
        var canvas = document.getElementById('MutasiChart');
    var ctx = canvas.getContext('2d');
    var dataMutasi = []

    @foreach ($grafik_mutasi as $item )
        dataMutasi.push({{ $item['total_mutasi'] }})
    @endforeach

    var data = {
        labels: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'],
        datasets: [{
                label: 'Jumlah Mutasi',
                data: dataMutasi,
                borderColor: '#145EA8',
                borderWidth: 5,
                fill: false,
                backgroundColor: '#145EA8',
                tension: 0.5
        }
    ]
    };

    // Define chart options
    var options = {
            responsive: true,
            title: {
                display: true,
                text: 'Valleys and Peaks Line Chart'
            },
            scales: {
                x: {
                    grid: {
                        display: false,
                        drawBorder: false
                    }
                },
                y: {
                    grid: {
                        display: false,
                        drawBorder: false
                    }
                }
            },
            plugins: {
                legend: {
                    display: false
                }
            },
        };

        var lineChart = new Chart(ctx, {
            type: 'line',
            data: data,
            options: options
        });

        // Promosi
        var canvas = document.getElementById('PromosiChart');
    var ctx = canvas.getContext('2d');
    var dataPromosi = []

    @foreach ($grafik_promosi as $item )
        dataPromosi.push({{ $item['total_promosi'] }})
    @endforeach

    var data = {
        labels: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'],
        datasets: [{
                label: 'Jumlah Promosi',
                data: dataPromosi,
                borderColor: '#145EA8',
                borderWidth: 5,
                fill: false,
                backgroundColor: '#145EA8',
                tension: 0.5
        }
    ]
    };

    // Define chart options
    var options = {
            responsive: true,
            title: {
                display: true,
                text: 'Valleys and Peaks Line Chart'
            },
            scales: {
                x: {
                    grid: {
                        display: false,
                        drawBorder: false
                    }
                },
                y: {
                    grid: {
                        display: false,
                        drawBorder: false
                    }
                }
            },
            plugins: {
                legend: {
                    display: false
                }
            },
        };

        var lineChart = new Chart(ctx, {
            type: 'line',
            data: data,
            options: options
        });


    document.addEventListener('DOMContentLoaded', function() {
        Echo.channel('channel-dashboard-berkas')
            .listen('DashboardBerkasEvent', (e) => {
                var berkas = e.data
                if (tjsl.hasOwnProperty('deleted_at')) {
                    unsetSummary("#totalProposal")
                    unsetSummary("#totalSurat")
                    unsetSummary("#totalUndangan")
                    unsetSummary("#totalProposalProses");
                    unsetSummary("#totalProposalVerifikasi");
                    unsetSummary("#totalProposalTolak");
                    unsetSummary("#totalAnggaranBantu");
                    unsetSummary("#totalStakeholderBantu");
                    unsetSummary("#totalBerkas");
                } else {
                    setSummary("#totalProposal")
                    setSummary("#totalSurat")
                    setSummary("#totalUndangan")
                    setSummary("#totalProposalProses");
                    setSummary("#totalProposalVerifikasi");
                    setSummary("#totalProposalTolak");
                    setSummary("#totalAnggaranBantu");
                    setSummary("#totalStakeholderBantu");
                    setSummary("#totalBerkas");
                }
            })
    })
</script>

    @endsection
