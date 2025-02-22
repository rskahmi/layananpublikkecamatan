@extends('layout.guest')

@section('bodyClass', 'body-beranda')
@section('title', 'Homepage')
@section('content')

    <div class="container beranda" id="beranda">
        <div class="row mx-0">
            <div
                class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-6 col-xxl-6 left d-flex align-items-center justify-content-center animate__animated animate__fadeInLeft">
                <img src="{{ asset('assets/img/logo/logo-kpi-ru-dumai-ii.png') }}" width="547" height="223"
                    alt="Logo Kilang Pertamina Internasional Refenery Unit II">
            </div>
            <div class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-6 col-xxl-6 right animate__animated animate__fadeInRight">
                <div class="row mx-0">
                    <div class="col-12">
                        <h5>Welcome to <b>Comm, Rel & CSR Pertamina RU II Dumai</b></h5>
                    </div>
                    <div class="col-12">
                        <h1>Silahkan Cek Pengajuan Anda</h1>
                    </div>
                    <div class="col-12">
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" placeholder="Masukkan Nomor Surat"
                                id="inputSearchBerkas" aria-label="Nomor ID" aria-describedby="basic-addon2">
                            <button class="btn btn-primary" id="btnSearchBerkas" data-url="{{ route('berkas.search') }}"
                                type="button">Cek</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade detail-pengajuan" id="cekBerkasModal" tabindex="-1" aria-labelledby="cekBerkasModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <h1>Detail Pengajuan</h1>
                        </div>
                        <div class="col-12">
                            <div class="row">
                                <div class="col-12 col-sm-12 col-md-12 col-lg-5" id="proposal-container">
                                    <div class="col-12 col-lg-12">
                                        <x-text.PopUpMenu title="Pemohon" subtitle="" id="pemohon" />
                                    </div>
                                    <div class="col-12 col-lg-12">
                                        <x-text.PopUpMenu title="Nomor Surat" subtitle="" id="nomor_surat" />
                                    </div>
                                    <div class="col-12 col-lg-12">
                                        <x-text.PopUpMenu title="Tanggal Pengajuan" subtitle="" id="tanggal_pengajuan" />
                                    </div>
                                    <div class="col-12 col-lg-12">
                                        <x-text.PopUpMenu title="Nama Berkas" subtitle="" id="nama_berkas" />
                                    </div>
                                    <div class="col-12 col-lg-12">
                                        <x-text.PopUpMenu title="Jenis" subtitle="" id="jenis" />
                                    </div>
                                    {{-- <div class="col-12 col-lg-12">
                                        <x-text.PopUpMenu title="Tanggal Pembaharuan" subtitle="12 Januari 2023, 10:20"
                                            id="tanggal_pembaharuan" />
                                    </div>
                                    <div class="col-12 col-lg-12">
                                        <x-text.PopUpMenu title="Total Waktu" subtitle="7 hari"
                                            id="waktu_terakhir_proses" />
                                    </div> --}}
                                    <div class="col-12 col-lg-12 popup-text">
                                        <h6>Status</h6>
                                        <span id="status_surat" class="badge rounded-pill text-capitalize">Proses...</span>
                                    </div>
                                    <div class="col-12 col-lg-12 mt-3 popup-text" id="file-balasan">
                                        <h6>Surat Jawaban</h6>
                                        <a target="_blank" href="{{ asset('storage/surat-balasan') }}">
                                            <img src="{{ asset('assets/img/icon/Download.svg') }}" alt="Icon Download">
                                            Buka Disini
                                        </a>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-12 col-md-12 col-lg-7 mt-3 mt-lg-0" id="riwayat-container">
                                    <div class="col-12">
                                        <h6 class="riwayat-header">Riwayat</h6>
                                    </div>
                                    <div class="col-12">
                                        <ul class="timeline">
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary btn-tutup" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        var app_url = "{{ config('app.url') }}"

        const navbar = document.getElementById("navbar").offsetHeight;

        const body = window.innerHeight

        const space = body - navbar - 40

        document.getElementById("beranda").style.height = space + "px";

        function setMessage(status) {
            switch (status) {
                case 'diajukan':
                    return 'Berkas diajukan oleh stakeholder'
                    break;
                case 'proses':
                    return 'Berkas sedang diproses'
                case 'diterima':
                    return 'Berkas telah disetujui untuk dibantu'
                case 'ditolak':
                    return 'Berkas tidak disetujui untuk dibantu'
            }
        }

        $("#btnSearchBerkas").on("click", function() {
            var keyword = $("#inputSearchBerkas").val()

            const url = $(this).data("url")

            const csrf = @json(csrf_token())

            if (keyword.length > 0) {
                $.ajax({
                    url: url,
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrf,
                    },
                    data: {
                        keyword: keyword
                    },
                    success: function(response) {
                        if (response.data.length > 0) {
                            $('.timeline').empty();
                            let data = response.data[0]
                            $("#nomor_surat").html(data.berkas.nomor_berkas)
                            $("#tanggal_pengajuan").html(formatDfy(data.berkas.tanggal))
                            $("#nama_berkas").html(data.berkas.nama_berkas)
                            $("#jenis").html(data.berkas.jenis)
                            $("#pemohon").html(data.berkas.nama_pengirim)
                            let status_surat = data.proposal.status
                            $("#status_surat").html(status_surat)

                            let badge = status_surat.toLowerCase() === "diterima" ? "bg-success" : (
                                status_surat.toLowerCase() === "proses" ? "bg-warning" : (
                                    status_surat.toLowerCase() === "diajukan" ?
                                    "bg-warning-subtle text-dark" : "bg-danger")
                            )

                            // Remove class list bagde
                            $("#status_surat").removeClass(
                                "bg-warning bg-danger bg-success bg-warning-subtle text-dark")
                            $("#status_surat").addClass(badge)

                            // File penolakan
                            if (data.riwayatproposal != "") {
                                if (data.riwayatproposal[0].surat_balasan != "") {
                                    if ((data.proposal.status === "ditolak" || data.proposal.status ===
                                            "diterima")) {
                                        $("#file-balasan").removeClass("d-none")
                                        var anchor = $("#file-balasan a")
                                        anchor.attr('href', app_url + '/storage/surat-balasan/' + data
                                            .riwayatproposal[0].surat_balasan)
                                    }
                                } else {
                                    $("#file-balasan").addClass("d-none")
                                }

                                $("#riwayat-container").removeClass("d-none")
                                $("#proposal-container").removeClass("col-lg-10").addClass("col-lg-5")
                            } else {
                                $("#file-balasan").addClass("d-none")
                                $("#riwayat-container").addClass("d-none")
                                $("#proposal-container").removeClass("col-lg-5").addClass("col-lg-10")
                            }

                            let riwayat = data.riwayatproposal

                            $.each(riwayat, function(index, item) {
                                var newItem = $('<li class="timeline-item">' +
                                    '<div class="date">' +
                                    '<div class="header"><h6>' + item.tanggal +
                                    '</h6></div>' +
                                    '<div class="footer">' + item.waktu + '</div>' +
                                    '</div>' +
                                    '<div class="circle"></div>' +
                                    '<div class="message">' +
                                    '<div class="header"><h6 class="status text-capitalize">' +
                                    item.status + '</h6>' +
                                    '</div>' +
                                    '<div class="footer">' + setMessage(item.status) +
                                    '</div>' +
                                    '</div>' +
                                    '</li>');

                                $('.timeline').append(newItem);
                            })
                            $('#cekBerkasModal').modal('show')
                        } else {
                            window.swal.fire({
                                icon: 'error',
                                title: "Nomor proposal salah!!!",
                                html: 'Nomor surat <b>' + keyword + '</b> tidak ditemukan',
                            });
                        }
                    },
                    error: {
                        function(xhr, status, error) {
                            window.swal.fire({
                                icon: 'error',
                                title: "Terjadi Error!!",
                                text: xhr.responseText,
                            });
                        }
                    }
                })
            }
        })
    </script>
@endsection
