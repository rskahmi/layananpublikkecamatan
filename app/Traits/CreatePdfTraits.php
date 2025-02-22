<?php

namespace App\Traits;


use Mccarlosen\LaravelMpdf\Facades\LaravelMpdf as PDF;
use Illuminate\Support\Facades\Storage;

trait CreatePdfTraits
{
    public function generate($data, $status)
    {
        $time = time();

        $view = '';
        $suratName = '';

        if($status === 'diterima') {
            $view = 'after-login.pdf.surat-persetujuan';
            $suratName = 'surat-persetujuan-' . $time . '.pdf';
        } else {
            $view = 'after-login.pdf.surat-penolakan';
            $suratName = 'surat-penolakan-' . $time . '.pdf';
        }

        $pdf = PDF::loadView($view, $data);
        $path = 'public/surat-balasan/';
        $filePath = $path . $suratName ;

        $pdfContent = $pdf->output();

        if(!Storage::exists($path)) {
            Storage::makeDirectory($path);
        }

        Storage::put($filePath, $pdfContent);
        return $suratName;
    }
}

