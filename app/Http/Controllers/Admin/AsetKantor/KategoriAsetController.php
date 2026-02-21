<?php

namespace App\Http\Controllers\Admin\AsetKantor;

use App\Http\Controllers\Controller;
use App\Models\KategoriAsetKantor;
use App\Models\LogKategoriAsetKantor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class KategoriAsetController extends Controller
{
    public function index()
    {
        return view('pages.admin.manajemen-aset-kantor.kategori-aset');
    }

    public function data(Request $request)
    {
        $start  = $request->start;
        $length = $request->length;
        $draw   = $request->draw;
        $search = $request->input('search.value');


        $query = DB::table('kategori_aset_kantor')->where('deleted_at', null);
        $recordsTotal = $query->count();

        $baseQuery = (clone $query)->select('kategori_aset_kantor.*');

        if ($search) {
            $baseQuery->where('kategori_aset', 'ILIKE', "%$search%");
        }

        $recordsFiltered = (clone $baseQuery)->count();

        $data = $baseQuery
            ->orderBy('kategori_aset_kantor.kategori_aset', 'ASC')
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
                'id'       => $row->id,
                'kategori_aset'       => $row->kategori_aset,
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
            'kategori_aset' => 'required',
        ], [
            'kategori_aset.required' => 'Kategori aset tidak boleh kosong',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors(),
            ], 422);
        }

        DB::beginTransaction();

        try {
            $kategori_aset_kantor = new KategoriAsetKantor();
            $kategori_aset_kantor->kategori_aset = $request->kategori_aset;
            $kategori_aset_kantor->slug = Str::slug($request->kategori_aset);
            $kategori_aset_kantor->save();


            $log_kategori_aset_kantor = new LogKategoriAsetKantor();
            $log_kategori_aset_kantor->user_id =  Auth::user()->id;
            $log_kategori_aset_kantor->kategori_aset_kantor_id = $kategori_aset_kantor->id;
            $log_kategori_aset_kantor->keterangan = 'menambahkan kategori aset kantor';
            $log_kategori_aset_kantor->save();

            DB::commit();

            return response()->json([
                'status' => 'success',
                'mesasge' => 'Data disimpan'
            ], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function getDataById($id)
    {
        $kategori_aset_kantor = KategoriAsetKantor::find($id);

        return response()->json([
            'status' => 'success',
            'message' => 'Data ditemukan',
            'data' => $kategori_aset_kantor
        ], 200);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'kategori_aset' => 'required',
        ], [
            'kategori_aset.required' => 'Kategori aset tidak boleh kosong',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors(),
            ], 422);
        }

        DB::beginTransaction();

        try {
            $kategori_aset_kantor = KategoriAsetKantor::find($request->id);
            $kategori_aset_kantor->kategori_aset = $request->kategori_aset;
            $kategori_aset_kantor->slug = Str::slug($request->kategori_aset);
            $kategori_aset_kantor->save();


            $log_kategori_aset_kantor = new LogKategoriAsetKantor();
            $log_kategori_aset_kantor->user_id =  Auth::user()->id;
            $log_kategori_aset_kantor->kategori_aset_kantor_id = $kategori_aset_kantor->id;
            $log_kategori_aset_kantor->keterangan = 'menambahkan kategori aset kantor';
            $log_kategori_aset_kantor->save();

            DB::commit();

            return response()->json([
                'status' => 'success',
                'mesasge' => 'Data diubah'
            ], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function hapus(Request $request)
    {
        $kategori_aset_kator = KategoriAsetKantor::find($request->id);

        $kategori_aset_kator->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Data dihapus',
            'data' => null
        ], 200);
    }
}
