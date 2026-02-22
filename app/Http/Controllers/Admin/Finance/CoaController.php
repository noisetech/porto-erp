<?php

namespace App\Http\Controllers\Admin\Finance;

use App\Http\Controllers\Controller;
use App\Models\COA;
use App\Models\LogCoa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class CoaController extends Controller
{
    public function index()
    {
        return view('pages.finance.coa.manajemen-coa');
    }

    public function data(Request $request) {}

    public function simpan(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'kode_akun' => 'required|unique:coa,kode_akun',
            'nama_akun' => 'required',
            'jenis_akun' => 'required',
        ], [
            'kode_akun.required' => 'Kode akun tidak boleh kosong',
            'kode_akun.unique' => 'Kode akun sudah ada',
            'jenis_akun.required' => 'Jenis akun tidak boleh kosong'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors(),
            ], 422);
        }

        DB::beginTransaction();

        try {
            $coa = new COA();
            $coa->kode_akun = $request->kode_akun;
            $coa->nama_akun = $request->nama_akun;
            $coa->slug = Str::slug($request->nama_akun);
            $coa->save();

            $log_coa = new LogCoa();
            $log_coa->coa_id = $coa->id;
            $log_coa->user_id = Auth::user()->id;
            $log_coa->keterangan = 'menambah data coa';
            $log_coa->save();

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Data disimpan'
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }


    public function listAkunIndukCoa(Request $request)
    {
        if ($request->has('q')) {
            $search = $request->q;

            $result = [];
            $data = DB::table('coa')
                ->select('*')
                ->where('coa.deleted_at', null)
                ->where('coa.kode_akun', 'LIKE', "%$search%")
                ->get();

            foreach ($data as $d) {
                $result[] = [
                    'id' => $d->id,
                    'text' => $d->kode_akun . ' | ' . $d->nama_akun
                ];
            }

            return response()->json($result);
        } else {
            $result = [];
            $data = DB::table('coa')
                ->select('*')
                ->where('coa.deleted_at', null)
                ->get();


            foreach ($data as $d) {
                $result[] = [
                    'id' => $d->id,
                    'text' => $d->kode_akun . ' | ' . $d->nama_akun
                ];
            }

            return response()->json($result);
        }
    }
}
