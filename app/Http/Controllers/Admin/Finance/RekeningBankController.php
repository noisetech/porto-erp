<?php

namespace App\Http\Controllers\Admin\Finance;

use App\Http\Controllers\Controller;
use App\Models\LogRekeningBank;
use App\Models\RekeningBank;
use App\Services\RekeningBankService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class RekeningBankController extends Controller
{
    protected RekeningBankService $rekening_bank_service;

    public function __construct(RekeningBankService $rekeningBankService)
    {
        $this->rekening_bank_service = $rekeningBankService;
    }

    public function index()
    {
        return view('pages.finance.bank.manajemen-rekening-bank');
    }

    public function data(Request $request) {}

    public function listMasterBank(Request $request)
    {
        $master_bank = $this->rekening_bank_service->listMasterBank($request);

        return response()->json($master_bank);
    }

    public function listCoa(Request $request)
    {
        $coa =  $this->rekening_bank_service->listCoa($request);

        return response()->json($coa);
    }

    public function simpan(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'bank' => 'required',
            'coa' => 'required',
            'nama_rekening' => 'required',
            'nomor_rekening' => 'required',
            'nama_pemilik' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        DB::beginTransaction();

        try {
            $this->rekening_bank_service->simpan($request->all());

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Data disimpan'
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
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

    public function update(Request $request) {}
}
