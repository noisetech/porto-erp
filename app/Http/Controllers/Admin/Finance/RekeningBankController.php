<?php

namespace App\Http\Controllers\Admin\Finance;

use App\Http\Controllers\Controller;
use App\Models\RekeningBank;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class RekeningBankController extends Controller
{
    public function index()
    {
        return view('pages.finance.bank.manajemen-rekening-bank');
    }

    public function data(Request $request) {}

    public function listMasterBank(Request $request) {}

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
            $rekening_bank = new RekeningBank();

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

    public function update(Request $request) {}
}
