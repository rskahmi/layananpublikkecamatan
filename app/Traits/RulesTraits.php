<?php

namespace App\Traits;

trait RulesTraits
{
    public function requiredMessage($attr)
    {
        return  'Data ' . $attr . ' harus di isi.';
    }

    public function existsMessage($attr)
    {
        return  'Data ' . $attr . ' tidak cocok dengan database kami.';
    }

    public function formattingMessage($attr, $format)
    {
        return  'Data ' . $attr . ' harus memiliki format ' . $format;
    }

    public function fileMessage(array $extensions)
    {
        $extensionsList = implode(', ', $extensions);
        return "Hanya menerima file dengan exstension {$extensionsList}.";
    }

    public function nomorBerkasMessage()
    {
        return 'Nomor berkas harus di isi.';
    }

    public function namaBerkasMessage()
    {
        return 'Nama berkas harus di isi.';
    }

    public function jenisBerkasMessage()
    {
        return 'Jenis berkas tidak di temukan.';
    }

    public function jenisNPPMessage()
    {
        return 'Jenis berkas tidak di temukan.';
    }

    public function jenisSIJMessage()
    {
        return 'Jenis berkas tidak di temukan.';
    }

    public function jenisSPDMessage()
    {
        return 'Jenis berkas tidak di temukan.';
    }

    public function jenisRDMessage()
    {
        return 'Jenis berkas tidak di temukan.';
    }

    public function jenisMessage()
    {
        return 'Jenis pemberitaan tidak di temukan.';
    }

    public function responMessage()
    {
        return 'Jenis pemberitaan tidak di temukan.';
    }

    public function tanggalMessage()
    {
        return 'Tanggal surat harus di isi.';
    }

    public function namaPemohonMessage()
    {
        return 'Nama pemohon harus di isi.';
    }

    public function contactMessage()
    {
        return 'Nomor kontak harus ada.';
    }

    public function namaIsoMessage()
    {
        return 'Nama ISO harus di isi.';
    }

    public function tanggalIsoMessage()
    {
        return 'Tanggal ISO harus di isi.';
    }

    public function masaBerlakuIso()
    {
        return 'Masa Berlaku ISO harus di isi.';
    }

    public function tanggalBerakhirIso()
    {
        return 'Tanggal Berakhir ISO harus di isi.';
    }

    public function tanggalAktifIso()
    {
        return 'Tanggal Aktif ISO harus di isi.';
    }
}
