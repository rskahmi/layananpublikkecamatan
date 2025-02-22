@extends('layout.user')

@section('headers')
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
@endsection

@section('title', 'Dashboard Berkas')
@section('content')
    <x-svg.fitur.berkas />
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
                        <canvas id="pengeluaranChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
@endsection
@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/chartjs-plugin-datalabels/2.0.0/chartjs-plugin-datalabels.min.js">
    </script>

<script>

    // grafik chart bulanan
    var canvas = document.getElementById('pengeluaranChart');
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


        // Create the chart
        var myChart = new Chart(
            document.getElementById('barChart'),
            config
        );



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
