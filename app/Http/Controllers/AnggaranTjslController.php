<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\TjslModel;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\RiwayatAnggaranModel;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\Auth\TjslResources;

class AnggaranTjslController extends Controller
{
    public function show()
    {
        try {
            $anggaran = RiwayatAnggaranModel::with(['tjsl'])->orderBy('created_at', 'desc')->get();

            $year = Carbon::now()->year;
            $month = Carbon::now()->month;

            $totalRiwayatThn = RiwayatAnggaranModel::whereYear('created_at', $year)->sum('nominal');

            $totalRiwayatBlnIni = RiwayatAnggaranModel::whereYear('created_at', $year)
                ->whereMonth('created_at', $month)
                ->sum('nominal');

            $totalAnggaran = TjslModel::whereYear('created_at', $year)->sum('anggaran');

            $totalSisaAnggaran = RiwayatAnggaranModel::whereYear('created_at', $year)->sum('sisa_anggaran');

            return view('after-login.tjsl.anggaran')->with([
                'total_riwayat_thn_ini' => $totalRiwayatThn,
                'total_riwayat_bln_ini' => $totalRiwayatBlnIni,
                'total_anggaran' => $totalAnggaran,
                'sisa_anggaran' => $totalSisaAnggaran,
                'anggaran' => TjslResources::collection($anggaran)
            ]);

        } catch (Exception $e) {
            return redirect()->back()
                ->with(
                    'alert',
                    [
                        'type' => 'error',
                        'title' => 'Show Anggaran Tjsl',
                        'text' => $e->getMessage()
                    ]
                );
        }
    }

    public function store(Request $request, $id)
    {
        try {
            $tjsl = TjslModel::findOrFail($id);

            $sisaAnggaran = removeComma($tjsl->anggaran) - removeComma($request->nominal);

            $lastRiwayat = RiwayatAnggaranModel::where('tjsl_id', $id)
                ->orderBy('tanggal', 'desc')
                ->first();

            if ($lastRiwayat) {
                $sisaAnggaran = removeComma($lastRiwayat->sisa_anggaran) - removeComma($request->nominal);
            }

            $anggaranTjsl = RiwayatAnggaranModel::create([
                'tujuan' => $request->tujuan,
                'tanggal' => $request->tanggal,
                'nominal' => removeComma($request->nominal),
                'sisa_anggaran' => $sisaAnggaran,
                'tjsl_id' => $id,
                'user_id' => auth()->user()->id
            ]);

            return redirect()->back()
                ->with(
                    'alert',
                    [
                        'type' => 'success',
                        'title' => 'Insert Anggaran Tjsl',
                        'text' => 'Data berhasil ditambahkan!'
                    ]
                );

        } catch (Exception $e) {
            return redirect()->back()
                ->with(
                    'alert',
                    [
                        'type' => 'error',
                        'title' => 'Insert Anggaran Tjsl',
                        'text' => $e->getMessage()
                    ]
                );
        }
    }
}
