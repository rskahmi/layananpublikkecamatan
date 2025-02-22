@extends('layout.user')

@section('title', 'Dashboard Program')
@section('content')
    <x-svg.fitur.tjsl />
    <div class="row">
        <div class="col-2 col-12 col-sm-6 col-md-6 col-lg-3 col-xl-3 col-xxl-2 mb-2 mb-lg-0">
            <x-card.summary header="Jumlah Terprogram" value="{{ formatRibuan($total_terprogram) }}" id="jumlahTerprogram">
                <x-svg.icon.program />
            </x-card.summary>
        </div>
        <div class="col-2 col-12 col-sm-6 col-md-6 col-lg-3 col-xl-3 col-xxl-2 mb-2 mb-lg-0">
            <x-card.summary header="Jumlah Tidak Terprogram" color="blue" value="{{ formatRibuan($total_tidak_terprogram) }}"
                id="jumlahTidakTerprogram">
                <x-svg.icon.unprogram />
            </x-card.summary>
        </div>
        <div class="col-2 col-12 col-sm-6 col-md-6 col-lg-3 col-xl-3 col-xxl-2 mb-2 mb-lg-0">
            <x-card.summary header="Jumlah Sponsorship" color="yellow" value="{{ formatRibuan($total_sponsorship) }}"
                id="jumlahSponsorship">
                <x-svg.icon.program-yellow />
            </x-card.summary>
        </div>
        <div class="col-2 col-12 col-sm-6 col-md-6 col-lg-3 col-xl-3 col-xxl-2 mb-2 mb-lg-0">
            <x-card.summary header="Total Anggaran Terpakai" color="red"
                value="{{ formatRupiah($total_anggaran_terpakai) }}" id="totalAnggaran" footer="dari Anggaran di tahun ini">
                <x-svg.icon.currency />
            </x-card.summary>
        </div>
        <div class="col-2 col-12 col-sm-6 col-md-6 col-lg-3 col-xl-3 col-xxl-2 mb-2 mb-lg-0">
            <x-card.summary header="Total Sisa Anggaran" color="red" value="{{ formatRupiah($total_anggaran_bersisa) }}"
                id="totalSisaAnggaran" footer="dari Anggaran di tahun ini">
                <x-svg.icon.currency />
            </x-card.summary>
        </div>
    </div>
    <div class="row mt-2 mt-lg-3">
        <div class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-6 col-xxl-6 mb-2 mt-lg-0">
            <div class="col-12 charts">
                <h4>Chart Pengajuan</h4>
                <div class="container-fluid">
                    <canvas id="barChart"></canvas>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-6 col-xxl-6 mb-2 mt-lg-0">
            <div class="col-12 charts">
                <h4>Total Anggaran</h4>
                <div class="container-fluid">
                    <canvas id="anggaranChart"></canvas>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>
    <script>
        const labels = @json($labels);
        const datax = @json($datax);

        const labels2 = @json($labels2);
        const datax2 = @json($datax2);



        anggaranChart(labels2, datax2, 1000000)
        barChart(labels, datax)

        document.addEventListener('DOMContentLoaded', function() {
            Echo.channel('channel-dashboard-tjsl')
                .listen('DashboardTjslEvent', (e) => {
                    var tjsl = e.data

                    if (tjsl.terprogram === "terprogram") {
                        setSummary("#jumlahTerprogram")
                    } else {
                        setSummary("#jumlahTidakTerprogram")
                    }
                    setAnggaranSummary("#totalAnggaran", tjsl.anggaran)

                });
        });
    </script>
@endsection
