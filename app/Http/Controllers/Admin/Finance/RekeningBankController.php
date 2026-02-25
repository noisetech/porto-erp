<?php

namespace App\Http\Controllers\Admin\Finance;

use App\Http\Controllers\Controller;
use App\Http\Requests\RekeningSimpanRequet;
use App\Http\Requests\RekeningUpdateRequest;
use App\Services\RekeningBankService;
use Illuminate\Http\Request;

class RekeningBankController extends Controller
{
    protected RekeningBankService $rekening_bank_service;

    public function __construct(RekeningBankService $rekeningBankService)
    {
        $this->rekening_bank_service = $rekeningBankService;
    }
    public function simpan(RekeningSimpanRequet $request)
    {
        try {
            $rekeningBank = $this->rekening_bank_service->simpan($request->validated());
            return response()->json([
                'status'  => 'success',
                'message' => 'Data disimpan',
                'data'    => $rekeningBank
            ], 200);
        } catch (\Throwable $e) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Gagal menyimpan data'
            ], 500);
        }
    }


    public function listMasterBank(Request $request)
    {
        $master_bank = $this->rekening_bank_service->listMasterBank($request);

        return response()->json($master_bank);
    }

    public function index()
    {
        return view('pages.finance.bank.manajemen-rekening-bank');
    }


    public function getDataById($id)
    {
        $data = $this->rekening_bank_service->getDataById($id);

        if (!$data) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Data ditemukan',
            'data'   => $data
        ], 200);
    }

    public function update(RekeningUpdateRequest $request, $id)
    {
        try {
            $rekening = $this->rekening_bank_service->update($id, $request->validated());
            return response()->json([
                'status' => 'success',
                'message' => 'Data ditemukan',
                'data'   => $rekening
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function data(Request $request) {}


    public function listCoa(Request $request)
    {
        $coa =  $this->rekening_bank_service->listCoa($request);

        return response()->json($coa);
    }
}
