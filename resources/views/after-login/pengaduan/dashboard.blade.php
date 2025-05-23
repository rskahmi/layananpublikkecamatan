@extends('layout.user')

@section('title', 'Dashboard Pengaduan Masyarakat')
@section('content')
    <x-svg.fitur.tjsl />
    <div class="row">
        <div class="col-5 col-12 col-sm-12 col-md-12 col-lg-5 col-xxl-5 mb-2 mb-lg-0">
            <div class="charts">
                <h4>Persentase Pengaduan Yang Diselesaikan dan Ditolak</h4>
                <div class="container-fluid">
                    <canvas id="tjslPieChart" height="211" width="211"></canvas>
                    <div class="label d-flex justify-content-center mt-3">
                        <span>
                            <span class="icon positif"></span>&nbsp; Ditolak
                        </span>
                        <span>
                            <span class="icon netral"></span>&nbsp; Diselesaikan
                        </span>

                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-xxl-5" >
            <div class="row">
                <div class="col-12 col-md-4 col-lg-6 col-x mb-2">
                    <x-card.summary header="Jumlah Pengaduan Yang Diajukan" color="blue"
                    value="{{formatRibuan($total_pengaduan)}}" id="totalProposal"
                    footer="dari Pengajuan di tahun ini">
                    <x-svg.icon.signin />
                    </x-card.summary>
                </div>
                <div class="col-12 col-md-4 col-lg-6 col-x mb-2">
                    <x-card.summary header="Jumlah Pengaduan Status Proses" color="yellow" value="{{formatRibuan($jumlah_status_proses_pengaduan)}}"
                        id="jumlahSuratProses" footer="dari Pengajuan di tahun ini">
                    <x-svg.icon.program-yellow />
                    </x-card.summary>
                </div>
                <div class="col-12 col-md-4 col-lg-6 col-x mb-2">
                    <x-card.summary header="Jumlah Pengaduan Status Selesai" color="green" value="{{formatRibuan($jumlah_status_selesai_pengaduan)}}"
                        id="jumlahSuratSelesai" footer="dari Pengajuan di tahun ini">
                        <x-svg.icon.done />
                    </x-card.summary>
                </div>
                <div class="col-12 col-md-4 col-lg-6 col-x mb-2">
                    <x-card.summary header="Jumlah Pengaduan Status Ditolak" color="red" value="{{ formatRibuan($jumlah_status_tolak_pengaduan) }}"
                        id="jumlahSuratSelesai" footer="dari Pengajuan di tahun ini">
                        <x-svg.icon.close />
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
                                Pengajuan Pengaduan Secara Bulanan</h4>
                        </div>
                        <div class="col-12 col-md-6 col-xl-7">
                            <div class="label">
                                {{-- <span>
                                    <span class="icon netral"></span>&nbsp;Pengaduan
                                </span> --}}
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

    <br>

@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/chartjs-plugin-datalabels/2.0.0/chartjs-plugin-datalabels.min.js"></script>
    <script>
    // grafik chart bulanan
    var canvas = document.getElementById('pengeluaranChart');
    var ctx = canvas.getContext('2d');
    var dataPengaduan = []
    @foreach ($grafik_pengaduan as $item )
        dataPengaduan.push({{ $item['total_pengaduan'] }})
    @endforeach
    var data = {
        labels: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'],
        datasets: [{
                label: 'Jumlah Pengaduan',
                data: dataPengaduan,
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
        const suratLabel = ["Diselesaikan", "Ditolak"]
        const suratData = [{!! $jumlah_status_selesai_pengaduan !!}, {!! $jumlah_status_tolak_pengaduan !!}]
        console.log(suratData)
        pie("tjslPieChart", suratLabel, suratData)
    </script>
@endsection
