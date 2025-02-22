<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\DashboardRDEvent;
use App\Models\RDModel;
use App\Models\BaruModel;
use App\Models\GantiModel;
use App\Models\KembalikanModel;
use App\Models\RiwayatBaruModel;
use App\Models\RiwayatGantiModel;
use App\Models\RiwayatKembalikanModel;
use App\Traits\RulesTraits;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use App\Traits\CacheTimeout;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendEmail;
use App\Models\PenerbitanModel;
use App\Models\RiwayatPenerbitanModel;

class PenerbitanController extends Controller
{
    use CacheTimeout, RulesTraits;
    public function showPenerbitan(){
       try {
            if(!auth()->check()){
                return redirect()->route('login')->with('alert', [
                    'type' => 'warning',
                    'title' => 'Unauthorized',
                    'text' => 'Anda harus login untuk mengakses halaman ini.'
                ]);
            }

            $userId = auth()->user()->id;
            $role = auth()->user()->role;
            $penerbitanQuery = PenerbitanModel::with(['riwayat']);

        if ($role === 'admin') {
            $penerbitanQuery->whereHas('riwayat', function ($query) use ($userId) {
                $query->where('user_id', $userId)->where('tindakan', 1);
            });
        }

        if ($role === 'am'){
            $penerbitanQuery->whereHas('riwayat', function ($query) {
                $query->where('peninjau', 'am')->where('tindakan', 1);
            });
        }

        if ($role === 'admin-csr'){
            $penerbitanQuery->whereHas('riwayat', function ($query) {
                $query->where('peninjau', 'admin-csr')->where('tindakan', 1);
            });
        }

        if ($role === 'admin-comrel'){
            $penerbitanQuery->whereHas('riwayat', function ($query) {
                $query->where('peninjau', 'admin-comrel')->where('tindakan', 1);
            });
        }

        if ($role === 'admin-staf4'){
            $penerbitanQuery->whereHas('riwayat', function ($query) {
                $query->where('peninjau', 'admin-staf4')->where('tindakan', 1);
            });
        }

        if ($role === 'admin-staf5'){
            $penerbitanQuery->whereHas('riwayat', function ($query) {
                $query->where('peninjau', 'admin-staf5')->where('tindakan', 1);
            });
        }

        if ($role === 'admin-staf6'){
            $penerbitanQuery->whereHas('riwayat', function ($query) {
                $query->where('peninjau', 'admin-staf6')->where('tindakan', 1);
            });
        }

        if ($role === 'mgr-adm'){
            $penerbitanQuery->whereHas('riwayat', function ($query) {
                $query->where('peninjau', 'mgr-adm')->where('tindakan', 1);
            });
        }

        if ($role === 'avp-adm'){
            $penerbitanQuery->whereHas('riwayat', function ($query) {
                $query->where('peninjau', 'avp-adm')->where('tindakan', 1);
            });
        }

        if ($role === 'dhak'){
            $penerbitanQuery->whereHas('riwayat', function ($query) {
                $query->where('peninjau', 'dhak')->where('tindakan', 1);
            });
        }

        $penerbitan = $penerbitanQuery->orderBy('tanggal', 'desc')
                    ->get();

                return view('after-login.rd.penerbitan')
                    ->with([
                        'penerbitan' => $penerbitan
                    ]);
       }
       catch (Exception $e) {
        return redirect()->back()
            ->with(
                'alert',
                [
                    'type' => 'error',
                    'title' => 'Show Pengajuan',
                    'text' => $e->getMessage()
                ]
            );
    }
    }

    public function getDetailPengajuan($id){
        try {
            $penerbitan = PenerbitanModel::with(['riwayat'])->findOrFail($id);
            if ($penerbitan !== null) {
                $riwayat_penerbitan = RiwayatPenerbitanModel::with('user')->where('penerbitan_id', $penerbitan->id)->orderBy('created_at', 'desc')->get();

                return view('after-login.rd.detail-penerbitan')->with([
                    'penerbitan' => $penerbitan,
                    'riwayat_penerbitan' => $riwayat_penerbitan
                ]);
            } else {
                return view('after-login.rd.detail-penerbitan')->with([
                    'penerbitan' => $penerbitan
                ]);
            }
        }
        catch (Exception $e) {
            return redirect()->back()->with(
                'alert',
                [
                    'type' => 'error',
                    'title' => 'Detail Pengajuan',
                    'text' => $e->getMessage()
                ]
            );
        }
    }

