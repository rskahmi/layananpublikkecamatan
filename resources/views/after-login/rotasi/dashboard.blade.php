@extends('layout.user')

@section('headers')
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
@endsection

@section('title', 'Dashboard Berkas')
@section('content')
    <x-svg.fitur.berkas />
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
                        <canvas id="pengeluaranChart"></canvas>
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

    // grafik chart bulanan
    var canvas = document.getElementById('pengeluaranChart');
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
