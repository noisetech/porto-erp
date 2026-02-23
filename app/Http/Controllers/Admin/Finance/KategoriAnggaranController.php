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
    public function index()
    {
        return view('pages.finance.anggaran.kategori-anggaran');
    }

    public function data(Request $request)
    {
        $start  = $request->start;
        $length = $request->length;
        $draw   = $request->draw;
        $search = $request->input('search.value');


        $query = DB::table('kategori_anggaran')
            ->select('kategori_anggaran.*')
            ->where('kategori_anggaran.deleted_at', null);
        $recordsTotal = $query->count();

        if ($search) {
            $query->where('kategori_anggaran.kode_kategori', 'ILIKE', "%$search%");
        }

        $recordsFiltered = (clone $query)->count();

        $data = $query
            ->orderBy('kategori_anggaran.kode_kategori', 'ASC')
            ->skip($start)
            ->take($length)
            ->get();

        $result = [];
        $no = $start + 1;

        foreach ($data as $row) {

            $action =  '
                    <a class="btn btn-secondary text-sm text-white"
                       href="javascript:void(0)" id="hapus" data-id="' . $row->id . '">
                       <i class="bi bi-trash px-1"></i> Hapus
                    </a>';

            $result[] = [
                'no'       => $no++,
                'id'       => $row->id,
                'kode_kategori'       => $row->kode_kategori,
                'nama_kategori'     => $row->nama_kategori,
                'keterangan' => $row->keterangan,
                'aktif' => $row->aktif ? 'Ya' : 'Tidak',
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

        // dd($request->all());

        $validator = Validator::make($request->all(), [
            'nama_kategori' => 'required',
            'kode_kategori' => 'required',
            'keterangan' => 'required'
        ], [
            'nama_kategori.required' => 'Nama kategori tidak boleh kosong',
            'kode_kategori' => 'Kode kategori tidak boleh kosong',
            'keterangan.required' => 'Keterangan tidak boleh kosong'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'success',
                'errors' => $validator->errors()
            ], 422);
        }

        DB::beginTransaction();

        try {
            $kategori_anggaran = new KategoriAnggaran();
            $kategori_anggaran->kode_kategori = $request->kode_kategori;
            $kategori_anggaran->nama_kategori = $request->nama_kategori;
            $kategori_anggaran->keterangan = $request->keterangan;
            $kategori_anggaran->save();


            $log_kategori_anggaran = new LogKategoriAnggaran();
            $log_kategori_anggaran->user_id = Auth::user()->id;
            $log_kategori_anggaran->kategori_anggaran_id = $kategori_anggaran->id;
            $log_kategori_anggaran->keterangan = 'menambah data';
            $log_kategori_anggaran->save();

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

    public function hapus(Request $request)
    {
        DB::beginTransaction();

        try {
            $kategori_anggaran = KategoriAnggaran::findOrFail($request->id);
            $kategori_anggaran->delete();

            LogKategoriAnggaran::create([
                'user_id' => Auth::id(),
                'kategori_anggaran_id' => $request->id,
                'keterangan' => 'menghapus data'
            ]);

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Data dihapus'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
