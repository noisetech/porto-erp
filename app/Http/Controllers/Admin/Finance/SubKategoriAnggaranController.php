<?php

namespace App\Http\Controllers\Admin\Finance;

use App\Http\Controllers\Controller;
use App\Models\LogSubKategoriAnggaran;
use App\Models\SubKategoriAnggaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class SubKategoriAnggaranController extends Controller
{
    public function index()
    {
        return view('pages.finance.anggaran.sub-kategori-anggaran');
    }

    public function data(Request $request) {}


    public function listKategoriAnggaran(Request $request)
    {
        if ($request->has('q')) {
            $search = $request->q;

            $result = [];
            $data = DB::table('kategori_anggaran')
                ->select(
                    'kategori_anggaran.id as id',
                    'kategori_anggaran.nama_kategori as nama_kategori',
                    'kategori_anggaran.kode_kategori as kode_kategori'
                )
                ->whereNull('deleted_at')
                ->where(
                    'kategori_anggaran.kode_kategori',
                    'LIKE',
                    "%$search%"
                )
                ->orWhere(
                    'kategori_anggaran.nama_kategori',
                    'LIKE',
                    "%$search%"
                )
                ->get();

            foreach ($data as $d) {
                $result[] = [
                    'id' => $d->id,
                    'text' => $d->kode_kategori . ' | ' . $d->nama_kategori
                ];
            }

            return response()->json($result);
        } else {
            $result = [];
            $data = DB::table('coa')
                ->select(
                    'kategori_anggaran.id as id',
                    'kategori_anggaran.nama_kategori as nama_kategori',
                    'kategori_anggaran.kode_kategori as kode_kategori'
                )
                ->whereNull('deleted_at')
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

    public function listCoa(Request $request)
    {
        if ($request->has('q')) {
            $search = $request->q;

            $result = [];
            $data = DB::table('coa')
                ->select('*')
                ->where('coa.deleted_at', null)
                ->where('coa.kode_akun', 'LIKE', "%$search%")
                ->orWhere('coa.nama_akun', 'LIKE', "%$search%")
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



    public function simpan(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'kategori_anggaran' => 'required',
            'kode' => 'required',
            'nama' => 'required',
            'keterangan' => 'required',
            'coa' => "required"
        ], [
            'kategori_anggaran.required' => 'Kategori anggaran tidak boleh kosong',
            'kode.required' => 'Kategori tidak boleh kosong',
            'nama.required' => 'Nama tidak boleh kosong',
            'keterangan.required' => 'Keterangan tidak boleh kosong',
            'coa.required' => 'Coa tidak boleh kosong'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        try {

            $sub_kategori_anggaran = new SubKategoriAnggaran();
            $sub_kategori_anggaran->kategori_anggaran_id = $request->kategori_anggaran;
            $sub_kategori_anggaran->kode_sub_kategori = $request->kode;
            $sub_kategori_anggaran->nama_sub_kategori = $request->nama;
            $sub_kategori_anggaran->keterangan = $request->keterangan;
            $sub_kategori_anggaran->save();

            $sub_kategori_anggaran->coa()->attach($request->coa);

            $log_sub_kategori_anggaran = new LogSubKategoriAnggaran();
            $log_sub_kategori_anggaran->user_id = Auth::user()->id;
            $log_sub_kategori_anggaran->sub_kategori_anggaran_id = $sub_kategori_anggaran->id;
            $log_sub_kategori_anggaran->keterangan = 'menambahkan data';
            $log_sub_kategori_anggaran->save();

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

    public function getDataById($id) {}

    public function update(Request $request) {}

    public function hapus(Request $request) {}
}
