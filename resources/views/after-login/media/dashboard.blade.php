@extends('layout.user')

@section('title', 'Dashboard Media')
@section('bodyClass', 'body-rilis')
@section('content')
    <x-svg.fitur.media />
    <div class="row">
        <div class="col-12 col-lg-4 mb-2">
            <div class="card charts" style="height: 100%;">
                <div class="card-header">
                    <h5 class="card-title bigger">
                        Persentase Jenis Pemberitaan
                    </h5>
                    <h6 class="charts-jumlah"  id="totalPemberitaan" >
                        {{ formatRibuan($media['total_berita']) }}
                    </h6>
                    <p class="mt-2 text-footer">dari Total di tahun ini</p>
                </div>
                <div class="card-body">
                    <div class="chart-body">
                        <canvas id="chartJSContainer" width="450" height="450"></canvas>
                    </div>

                    <div class="label">
                        <span>
                            <span class="icon semi-danger"></span>&nbsp;Media Online
                        </span>
                        <span>
                            <span class="icon warning"></span>&nbsp;Media Cetak
                        </span>
                        <span>
                            <span class="icon more-warning"></span>&nbsp;Media Elektronik
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-8 mb-2">
            <div class="row">
                <div class="col-12 col-sm-6 col-md-4 col-lg-4 col-xxl-4 mb-2">
                    <x-card.summary header="Jumlah Rilis" color="yellow" value="{{ formatRibuan($media['total_rilis']) }}" id="totalRilis">
                        <x-svg.icon.camera />
                    </x-card.summary>
                </div>
                <div class="col-12 col-sm-6 col-md-4 col-lg-4 col-xxl-4 mb-2">
                    <x-card.summary header="Jumlah Berita " color="green" value="{{ formatRibuan($media['total_berita']) }}" id="totalBerita">
                        <x-svg.icon.done />
                    </x-card.summary>
                </div>
                <div class="col-12 col-sm-6 col-md-4 col-lg-4 col-xxl-4 mb-2">
                    <x-card.summary header="Jumlah Media" color="blue" value="{{ formatRibuan($media['total_media']) }}"
                        footer="dari Program di tahun ini" id="totalMedia">
                        <x-svg.icon.noentri />
                    </x-card.summary>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-sm-6 col-md-4 col-lg-4 col-xxl-4 mb-2 mb-lg-0">
                    <div class="card charts rilis" style="height: 100%;">
                        <div class="card-header">
                            <h5 class="card-title bigger">
                                Persentase Respon Berita Online
                            </h5>

                        </div>
                        <div class="card-body">
                            <div class="chart-body">
                                <canvas id="respon-berita-online"></canvas>
                            </div>

                            <div class="label d-flex justify-content-center">
                                <span>
                                    <span class="icon positif"></span>&nbsp;{{ $media["jumlahResponOnline"]["positif"] }} Positif
                                </span>
                                <span>
                                    <span class="icon netral"></span>&nbsp;{{ $media["jumlahResponOnline"]["netral"] }} Netral
                                </span>
                                <span>
                                    <span class="icon negatif"></span>&nbsp;{{ $media["jumlahResponOnline"]["negatif"] }} Negatif
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-md-4 col-lg-4 col-xxl-4 mb-2 mb-lg-0">
                    <div class="card charts rilis" style="height: 100%;">
                        <div class="card-header">
                            <h5 class="card-title bigger">
                                Persentase Respon Berita Cetak
                            </h5>

                        </div>
                        <div class="card-body">
                            <div class="chart-body">
                                <canvas id="respon-berita-cetak"></canvas>
                            </div>

                            <div class="label d-flex justify-content-center">
                                <span>
                                    <span class="icon positif"></span>&nbsp;{{ $media["jumlahResponCetak"]["positif"] }} Positif
                                </span>
                                <span>
                                    <span class="icon netral"></span>&nbsp;{{ $media["jumlahResponCetak"]["netral"] }} Netral
                                </span>
                                <span>
                                    <span class="icon negatif"></span>&nbsp;{{ $media["jumlahResponCetak"]["negatif"] }} Negatif
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-4 col-lg-4 col-xxl-4 mb-2 mb-lg-0">
                    <div class="card charts rilis" style="height: 100%;">
                        <div class="card-header">
                            <h5 class="card-title bigger">
                                Persentase Respon Berita Elektronik
                            </h5>

                        </div>
                        <div class="card-body">
                            <div class="chart-body">
                                <canvas id="respon-berita-elektronik"></canvas>
                            </div>

                            <div class="label d-flex justify-content-center">
                                <span>
                                    <span class="icon positif"></span>&nbsp;{{ $media["jumlahResponElektronik"]["positif"] }} Positif
                                </span>
                                <span>
                                    <span class="icon netral"></span>&nbsp;{{ $media["jumlahResponElektronik"]["netral"] }} Netral
                                </span>
                                <span>
                                    <span class="icon negatif"></span>&nbsp;{{ $media["jumlahResponElektronik"]["negatif"] }} Negatif
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .chart-container {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .chart-content {
            position: relative;
            display: block;
            width: 150px;
            height: 150px;
        }

        .chart-content canvas {
            display: block;
            max-width: 100%;
            max-height: 100%;
            border-radius: 50%;
            z-index: 2;
        }

        .chart-background {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border-radius: 50%;
            z-index: 1;
            pointer-events: none;
        }

        .chart-percentage {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 32px;
            font-weight: bold;
        }

        .chartPositif .chart-background {
            background-color: rgba(101, 174, 56, 0.25);
        }

        .chartPositif .chart-percentage {
            color: #65AE38;
        }
        .chartNegatif .chart-background {
            background-color: rgba(209, 32, 49, 0.20)
        }

        .chartNegatif .chart-percentage {
            color: #D12031;
        }
        .chartNetral .chart-background {
            background-color: rgba(28, 132, 255, 0.20);
        }

        .chartNetral .chart-percentage {
            color: #1C84FF;
        }
    </style>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.3.0/dist/chart.umd.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>
    <script>

        var total_media_online = {!! $media['total_media_online'] !!}

        var total_media_cetak = {!! $media['total_media_cetak'] !!}

        var total_media_elektronik = {!! $media['total_media_elektronik'] !!}

        var options = {
            type: 'doughnut',
            data: {
                labels: ["Media Online", "Media Cetak", "Media Elektronik"],
                datasets: [{
                    label: 'Persentase Respon Berita',
                    data: [total_media_online, total_media_cetak, total_media_elektronik],
                    backgroundColor: ["#F3722C", "#F8961E","#F94144"]
                }]
            },
            options: {
                rotation: 270,
                circumference: 180,
                plugins: {
                    legend: false,
                    datalabels: {
                        font: {
                            size: 20
                        },
                        color: '#fff',
                        formatter: function(value, context) {
                            var sum = context.dataset.data.reduce((a, b) => a + b, 0);
                            var percentage = Math.round((value / sum) * 100) + '%';
                            return percentage;
                        }
                    }
                }
            },
            plugins: [ChartDataLabels]
        };

        var ctx = document.getElementById('chartJSContainer').getContext('2d');
        new Chart(ctx, options);


        // charts donat
        var labels = [
            'Positif', 'Netral', 'Negatif'
        ]
        var dataOnline = [{!! $media["jumlahResponOnline"]["positif"] !!}, {!! $media["jumlahResponOnline"]["netral"] !!}, {!! $media["jumlahResponOnline"]["negatif"] !!}];
        chartPemberitaan("#respon-berita-online", "Presentase Berita Online", labels, dataOnline);

        var dataCetak = [{!! $media["jumlahResponCetak"]["positif"] !!}, {!! $media["jumlahResponCetak"]["netral"] !!}, {!! $media["jumlahResponCetak"]["negatif"] !!}];
        chartPemberitaan("#respon-berita-cetak", "Presentase Berita Cetak", labels, dataCetak);

        var dataElektronik = [{!! $media["jumlahResponElektronik"]["positif"] !!}, {!! $media["jumlahResponElektronik"]["netral"] !!}, {!! $media["jumlahResponElektronik"]["negatif"] !!}];
        chartPemberitaan("#respon-berita-elektronik", "Presentase Berita Elektronik", labels, dataElektronik);

        document.addEventListener("DOMContentLoaded", function () {
            Echo.channel('channel-dashboard-media')
                .listen('DashboardMediaEvent', (e) => {
                    var media = e.data;

                    if (media.hasOwnProperty('deleted_at')) {
                        unsetSummary("#totalMedia")
                        unsetSummary("#totalRilis")
                        unsetSummary("#totalBerita")
                    } else {
                        setSummary("#totalRilis")
                    }

                        // setSummary("#totalMedia")
                        // setSummary("#totalBerita")
                })
        })

    </script>
@endsection
