<?php

namespace App\Http\Controllers;

use App\Http\Resources\Auth\LembagaResources;
use App\Models\LembagaModel;
use App\Traits\CacheTimeout;
use Exception;
use Illuminate\Http\Request;

class LembagaController extends Controller
{
    use CacheTimeout;

    public function store(Request $request)
    {
        try {
            $lembaga = LembagaModel::create($request->all());

            $this->forgetLembaga();

            return response()->json([
                'message' => 'Data berhasil ditambahkan',
                'data' => new LembagaResources($lembaga)
            ], 201);

        } catch (Exception $e) {
            return response()->json($e->getMessage());
        }
    }
}
