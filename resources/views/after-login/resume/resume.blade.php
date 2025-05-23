@extends('layout.user')

@section('headers')
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
@endsection

@section('title', 'Resume')
@section('content')
    <x-svg.fitur.tjsl />
    <div class="row">
        <div class="col-5 col-12 col-sm-12 col-md-12 col-lg-5 col-xxl-5 mb-2 mb-lg-0">
            <div class="charts">
                <h4>Persentase Jenis Surat Yang Diajukan</h4>
                <div class="container-fluid">
                    <canvas id="tjslPieChart" height="211" width="211"></canvas>
                    <div class="label d-flex justify-content-center mt-3">
                        <span>
                            <span class="icon positif"></span>&nbsp; KK
                        </span>
                        <span>
                            <span class="icon netral"></span>&nbsp; KTP
                        </span>
                        <span>
                            <span class="icon negatif"></span>&nbsp; BBM
                        </span>
                        <span>
                            <span class="icon gold"></span>&nbsp; SKTM
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-2 col-12 col-sm-6 col-md-6 col-lg-3 col-xl-3 col-xxl-2 mb-2 mb-lg-0">
            <x-card.summary header="Jumlah Surat Yang Diajukan" value="{{formatRibuan($total_surat)}}" id="jumlahSurat">
                <x-svg.icon.program />
            </x-card.summary>
        </div>
        <div class="col-2 col-12 col-sm-6 col-md-6 col-lg-3 col-xl-3 col-xxl-2 mb-2 mb-lg-0">
            <x-card.summary header="Jumlah Surat Status Proses" color="blue" value="{{formatRibuan($total_surat_proses)}}"
                id="jumlahSuratProses">
                <x-svg.icon.unprogram />
            </x-card.summary>
        </div>
        <div class="col-2 col-12 col-sm-6 col-md-6 col-lg-3 col-xl-3 col-xxl-2 mb-2 mb-lg-0">
            <x-card.summary header="Jumlah Surat Yang Selesai" color="yellow" value="{{formatRibuan($total_surat_selesai)}}"
                id="jumlahSuratSelesai">
                <x-svg.icon.program-yellow />
            </x-card.summary>
        </div>
    </div>

    <div class="row mt-2">
        <div class="col-12">
            <div class="charts keuangan">
                <div class="title">
                    <div class="row">
                        <div class="col-12 col-md-6 col-xl-5">
                            <h4>Grafik
                                Perbandingan Surat Masuk Per Jenis Surat Secara Bulanan</h4>
                        </div>
                        <div class="col-12 col-md-6 col-xl-7">
                            <div class="label">
                                <span>
                                    <span class="icon negatif"></span>&nbsp;BBM
                                </span>

                                <span>
                                    <span class="icon netral"></span>&nbsp;KTP
                                </span>
                                <span>
                                    <span class="icon positif"></span>&nbsp;KK
                                </span>
                                <span>
                                    <span class="icon gold"></span>&nbsp;SKTM
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

    <div class="row mt-2">
        <div class="col-5 col-12 col-sm-12 col-md-12 col-lg-5 col-xxl-5 mb-2 mb-lg-0">
            <div class="charts">
                <h4>Persentase Pengaduan Yang Diselesaikan dan Ditolak</h4>
                <div class="container-fluid">
                    <canvas id="pengaduanPieChart" height="211" width="211"></canvas>
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
                    <canvas id="pengaduanChart"></canvas>
                </div>
            </div>
        </div>
    </div>

@endsection


@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2">
    </script>



<script>
    var canvas = document.getElementById('pengeluaranChart');
    var ctx = canvas.getContext('2d');
    var dataBBM = []
    var dataKTP = []
    var dataKK = []
    var dataSKTM = []

    @foreach ($grafik_bbm as $item )
        dataBBM.push({{ $item['total_bbm'] }})
    @endforeach

    @foreach ($grafik_ktp as $item )
        dataKTP.push({{ $item['total_ktp'] }})
    @endforeach

    @foreach ($grafik_kk as $item )
        dataKK.push({{ $item['total_kk'] }})
    @endforeach

    @foreach ($grafik_sktm as $item )
        dataSKTM.push({{ $item['total_sktm'] }})
    @endforeach

    var data = {
        labels: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'],
        datasets: [{
                label: 'Jumlah BBM',
                data: dataBBM,
                borderColor: '#D12031',
                borderWidth: 5,
                fill: false,
                backgroundColor: '#D12031',
                tension: 0.5
        },
        {
                label: 'Jumlah KTP',
                data: dataKTP,
                borderColor: '#145EA8',
                borderWidth: 5,
                fill: false,
                backgroundColor: '#145EA8',
                tension: 0.5
        },
        {
                label: 'Jumlah KK',
                data: dataKK,
                borderColor: '#65AE38',
                borderWidth: 5,
                fill: false,
                backgroundColor: '#65AE38',
                tension: 0.5
        },
        {
                label: 'Jumlah SKTM',
                data: dataSKTM,
                borderColor: '#EAC500',
                borderWidth: 5,
                fill: false,
                backgroundColor: '#EAC500',
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


        // pie chartp
        const suratLabel = ["KTP", "KK", "BBM", "SKTM" ]
        const suratData = [{!! $total_ktp !!}, {!! $total_kk !!} , {!! $total_bbm !!} , {!! $total_sktm !!}]
        console.log(suratData)
        pie("tjslPieChart", suratLabel, suratData)



        // Pengaduan
    var canvas = document.getElementById('pengaduanChart');
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
        const pengaduanLabel = ["Diselesaikan", "Ditolak"]
        const pengaduanData = [{!! $jumlah_status_selesai_pengaduan !!}, {!! $jumlah_status_tolak_pengaduan !!}]
        console.log(pengaduanData)
        pie("pengaduanPieChart", pengaduanLabel, pengaduanData)
    </script>
@endsection



