<?php

namespace App\Http\Controllers;

use App\Traits\RulesTraits;
use Exception;
use Illuminate\Http\Request;
use App\Models\RiwayatProposalModel;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\RiwayatProposalResource;

class RiwayatProposalController extends Controller
{
    use RulesTraits;
    public function store(Request $request)
    {
        try {
            $validatedData = Validator::make($request->all(), [
                'tindakan' => 'required|boolean',
                'status' => 'required|string',
                'peninjau' => 'required|string',
                'alasan' => 'required',
                'surat_balasan' => 'required|mimes:pdf,docx',
                'proposal_id' => 'required|exists:proposal,id'
            ], [
                'tindakan.required' => $this->requiredMessage('tindakan'),
                'status.required' => $this->requiredMessage('status'),
                'peninjau.required' => $this->requiredMessage('peninjau'),
                'alasan.required' => $this->requiredMessage('alasan'),
                'surat_balasan.required' => $this->requiredMessage('surat_balasan'),
                'surat_balasan.mimes' => $this->fileMessage(['pdf', 'docx']),
                'proposal_id.required' => $this->requiredMessage('proposal_id'),
                'proposal_id.exists' => $this->existsMessage('proposal_id'),
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

            $surat_balasan = $request->file('surat_penolakan');
            $filename = time() . '-' . str_replace(' ', '-', $surat_balasan->getClientOriginalName());
            $surat_balasan->storeAs('public/berkas/surat-balasan', $filename);

            $riwayat_proposal = RiwayatProposalModel::create([
                'tindakan' => $validatedData['tindakan'],
                'status' => $validatedData['status'],
                'peninjau' => $validatedData['peninjau'],
                'alasan' => $validatedData['alasan'],
                'surat_balasan' => $filename,
                'proposal_id' => $validatedData['proposal_id'],
                'user_id' => auth()->user()->id
            ]);

            return response()->json([
                'message' => 'Data berhasil ditambahkan',
                new RiwayatProposalResource($riwayat_proposal)
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
