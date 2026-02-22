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

    public function data(Request $request)
    {
        $start  = $request->start;
        $length = $request->length;
        $draw   = $request->draw;

        $search = $request->input('search.value');
        $query = DB::table('coa as k')
            ->join('kelompok_akun_coa', 'kelompok_akun_coa.id', '=', 'k.kelompok_akun_coa_id')
            ->leftJoin('coa as p', 'k.akun_induk_id', '=', 'p.id')
            ->where('k.deleted_at', null)
            ->select(
                'k.*',
                'kelompok_akun_coa.kode_kelompok as kode_kelompok',
                'p.kode_akun as induk_akun'
            )
            ->orderByRaw('COALESCE(p.kode_akun, k.kode_akun)');

        $recordsTotal = $query->count();
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('k.kode_akun', 'ILIKE', "%$search%")
                    ->orWhere('k.nama_akun', 'ILIKE', "%$search%")
                    ->orWhere('p.nama_kelompok', 'ILIKE', "%$search%");
            });
        }

        $recordsFiltered = $query->count();

        $data = $query
            // ->orderBy('k.kode_akun', 'ASC')
            ->skip($start)
            ->take($length)
            ->get();

        $result = [];
        $no = $start + 1;

        foreach ($data as $row) {

            $induk_akun = $row->induk_akun ? $row->induk_akun : '-';

            $action =  '
                    <a class="btn btn-secondary text-sm text-white"
                       href="javascript:void(0)" id="hapus" data-id="' . $row->id . '">
                       <i class="bi bi-trash px-1"></i> Hapus
                    </a>';

            $result[] = [
                'no'               => $no++,
                'id'               => $row->id,
                'kode_akun'    => $row->kode_akun,
                'nama_akun'    => $row->nama_akun,
                'induk_akun'  => $induk_akun,
                'jenis_akun' => $row->jenis_akun,
                'kelompok_akun' => $row->kode_kelompok,
                'keterangan'       => $row->keterangan,
                'aktif'            => $row->aktif ? 'Ya' : 'Tidak',
                'action'           => $action
            ];
        }

        return response()->json([
            "status"          => 'success',
            'message'         => 'Berhasil menampilkan data',
            "draw"            => intval($draw),
            "recordsTotal"    => $recordsTotal,
            "recordsFiltered" => $recordsFiltered,
            "data"            => $result
        ]);
    }


    public function simpan(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'kode_akun' => 'required|unique:coa,kode_akun',
            'nama_akun' => 'required',
            'jenis_akun' => 'required',
            'kelompok_akun' => 'required',
            'keterangan' => 'required'
        ], [
            'kode_akun.required' => 'Kode akun tidak boleh kosong',
            'kode_akun.unique' => 'Kode akun sudah ada',
            'nama_akun.required' => 'Nama akun tidak boleh kosong',
            'jenis_akun.required' => 'Jenis akun tidak boleh kosong',
            'kelompok_akun.required' => 'Kelompok akun tidak boleh kosong',
            'keterangan.required' => 'Keterangan tidak boleh kosong'
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
            $coa->jenis_akun = $request->jenis_akun;
            $coa->kelompok_akun_coa_id = $request->kelompok_akun;
            $coa->akun_induk_id = $request->akun_induk;
            $coa->keterangan = $request->keterangan;
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


    public function listKelompokAkun(Request $request)
    {
        if ($request->has('q')) {
            $search = $request->q;

            $result = [];
            $data = DB::table('kelompok_akun_coa')
                ->select('*')
                ->where('kelompok_akun_coa.deleted_at', null)
                ->where('kelompok_akun_coa.kode_kelompok', 'LIKE', "%$search%")
                ->get();

            foreach ($data as $d) {
                $result[] = [
                    'id' => $d->id,
                    'text' => $d->kode_kelompok . ' | ' . $d->nama_kelompok
                ];
            }

            return response()->json($result);
        } else {
            $result = [];
            $data = DB::table('kelompok_akun_coa')
                ->select('*')
                ->where('kelompok_akun_coa.deleted_at', null)
                ->get();


            foreach ($data as $d) {
                $result[] = [
                    'id' => $d->id,
                    'text' => $d->kode_kelompok . ' | ' . $d->nama_kelompok
                ];
            }

            return response()->json($result);
        }
    }


    public function hapu(Request $request)
    {
        $coa = COA::find($request->id);

        if ($coa) {
            DB::beginTransaction();

            try {
                $coa->delete();

                $log_coa = new LogCoa();
                $log_coa->user_id = Auth::user()->id;
                $log_coa->coa_id = $coa->id;
                $log_coa->keterangan = 'menghapus data';

                return response()->json([
                    'status' => 'success',
                    'message' => 'Data dihapus'
                ], 200);
            } catch (\Exception $e) {
                DB::rollBack();

                return response()->json([
                    'status' => 'success',
                    'message' => $e->getMessage()
                ], 500);
            }
        }
    }
}
