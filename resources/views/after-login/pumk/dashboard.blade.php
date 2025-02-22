@extends('layout.user')

@section('title', 'Dashboard PUMK')
@section('content')
    <x-svg.fitur.pumk />

    <div class="row">
        <div class="col-2 col-12 col-sm-6 col-md-6 col-lg-3 col-xl-3 col-xxl-2 mb-2 mb-lg-0">
            <x-card.summary header="Jumlah Program" value="{{ formatRibuan($total_pumk) }}" id="totalPumk">
                <x-svg.icon.computer />
            </x-card.summary>
        </div>
        <div class="col-2 col-12 col-sm-6 col-md-6 col-lg-3 col-xl-3 col-xxl-2 mb-2 mb-lg-0">
            <x-card.summary header="Jumlah Program Lancar" color="blue" value="{{ formatRibuan($jumlah_program_lancar) }}">
                <x-svg.icon.programBlue />
            </x-card.summary>
        </div>
        <div class="col-2 col-12 col-sm-6 col-md-6 col-lg-3 col-xl-3 col-xxl-2 mb-2 mb-lg-0">
            <x-card.summary header="Jumlah Program Tidak Lancar" color="red" value="{{ formatRibuan($jumlah_program_tidak_lancar) }}"
                footer="dari Anggaran di tahun ini" id="totalPumkTidakLancar">
                <x-svg.icon.unprogramred />
            </x-card.summary>
        </div>
        <div class="col-2 col-12 col-sm-6 col-md-6 col-lg-3 col-xl-3 col-xxl-2 mb-2 mb-lg-0">
            <x-card.summary header="Total Anggaran" color="yellow" value="{{ formatRupiah($total_anggaran) }}" id="totalAnggaran">
                <x-svg.icon.currencyYellow />
            </x-card.summary>
        </div>
    </div>

    <div class="row mt-2 mt-lg-3">
        <div class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-6 col-xxl-6 mb-2 mb-lg-0">
            <div class="col-12 charts">
                <h4>Chart Pengajuan</h4>
                <div class="container-fluid">
                    <canvas id="barChart"></canvas>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-6 col-xxl-6 mb-2 mb-lg-0">
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

        anggaranChart(labels2, datax2, 5000000)
        barChart(labels, datax)

        console.log($("#totalAnggaran").text());

        document.addEventListener('DOMContentLoaded', () => {
            Echo.channel('channel-dashboard-pumk')
                .listen('DashboardPumkEvent', (e) => {
                    var pumk = e.data;

                    setSummary("#totalPumk")
                    setSummary("#totalPumkTidakLancar")
                    setAnggaranSummary("#totalAnggaran", pumk.anggaran)
                    if (deleted_at !== null) {
                        unsetSummary("#totalPumk")
                        unsetSummary("#totalPumkTidakLancar")
                        setAnggaranSummary("#totalAnggaran", pumk.anggaran)
                    }

                })
        })
    </script>
@endsection