    public function verifikasi(Request $request, $id){
        try {
            $penerbitan = PenerbitanModel::with(['riwayat'])->first();
            $lastOfRiwayat = $penerbitan->riwayat->sortBy('created_at')->last();
                $dataRiwayat = [
                    'penerbitan_id' => $penerbitan->id,
                    'user_id'=> auth()->user()->id,
                    'alasan' => $request->keterangan
                ];
            $statusPenerbitan = null;
            if (isManagerSection($lastOfRiwayat)){
                    $dataRiwayat['status'] = 'proses';
                    $statusPenerbitan = 'proses';
                    $dataRiwayat['peninjau'] = $request->peninjau;
                    $dataRiwayat['tindakan'] = 1;

                    if (isset($dataRiwayat['peninjau']) && strtolower($dataRiwayat['peninjau']) == "admin-comrel") {
                        $data = [
                            'text' => "Pengajuan baru masuk, Silahkan Verifikasi Secepatnya!",
                            'jenis' => "Penerbitan SIMRD"
                        ];
                        $email_target = 'riskyahmad0506@gmail.com';
                        Mail::to($email_target)->send(new SendEmail($data));
                    }
                    elseif (isset($dataRiwayat['peninjau']) && strtolower($dataRiwayat['peninjau']) == "admin-csr") {
                        $data = [
                            'text' => "Pengajuan baru masuk, Silahkan Verifikasi Secepatnya!",
                            'jenis' => "Penerbitan SIMRD"
                        ];
                        $email_target = 'riskyahmad0506@gmail.com';
                        Mail::to($email_target)->send(new SendEmail($data));
                    }
                    elseif (isset($dataRiwayat['peninjau']) && strtolower($dataRiwayat['peninjau']) == "admin-staf4") {
                        $data = [
                            'text' => "Pengajuan baru masuk, Silahkan Verifikasi Secepatnya!",
                            'jenis' => "Penerbitan SIMRD"
                        ];
                        $email_target = 'riskyahmad0506@gmail.com';
                        Mail::to($email_target)->send(new SendEmail($data));
                    }
                    elseif (isset($dataRiwayat['peninjau']) && strtolower($dataRiwayat['peninjau']) == "admin-staf5") {
                        $data = [
                            'text' => "Pengajuan baru masuk, Silahkan Verifikasi Secepatnya!",
                            'jenis' => "Penerbitan SIMRD"
                        ];
                        $email_target = 'riskyahmad0506@gmail.com';
                        Mail::to($email_target)->send(new SendEmail($data));
                    }
                    elseif (isset($dataRiwayat['peninjau']) && strtolower($dataRiwayat['peninjau']) == "admin-staf6") {
                        $data = [
                            'text' => "Pengajuan baru masuk, Silahkan Verifikasi Secepatnya!",
                            'jenis' => "Penerbitan SIMRD"
                        ];
                        $email_target = 'riskyahmad0506@gmail.com';
                        Mail::to($email_target)->send(new SendEmail($data));
                    }
                }

                else if (isStaffSection($lastOfRiwayat)){
                    if ($request->verifikasi === 'diterima'){
                        $dataRiwayat['status'] = 'proses';
                        $statusPenerbitan = 'proses';
                        $dataRiwayat['peninjau'] = 'mgr-adm';
                        $dataRiwayat['tindakan'] = 1;

                        $data = [
                            'text' => "Pengajuan baru masuk, Silahkan Verifikasi Secepatnya!",
                            'jenis' => "Penerbita$statusPenerbitan"
                        ];
                        $email_target = 'riskyahmad0506@gmail.com';
                        Mail::to($email_target)->send(new SendEmail($data));
                    }
                    else if ($request->verifikasi === 'ditolak'){
                        $dataRiwayat['status'] = $request->verifikasi;
                        $statusPenerbitan = $request->verifikasi;
                        $dataRiwayat['peninjau'] = 'admin';
                        $dataRiwayat['tindakan'] = 1;

                        $email_target = User::find($lastOfRiwayat->user_id)->email ?? null;
                                if (!$email_target) {
                                    throw new Exception('Email not found for the given user_id');
                                }
                                $data = [
                                    'text' => 'Pengajuan Ditolak Staf Adm, Cek Website untuk lihat Alasan!',
                                    'jenis' => 'Reimburstment',
                                ];
                                Mail::to($email_target)->send(new SendEmail($data));
                    }
                }

                else if (isMgrAdmSection($lastOfRiwayat)){
                    if ($request->verifikasi === 'diterima'){
                        $dataRiwayat['status'] = 'proses';
                        $statusPenerbitan = 'proses';
                        $dataRiwayat['peninjau'] = 'avp-adm';
                        $dataRiwayat['tindakan'] = 1;

                        $data = [
                            'text' => "Pengajuan baru masuk, Silahkan Verifikasi Secepatnya!",
                            'jenis' => "Penerbitan"
                        ];
                        $email_target = 'riskyahmad0506@gmail.com';
                        Mail::to($email_target)->send(new SendEmail($data));
                    }
                    else if ($request->verifikasi === 'ditolak'){
                        $dataRiwayat['status'] = $request->verifikasi;
                        $statusPenerbitan = $request->verifikasi;
                        $dataRiwayat['peninjau'] = 'admin';
                        $dataRiwayat['tindakan'] = 1;

                        $email_target = User::find($lastOfRiwayat->user_id)->email ?? null;
                                if (!$email_target) {
                                    throw new Exception('Email not found for the given user_id');
                                }
                                $data = [
                                    'text' => 'Pengajuan Ditolak Staf Adm, Cek Website untuk lihat Alasan!',
                                    'jenis' => 'Reimburstment',
                                ];
                                Mail::to($email_target)->send(new SendEmail($data));
                    }
                }

                elseif (isAVPAdmSection($lastOfRiwayat)){
                    if ($request->verifikasi === 'diterima'){
                        $dataRiwayat['status'] = $request->verifikasi;
                        $statusPenerbitan = $request->verifikasi;
                        $dataRiwayat['peninjau'] = '-';
                        $dataRiwayat['tindakan'] = 0;

                        $data = [
                            'text' => "Pengajuan baru masuk, Silahkan Verifikasi Secepatnya!",
                            'jenis' => "Penerbitan"
                        ];
                        $email_target = 'riskyahmad0506@gmail.com';
                        Mail::to($email_target)->send(new SendEmail($data));
                    }
                    else if ($request->verifikasi === 'ditolak'){
                        $dataRiwayat['status'] = $request->verifikasi;
                        $statusPenerbitan = $request->verifikasi;
                        $dataRiwayat['peninjau'] = 'am';
                        $dataRiwayat['tindakan'] = 1;

                        $email_target = User::find($lastOfRiwayat->user_id)->email ?? null;
                                if (!$email_target) {
                                    throw new Exception('Email not found for the given user_id');
                                }
                                $data = [
                                    'text' => 'Pengajuan Ditolak Staf Adm, Cek Website untuk lihat Alasan!',
                                    'jenis' => 'Penerbitan',
                                ];
                                Mail::to($email_target)->send(new SendEmail($data));
                    }
                }



                $penerbitan->update([
                    'status' =>$statusPenerbitan
                ]);
                $riwayat = RiwayatPenerbitanModel::create($dataRiwayat);

                    $this->forgetNPP();
                    return redirect()->back()->with('alert', [
                        'type' => 'success',
                        'title' => 'Verifikasi',
                        'text' => 'Berhasil verifikasi berkas'
                    ]);

            }
        catch (Exception $e) {
            return redirect()->back()
                ->with(
                    'alert',
                    [
                        'type' => 'error',
                        'title' => 'Verifikasi',
                        'text' => $e->getMessage()
                    ]
                );
        }
    }
}
