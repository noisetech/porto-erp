<?php

namespace App\Http\Controllers\Admin\Finance;

use App\Http\Controllers\Controller;
use App\Models\LogMasterBank;
use App\Models\MasterBank;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class MasterBankController extends Controller
{
    public function index()
    {
        return view('pages.finance.bank.manajemen-master-bank');
    }

    public function data(Request $request)
    {
        $start  = $request->start;
        $length = $request->length;
        $draw   = $request->draw;

        $query = DB::table('bank_master')->whereNull('deleted_at');
        $recordsTotal = $query->count();


        $recordsFiltered = (clone $query)->count();

        $data = $query
            ->orderBy('bank_master.created_at', 'ASC')
            ->skip($start)
            ->take($length)
            ->get();

        $result = [];
        $no = $start + 1;

        foreach ($data as $row) {
            $action = '-';
            $result[] = [
                'no'       => $no++,
                'id'       => $row->id,
                'kode_bank'       => $row->kode_bank,
                'nama_bank' => $row->nama_bank,
                'action'   => $action
            ];
        }

        return response()->json([
            "status" => 'success',
            'message' => 'Berhasil menampilkan data',
            "draw"            => intval($draw),
            "recordsTotal"    => $recordsTotal,
            "recordsFiltered" => $recordsFiltered,
            "data"            => $result
        ]);
    }

    public function simpan(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'kode_bank' => 'required',
            'nama_bank' => 'required'
        ], [
            'kode_bank.required' => 'Kode bank tidak boleh kosong',
            'nama_bank.required' => 'Nama bank tidak boleh kosong'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        DB::beginTransaction();

        try {
            $master_bank = new MasterBank();
            $master_bank->kode_bank = $request->kode_bank;
            $master_bank->nama_bank = $request->nama_bank;
            $master_bank->save();

            $log_master_bank = new LogMasterBank();
            $log_master_bank->user_id = Auth::user()->id;
            $log_master_bank->bank_master_id = $master_bank->id;
            $log_master_bank->keterangan = 'menambah data';
            $log_master_bank->save();

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

    public function hapus(Request $request) {}
}
