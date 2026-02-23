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
        $length = $request->input('length', 10);
        $start  = $request->input('start', 0);
        $draw   = $request->input('draw', 1);
        $search = $request->input('search.value');

        /*
    |--------------------------------------------------------------------------
    | BASE QUERY (DATA UTAMA)
    |--------------------------------------------------------------------------
    */
        $baseQuery = DB::table('sub_kategori_anggaran')
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
                'sub_kategori_anggaran.created_at'
            );

        /*
    |--------------------------------------------------------------------------
    | TOTAL RECORD (tanpa filter)
    |--------------------------------------------------------------------------
    */
        $recordsTotal = DB::table('sub_kategori_anggaran')->count();

        /*
    |--------------------------------------------------------------------------
    | SEARCH FILTER
    |--------------------------------------------------------------------------
    */
        if (!empty($search)) {
            $baseQuery->where(function ($q) use ($search) {
                $q->where('sub_kategori_anggaran.nama_sub_kategori', 'ILIKE', "%{$search}%")
                    ->orWhere('coa.kode_akun', 'ILIKE', "%{$search}%");
            });
        }

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
                    ->orWhere('coa.kode_akun', 'ILIKE', "%{$search}%");
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

            // COA badge
            $coaHtml = '<div class="d-flex flex-wrap">';
            if (!empty($row->kode_akun_coa)) {
                foreach (explode(',', $row->kode_akun_coa) as $kode) {
                    $coaHtml .= '<span class="badge bg-primary text-white m-1">'
                        . e($kode) .
                        '</span>';
                }
            }
            $coaHtml .= '</div>';

            $action = '<a class="badge bg-secondary text-white"
                        data-id="' . $row->id . '"
                        id="hapus">
                        <i class="bi bi-trash2"></i> Hapus
                   </a>';

            $result[] = [
                'no'       => $no++,
                'id'     => $row->id,
                'kode'   => $row->kode_sub_kategori,
                'nama'   => $row->nama_sub_kategori,
                'keterangan' => $row->keterangan,
                'coa'    => $coaHtml,
                'action' => $action
            ];
        }

        /*
    |--------------------------------------------------------------------------
    | RESPONSE
    |--------------------------------------------------------------------------
    */
        return response()->json([
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

    public function getDataById($id) {}

    public function update(Request $request) {}

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
