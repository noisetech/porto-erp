<?php

namespace App\Http\Controllers\Admin\Anggaran;

use App\Http\Controllers\Controller;
use App\Models\KategoriAnggaran;
use App\Models\KategriAnggaran;
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
        return view('pages.finance.anggaran.kategori-anggaran.index');
    }

    public function data(Request $request)
    {
        $start  = $request->start;
        $length = $request->length;
        $draw   = $request->draw;
        $search = $request->input('search.value');


        $query = DB::table('kategori_anggaran')->where('deleted_at', null);
        $recordsTotal = $query->count();

        $baseQuery = (clone $query)->select('kategori_anggaran.*');

        if ($search) {
            $baseQuery->where('kategori_anggaran', 'ILIKE', "%$search%");
        }

        $recordsFiltered = (clone $baseQuery)->count();

        $data = $baseQuery
            ->orderBy('kategori_anggaran.id', 'ASC')
            ->skip($start)
            ->take($length)
            ->get();

        $result = [];
        $no = $start + 1;

        foreach ($data as $row) {

            $action =  '<a class="btn btn-secondary text-sm text-white"
                       href="javascript:void(0)" id="edit" data-id="' . $row->id . '">
                       <i class="bi bi-pencil px-1"></i> Edit
                    </a>
                    <a class="btn btn-secondary text-sm text-white"
                       href="javascript:void(0)" id="hapus" data-id="' . $row->id . '">
                       <i class="bi bi-trash px-1"></i> Hapus
                    </a>';

            $result[] = [
                'no'       => $no++,
                'kategori_anggaran'       => $row->kategori_anggaran,
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
            'kategori_anggaran' => 'required'
        ], [
            'kategori_anggaran.required' => 'Kategori anggaran tidak boleh kosong'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors(),
            ], 422);
        }

        DB::beginTransaction();

        try {
            $kategori_anggaran = new KategoriAnggaran();
            $kategori_anggaran->kategori_anggaran = $request->kategori_anggaran;
            $kategori_anggaran->slug = Str::slug($request->kategori_anggaran);
            $kategori_anggaran->save();

            $log_kategori_anggaran = new LogKategoriAnggaran();
            $log_kategori_anggaran->user_id = Auth::user()->id;
            $log_kategori_anggaran->kategori_anggaran_id = $kategori_anggaran->id;
            $log_kategori_anggaran->keterangan = 'menambahkan kategori angggaran';
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
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function getDataById(Request $request)
    {
        $kategori_anggaran = KategoriAnggaran::find($request->id);

        if ($kategori_anggaran) {
            return response()->json([
                'status' => 'success',
                'message' => 'Berhasil menampilkan data',
                'data' => $kategori_anggaran
            ], 200);
        }
    }

    public function update(Request $request) {}

    public function hapus(Request $request)
    {
        try {
            $kategori_anggaran = KategoriAnggaran::find($request->id);

            $kategori_anggaran->delete();

            $log_kategori_anggaran = new LogKategoriAnggaran();
            $log_kategori_anggaran->user_id = Auth::user()->id;
            $log_kategori_anggaran->kategori_anggaran_id = $kategori_anggaran->id;
            $log_kategori_anggaran->keterangan = 'menambahkan kategori angggaran';
            $log_kategori_anggaran->save();

            DB::commit();


            return response()->json([
                'status' => 'success',
                'message' => 'Data dihapus'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
