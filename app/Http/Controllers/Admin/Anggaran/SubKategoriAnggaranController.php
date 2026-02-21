<?php

namespace App\Http\Controllers\Admin\Anggaran;

use App\Http\Controllers\Controller;
use App\Models\SubKategoriAnggaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class SubKategoriAnggaranController extends Controller
{
    public function index()
    {
        return view('pages.finance.anggaran.sub-kategori-anggaran.index');
    }

    public function data(Request $request)
    {
        $start  = $request->start;
        $length = $request->length;
        $draw   = $request->draw;
        $search = $request->input('search.value');


        $query = DB::table('sub_kategori_anggran')
            ->join('kategori_anggaran', 'sub_kategori_anggran.kategori_anggaran_id', '=', 'kategori_anggaran.id')
            ->where('sub_kategori_anggran.deleted_at', null);
        $recordsTotal = $query->count();

        $baseQuery = (clone $query)->select('sub_kategori_anggran.*', 'kategori_anggaran.kategori_anggaran as kategori_anggaran');

        if ($search) {
            $baseQuery->where('sub_kategori_anggran.nama_anggaran', 'ILIKE', "%$search%");
        }

        $recordsFiltered = (clone $baseQuery)->count();

        $data = $baseQuery
            ->orderBy('sub_kategori_anggran.id', 'ASC')
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
                'kategori_anggaran' => $row->kategori_anggaran,
                'nama_anggaran'       => $row->nama_anggaran,
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


    public function listKategoriAnggaran(Request $request)
    {
        if ($request->has('q')) {
            $search = $request->q;

            $result = [];
            $data = DB::table('kategori_anggaran')
                ->select('*')
                ->where('kategori_anggaran.deleted_at', null)
                ->get();

            foreach ($data as $d) {
                $result[] = [
                    'id' => $d->id,
                    'text' => $d->kategori_anggaran
                ];
            }

            return response()->json($result);
        } else {
            $result = [];
            $data = DB::table('kategori_anggaran')
                ->select('*')
                ->where('kategori_anggaran.deleted_at', null)
                ->get();

            foreach ($data as $d) {
                $result[] = [
                    'id' => $d->id,
                    'text' => $d->kategori_anggaran
                ];
            }

            return response()->json($result);
        }
    }


    public function simpan(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'kategori_anggaran' => 'required',
            'nama_sub_anggaran' => 'required',
            'komponen_sub_anggaran_error' => 'required'
        ], [
            'kategori_anggaran.required' => 'Kategori anggaran tidak boleh kosong',
            'nama_sub_anggaran.required' => 'Nama sub anggaran tidak boleh kosong',
            'komponen_sub_anggaran_error.required' => 'Komponen sub anggaran tidak boleh kosong',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors(),
            ], 422);
        }

        $sub_kategori_anggaran = new SubKategoriAnggaran();
    }

    public function getDataById(Request $request) {}

    public function update(Request $request) {}

    public function hapus(Request $request) {}
}
