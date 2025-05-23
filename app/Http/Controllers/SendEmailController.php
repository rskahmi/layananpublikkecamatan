<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\SendEmail;

class SendEmailController extends Controller
{
    public function index(){
        return view ('emails.sendemail');
    }

    public function send_email(){
        $data = [
            'text' => "Ini text email...",

        ];
        $email_target = 'riskyahmad0506@gmail.com';
        Mail::to($email_target)->send(new SendEmail($data));
        return redirect()->route('email')->with('pesan', 'Email berhasil terkirim');
    }
}



$data = [
    'text' => "Pengajuan baru masuk, Silahkan Verifikasi Secepatnya!",
    'jenis' => "UMD"
];
$email_target = 'riskyahmad0506@gmail.com';
Mail::to($email_target)->send(new SendEmail($data));



$email_target = User::find($lastOfRiwayat->user_id)->email ?? null;
                            if (!$email_target) {
                                throw new Exception('Email not found for the given user_id');
                            }
                            $data = [
                                'text' => 'Pengajuan Ditolak Staf Adm, Cek Website untuk lihat Alasan!',
                                'jenis' => 'Reimburstment',
                            ];
                            Mail::to($email_target)->send(new SendEmail($data));
