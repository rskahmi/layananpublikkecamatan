@extends('after-login.pdf.layout')
@section('nomor-surat', $no_surat)
@section('nama-surat', removeProposalWord($nama))
@section('tanggal-sekarang', $tanggal_sekarang)
@section('nama-pemohon', $pemohon)
@section('main-body')
    <div class="pembuka mt-4">
        <p>Dengan Hormat,</p>
        <p class="text-justify">
            Sehubungan dengan pengajuan proposal {{ removeProposalWord($nama) }} No. <span
                class="bolder">{{ $no_surat_proposal }}</span> pada tanggal {{ $tanggal_masuk }} perihal permohonan dana,
            sebelumnya kami mengucapkan terimakasih atas perhatian saudara kepada PT Kilang Pertamina Internasional Unit II
            Dumai.
        </p>
        <p class="text-justify">Berkaitan dengan permohonan bantuan sebagaimana termuat dalam surat tersebut, kami memutuskan
            untuk <span class="bolder">membantu</span> pengajuan tersebut dengan rincian sebagai berikut:</p>
    </div>
    <div class="detail ms-5">
        <table>
            <tr>
                <td>Perihal</td>
                <td>:</td>
                <td>{{ $nama }}</td>
            </tr>
            <tr>
                <td>Tanggal Masuk</td>
                <td>:</td>
                <td>{{ $tanggal_masuk }}</td>
            </tr>
            <tr>
                <td>Nama Pemohon</td>
                <td>:</td>
                <td>{{ $pemohon }}</td>
            </tr>
            <tr>
                <td>Nilai Bantuan</td>
                <td>:</td>
                <td>{{ $anggaran }}</td>
            </tr>
        </table>
    </div>
    <div class="penutup mt-3">
        <p class="text-justify">Berdasarkan hal tersebut, saudara diminta untuk memenuhi beberapa dan mengirim persyaratan
            berikut ini ke alamat email <span class="bolder">{{ config('services.company.email') }}</span> berupa:</p>
        <ol>
            <li>Foto Copy KTP</li>
            <li>KWITANSI</li>
        </ol>

        <p class="mt-1 text-justify">
            Semoga kegiatan ini dapat terlaksana dengan lancar sebagaimana direncanakan.
            Demikian yang dapat kami sampaikan, atas perhatian yang di berikan kami ucapkan terima kasih.
        </p>
    </div>
@endsection
