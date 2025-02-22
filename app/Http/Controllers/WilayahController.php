<?php

namespace App\Http\Controllers;

use App\Events\WilayahEvent;
use App\Traits\CacheTimeout;
use Exception;
use App\Models\WilayahModel;
use Illuminate\Http\Request;

class WilayahController extends Controller
{
    use CacheTimeout;
    public function store(Request $request)
    {
        try {
            $existingWilayah = WilayahModel::where('alamat', $request->alamat)
                ->where('kelurahan', $request->kelurahan)
                ->first();

            if ($existingWilayah) {
                return response()->json([
                    "status" => false,
                    "message" => "Wilayah sudah ada"
                ]);
            }

            $wilayah = WilayahModel::create([
                'alamat' => $request->alamat,
                'kelurahan' => $request->kelurahan,
                'kecamatan' => $request->kecamatan,
                'kota' => $request->kabupaten,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
            ]);

            $this->forgetWilayah();

            event(new WilayahEvent($wilayah));

            return response()->json([
                "status" => true,
                "message" => "Wilayah baru telah di tambahkan"
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
}
