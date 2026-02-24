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

    public function data(Request $request)
    {
        $start  = (int) $request->start;
        $length = (int) $request->length;
        $draw   = (int) $request->draw;
        $search = $request->search['value'] ?? null;

        /*
    |--------------------------------------------------------------------------
    | BASE QUERY (DATA UTAMA)
    |--------------------------------------------------------------------------
    */
        $baseQuery = DB::table('sub_kategori_anggaran')
            ->join(
                'kategori_anggaran',
                'kategori_anggaran.id',
                '=',
                'sub_kategori_anggaran.kategori_anggaran_id'
            )
            ->leftJoin(
                'mapping_sub_kategori_coa',
                'sub_kategori_anggaran.id',
                '=',
                'mapping_sub_kategori_coa.sub_kategori_anggaran_id'
            )
            ->leftJoin(
                'coa',
                'coa.id',
                '=',
                'mapping_sub_kategori_coa.coa_id'
            )
            ->select(
                'sub_kategori_anggaran.id',
                'sub_kategori_anggaran.kode_sub_kategori',
                'sub_kategori_anggaran.nama_sub_kategori',
                'sub_kategori_anggaran.keterangan',
                'sub_kategori_anggaran.created_at',
                'kategori_anggaran.kode_kategori as kode_kategori_anggaran',
                DB::raw("
                STRING_AGG(
                    coa.kode_akun || ' | ' || coa.nama_akun,
                    ','
                ) as kode_akun_coa
            ")
            )
            ->whereNull('sub_kategori_anggaran.deleted_at')
            ->groupBy(
                'sub_kategori_anggaran.id',
                'sub_kategori_anggaran.kode_sub_kategori',
                'sub_kategori_anggaran.nama_sub_kategori',
                'sub_kategori_anggaran.keterangan',
                'sub_kategori_anggaran.created_at',
                'kategori_anggaran.kode_kategori'
            );

        /*
    |--------------------------------------------------------------------------
    | SEARCH FILTER
    |--------------------------------------------------------------------------
    */
        if (!empty($search)) {
            $baseQuery->where(function ($q) use ($search) {
                $q->where('sub_kategori_anggaran.nama_sub_kategori', 'ILIKE', "%{$search}%")
                    ->orWhere('coa.kode_akun', 'ILIKE', "%{$search}%")
                    ->orWhere('coa.nama_akun', 'ILIKE', "%{$search}%");
            });
        }

        /*
    |--------------------------------------------------------------------------
    | TOTAL RECORD (TANPA FILTER)
    |--------------------------------------------------------------------------
    */
        $recordsTotal = DB::table('sub_kategori_anggaran')
            ->whereNull('deleted_at')
            ->distinct('id')
            ->count('id');

        /*
    |--------------------------------------------------------------------------
    | RECORDS FILTERED
    |--------------------------------------------------------------------------
    */
        $filteredQuery = DB::table('sub_kategori_anggaran')
            ->leftJoin(
                'mapping_sub_kategori_coa',
                'sub_kategori_anggaran.id',
                '=',
                'mapping_sub_kategori_coa.sub_kategori_anggaran_id'
            )
            ->leftJoin(
                'coa',
                'coa.id',
                '=',
                'mapping_sub_kategori_coa.coa_id'
            )
            ->whereNull('sub_kategori_anggaran.deleted_at');

        if (!empty($search)) {
            $filteredQuery->where(function ($q) use ($search) {
                $q->where('sub_kategori_anggaran.nama_sub_kategori', 'ILIKE', "%{$search}%")
                    ->orWhere('coa.kode_akun', 'ILIKE', "%{$search}%")
                    ->orWhere('coa.nama_akun', 'ILIKE', "%{$search}%");
            });
        }

        $recordsFiltered = $filteredQuery
            ->distinct('sub_kategori_anggaran.id')
            ->count('sub_kategori_anggaran.id');

        /*
    |--------------------------------------------------------------------------
    | PAGINATION
    |--------------------------------------------------------------------------
    */
        $data = $baseQuery
            ->offset($start)
            ->limit($length)
            ->get();

        /*
    |--------------------------------------------------------------------------
    | FORMAT DATA
    |--------------------------------------------------------------------------
    */
        $result = [];
        $no = $start + 1;

        foreach ($data as $row) {

            $coaHtml = '-';

            if (!empty($row->kode_akun_coa)) {
                $coaHtml = '<div class="d-flex flex-wrap">';
                foreach (explode(',', $row->kode_akun_coa) as $item) {
                    $coaHtml .= '<span class="badge bg-primary text-white m-1">'
                        . e($item) .
                        '</span>';
                }
                $coaHtml .= '</div>';
            }

            $action = '
            <a class="badge bg-secondary text-white"
                    data-id="' . $row->id . '"
                    id="edit">
                    <i class="bi bi-pencil"></i> Edit
                   </a>
            <a class="badge bg-secondary text-white"
                    data-id="' . $row->id . '"
                    id="hapus">
                    <i class="bi bi-trash2"></i> Hapus
                   </a>';

            $result[] = [
                'no'                     => $no++,
                'id'                     => $row->id,
                'kode'                   => $row->kode_sub_kategori,
                'nama'                   => $row->nama_sub_kategori,
                'keterangan'             => $row->keterangan,
                'kode_kategori_anggaran' => $row->kode_kategori_anggaran,
                'coa'                    => $coaHtml,
                'action'                 => $action
            ];
        }

        /*
    |--------------------------------------------------------------------------
    | RESPONSE
    |--------------------------------------------------------------------------
    */
        return response()->json([
            "draw"            => $draw,
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
        ], [
            'kategori_anggaran.required' => 'Kategori anggaran tidak boleh kosong',
            'kode.required' => 'Kategori tidak boleh kosong',
            'nama.required' => 'Nama tidak boleh kosong',
            'keterangan.required' => 'Keterangan tidak boleh kosong',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        DB::beginTransaction();

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

    public function getDataById($id)
    {

        $rows = DB::table('sub_kategori_anggaran')
            ->join(
                'kategori_anggaran',
                'kategori_anggaran.id',
                '=',
                'sub_kategori_anggaran.kategori_anggaran_id'
            )
            ->leftJoin(
                'mapping_sub_kategori_coa',
                'sub_kategori_anggaran.id',
                '=',
                'mapping_sub_kategori_coa.sub_kategori_anggaran_id'
            )
            ->leftJoin(
                'coa',
                'coa.id',
                '=',
                'mapping_sub_kategori_coa.coa_id'
            )
            ->where('sub_kategori_anggaran.id', $id)
            ->whereNull('sub_kategori_anggaran.deleted_at')
            ->select(
                'sub_kategori_anggaran.id',
                'sub_kategori_anggaran.kode_sub_kategori',
                'sub_kategori_anggaran.nama_sub_kategori',
                'sub_kategori_anggaran.keterangan',
                'kategori_anggaran.kode_kategori as kode_kategori_anggaran',
                'kategori_anggaran.id as id_kategori_anggaran',
                'coa.id as coa_id',
                'coa.kode_akun',
                'coa.nama_akun'
            )
            ->get();

        if ($rows->isEmpty()) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        $first = $rows->first();

        $result = [
            'id_sub_kategori_anggaran'               => $first->id,
            'kode_sub_kategori_anggaran' => $first->kode_sub_kategori,
            'nama_sub_kategori_angaran' => $first->nama_sub_kategori,
            'keterangan_sub_kategori_anggaran'       => $first->keterangan,
            'kategori_anggaran' => [
                'id_kategori_anggaran' => $first->id_kategori_anggaran,
                'kode_kategori_anggaran' => $first->kode_kategori_anggaran
            ],
            'coa' => []
        ];

        foreach ($rows as $row) {
            if ($row->coa_id) {
                $result['coa'][] = [
                    'id'        => $row->coa_id,
                    'kode_akun_coa' => $row->kode_akun,
                    'nama_akun_coa' => $row->nama_akun
                ];
            }
        }

        return response()->json([
            'status' => 'success',
            'mesage' => 'Data ditemukan',
            'data' => $result
        ], 200, [], JSON_UNESCAPED_SLASHES);
    }

    public function update(Request $request) {
        
    }

    public function hapus(Request $request)
    {
        DB::beginTransaction();

        try {
            $subKategori = SubKategoriAnggaran::findOrFail($request->id);


            $subKategori->coa()->detach();

            $log_sub_kategori_anggaran = new LogSubKategoriAnggaran();
            $log_sub_kategori_anggaran->user_id = Auth::user()->id;
            $log_sub_kategori_anggaran->sub_kategori_anggaran_id = $subKategori->id;
            $log_sub_kategori_anggaran->keterangan = 'menghapus data';
            $log_sub_kategori_anggaran->save();

            $subKategori->delete();

            DB::commit();

            return response()->json([
                'status'  => 'success',
                'message' => 'Data berhasil dihapus'
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'status'  => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
