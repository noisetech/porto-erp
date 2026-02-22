<?php

namespace App\Http\Controllers\Admin\Finance;

use App\Http\Controllers\Controller;
use App\Models\KategoriAnggaran;
use App\Models\LogKategoriAnggaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class KategoriAnggaranController extends Controller
{
    public function index() {}

    public function data(Request $request) {}

    public function simpan(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'kode_kategori' => 'required',
            'nama_kategori' => 'required',
            'coa' => 'required',
        ], [
            'kode_kategori.required' => 'Kode kategori tidak boleh kosong',
            'nama_kategori.required' => 'Nama kategori tidak boleh kosong',
            'coa.required' => 'Coa tidak boleh kosong'
        ]);

        DB::beginTransaction();

        try {

            $kategori_anggaran = DB::table('kategori_anggaran')
                ->insertGetId([
                    'kode_kategori' => $request->kode_kategori,
                    'nama_kategori' => $request->nama_kategori,
                    'slug' => Str::slug($request->nama_kategori),
                    'keterangan' => $request->keterangan
                ]);

            DB::table('log_kategori_anggaran')
                ->insert([
                    'kategori_anggaran_id' => $kategori_anggaran,
                    'user_id' => Auth::user()->id,
                    'keterangan' => 'menambah data'
                ]);
            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Data disimpan',
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function listCoa(Request $request)
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

    public function getDataByID($id) {}

    public function update(Request $request) {}

    public function hapus(Request $request)
    {
        DB::beginTransaction();

        try {

            $kategori_anggaran = KategoriAnggaran::find($request->id);
            $kategori_anggaran->delete();

            $log_kategori_anggaran = new LogKategoriAnggaran();
            $log_kategori_anggaran->user_id = Auth::user()->id;
            $log_kategori_anggaran->kategori_anggaran = $kategori_anggaran->id;
            $log_kategori_anggaran->keterangan = 'menghapus data';
            $log_kategori_anggaran->save();

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Data disimpan',
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
