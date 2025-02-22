<?php

namespace App\Http\Controllers;
use App\Traits\RulesTraits;
use Exception;
use Illuminate\Http\Request;
use App\Models\RiwayatUMDModel;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\RiwayatUMDResource;

class RiwayatUMDController extends Controller
{
    use RulesTraits;
    public function store(Request $request){
        try {
            $validatedData = Validator::make($request->all(), [
                'tindakan' => 'required|boolean',
                'status' => 'required|string',
                'peninjau' => 'required|string',
                'alasan' => 'required',
                'umd_id'  => 'required|exist:umd,id'
            ], [
                'tindakan.required' => $this->requiredMessage('tindakan'),
                'status.required' => $this->requiredMessage('status'),
                'peninjau.required' => $this->requiredMessage('peninjau'),
                'alasan.required' => $this->requiredMessage('alasan'),
                'umd_id.required' => $this->requiredMessage('umd_id'),
                'umd_id.exists' => $this->existsMessage('umd_id'),
            ]);

            if ($validatedData->fails()) {
                return redirect()->back()
                    ->with(
                        'alert',
                        [
                            'type' => 'error',
                            'title' => 'Insert Data Riwayat',
                            'text' => validatorError($validatedData->errors()->all())
                        ]
                    );
            }
            $validatedData = $validatedData->validated();

            $riwayat_umd = RiwayatUMDModel::create([
                'tindakan' => $validatedData['tindakan'],
                'status' => $validatedData['status'],
                'peninjau' => $validatedData['peninjau'],
                'alasan' => $validatedData['alasan'],
                'umd_id' => $validatedData['umd_id'],
                'user_id' => auth()->user()->id
            ]);

            return response()->json([
                'message' => 'Data Berhasil Ditambahkan',
                new RiwayatUMDResource($riwayat_umd)
            ]);

        } catch (Exception $e) {
            return redirect()->back()->with(
                'alert',
                [
                    'type' => 'error',
                    'title' => 'Insert Riwayat Proposal',
                    'text' => $e->getMessage()
                ]
            );
        }
    }
}
