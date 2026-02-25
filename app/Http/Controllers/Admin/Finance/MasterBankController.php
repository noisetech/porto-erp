<?php

namespace App\Http\Controllers\Admin\Finance;

use App\Http\Controllers\Controller;
use App\Http\Requests\MasterBankSimpanRequest;
use App\Http\Requests\MasterBankUpdateRequest;
use App\Services\MasterBankService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MasterBankController extends Controller
{

    protected MasterBankService $master_bank_service;

    public function __construct(MasterBankService $master_bank_service)
    {
        $this->master_bank_service = $master_bank_service;
    }

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

    public function simpan(MasterBankSimpanRequest $request)
    {
        try {
            $master_bank = $this->master_bank_service->simpan($request->validated());
            return response()->json([
                'status'  => 'success',
                'message' => 'Data disimpan',
                'data'    => $master_bank
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Gagal menyimpan data'
            ], 500);
        }
    }

    public function update(MasterBankUpdateRequest $request, int $id) {}

    public function hapus(Request $request) {}
}
