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
                    <x-card.summary header="Jumlah Proposal Masuk" color="blue"
                    value="{{ formatRibuan($total_berkas) }}" id="totalProposal"
                    footer="dari Pengajuan di tahun ini">
                    <x-svg.icon.signin />
                    </x-card.summary>
                </div>
                <div class="col-12 col-sm-6 col-md-4 col-lg-4 col-xxl-4 mb-2">
                    <x-card.summary header="Jumlah Surat Masuk" color="blue"
                        value="{{ formatRibuan($total_surat) }}" id="totalSurat"
                        footer="dari Pengajuan di tahun ini">
                        <x-svg.icon.signin />
                    </x-card.summary>
                </div>
                <div class="col-12 col-sm-6 col-md-4 col-lg-4 col-xxl-4 mb-2">
                    <x-card.summary header="Jumlah Undangan Masuk" color="blue"
                        value="{{ formatRibuan($total_undangan) }}" id="totalUndangan"
                        footer="dari Pengajuan di tahun ini">
                        <x-svg.icon.signin />
                    </x-card.summary>
                </div>
                <div class="col-12 col-sm-6 col-md-4 col-lg-4 col-xxl-4 mb-2">
                    <x-card.summary header="Jumlah Proposal Dibantu" color="green"
                        value="{{ formatRibuan($jumlah_status_verifikasi) }}" id="totalProposalBantu"
                        footer="dari Pengajuan di tahun ini">
                        <x-svg.icon.done />
                    </x-card.summary>
                </div>
                <div class="col-12 col-sm-6 col-md-4 col-lg-4 col-xxl-4 mb-2">
                    <x-card.summary header="Jumlah Proposal Belum Diverifikasi" color="yellow"
                        value="{{ formatRibuan($jumlah_status_proses) }}" id="totalPengajuanProses"
                        footer="dari Pengajuan di tahun ini">
                        <x-svg.icon.program-yellow />
                    </x-card.summary>
                </div>
                <div class="col-12 col-sm-6 col-md-4 col-lg-4 col-xxl-4 mb-2">
                    <x-card.summary header="Jumlah Proposal Ditolak" color="red"
                        value="{{ formatRibuan($jumlah_status_tolak) }}" id="totalProposalTolak"
                        footer="dari Pengajuan di tahun ini">
                        <x-svg.icon.close />
                    </x-card.summary>
                </div>
                <div class="col-12 col-sm-6 col-md-4 col-lg-4 col-xxl-4 mb-2">
                    <x-card.summary header="Total Anggaran Proposal Dibantu" color="green"
                    value="{{ formatRupiah($total_anggaran) }}" id="totalAnggaranBantu">
                        <x-svg.icon.currency-green />
                    </x-card.summary>
                </div>
                <div class="col-12 col-sm-6 col-md-4 col-lg-4 col-xxl-4 mb-2">
                    <x-card.summary header="Jumlah Stakeholder yang Dibantu" color="green"
                    value="{{ formatRibuan($jumlah_stakeholder) }}" id="totalStakeholderBantu">
                        <x-svg.icon.program />
                    </x-card.summary>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-12 col-md-12 col-lg-5 col-xxl-5 mb-2 mb-lg-0">
            <div class="row" style="margin-left: 0;">
                <div class="col-12 charts">
                    <h4>Pengajuan Berdasarkan Stakeholder</h4>
                    <div class="container-fluid">
                        <canvas id="barChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-12 col-sm-12 col-md-12 col-lg-7 col-xxl-7 mb-2 mb-lg-0">
            <div class="card table">
                <div class="card-header">
                    <h4>Pengajuan Berkas</h4>
                </div>
                <div class="card-body">
                    <x-table>
                        @slot('slotHeading')
                            <tr>
                                <th scope="col">BERKAS</th>
                                <th scope="col">BATAS KONFIRMASI</th>
                                <th scope="col">STATUS</th>
                                <th scope="col">AKSI</th>
                            </tr>
                        @endslot


                        @slot('slotBody')
                            @foreach ($berkas_proses as $item)
                                <tr>
                                    <td class="w-50">
                                        <h6>{{ $item['nama_berkas'] }}</h6>
                                    </td>
                                    <td>
                                        {{ format_dfy($item['batas_konfirmasi']) }}
                                    </td>
                                    <td>
                                        <span class="badge {{ strtolower($item['status']) == 'diajukan' ? 'bg-warning-subtle text-dark' : 'bg-warning' }} text-capitalize">{{ $item['status'] }}</span>
                                    </td>
                                    <td>
                                        <a href="{{ route('berkas.detail', ['id' => $item['id']]) }}">
                                            <x-svg.icon.info />
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        @endslot
                    </x-table>
                </div>
            </div>
            <x-pagination />
        </div>
        <div class="col-5 col-12 col-sm-12 col-md-12 col-lg-5 col-xxl-5 mb-2 mb-lg-0">
            <div class="charts">
                <h4>Persentase Proposal yang Sudah Diverifikasi</h4>
                <div class="container-fluid">
                    <canvas id="tjslPieChart" height="211" width="211"></canvas>
                    <div class="label d-flex justify-content-center mt-3">
                        <span>
                            <span class="icon positif"></span>&nbsp;{{ $jumlah_status_verifikasi }} Dibantu
                        </span>
                        <span>
                            <span class="icon netral"></span>&nbsp;{{ $jumlah_status_tolak }} Ditolak
                        </span>
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
        dataTable(2)

        const labels = @json($labels);
        const datax = @json($datax);

        const data = {
            labels: labels,
            datasets: [{
                label: 'Data',
                backgroundColor: '#34B53A',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1,
                borderRadius: 40,
                barThickness: 6,
                data: datax,
            }]
        };

        const config = {
            type: 'bar',
            data: data,
            options: {
                scales: {
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            borderWidth: 0,
                            font: {
                                size: 10
                            }
                        }
                    },
                    y: {
                        beginAtZero: true,
                        grid: {
                            drawBorder: false,
                        },
                        ticks: {
                            font: {
                                size: 10
                            }
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        };

        const tjslLabels = ["Ditolak", "Dibantu"]
        const tjslData = [{!! $jumlah_status_tolak !!}, {!! $jumlah_status_verifikasi !!}]
        console.log(tjslData)


        pie("tjslPieChart", tjslLabels, tjslData)


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
