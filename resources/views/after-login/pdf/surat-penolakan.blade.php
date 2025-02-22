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
                class="bolder">{{ $no_surat_proposal }}</span> pada tanggal {{ $tanggal_masuk }} perihal
            permohonan dana, sebelumnya kami mengucapkan terimakasih atas perhatian saudara kepada PT Kilang
            Pertamina Internasional Unit II Dumai.
        </p>
        <p>Berkaitan dengan permohonan bantuan sebagaimana termuat dalam surat tersebut, kami mohon maaf belum
            dapat berpartisipasi dalam kegiatan tersebut.</p>
    </div>
    <div class="penutup mt-3">
        <p class="text-justify">
            Semoga kegiatan ini dapat terlaksana dengan lancar sebagaimana direncanakan.
            Demikian yang dapat kami sampaikan, atas perhatian yang di berikan kami ucapkan terima kasih.
        </p>
    </div>
@endsection
