<?php

namespace App\Http\Controllers\Admin\Finance;

use App\Http\Controllers\Controller;
use App\Models\KelompokAkunCoa;
use App\Models\LogKelompokCoa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class KelompokAkunCoaController extends Controller
{
    public function index()
    {
        return view('pages.finance.coa.manajemen-kelompok-coa');
    }

    public function data(Request $request)
    {
        $start  = $request->start;
        $length = $request->length;
        $draw   = $request->draw;
        $search = $request->input('search.value');

        // Query utama, join ke parent
        $query = DB::table('kelompok_akun_coa as k')
            ->leftJoin('kelompok_akun_coa as p', 'k.akun_induk_id', '=', 'p.id')
            ->whereNull('k.deleted_at')
            ->select(
                'k.*',
                'p.nama_kelompok as induk_akun'
            );

        $recordsTotal = $query->count();
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('k.nama_kelompok', 'ILIKE', "%$search%")
                    ->orWhere('k.kode_kelompok', 'ILIKE', "%$search%")
                    ->orWhere('p.nama_kelompok', 'ILIKE', "%$search%");
            });
        }

        $recordsFiltered = $query->count();

        $data = $query
            ->orderBy('k.created_at', 'ASC')
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
                'kode_kelompok'    => $row->kode_kelompok,
                'nama_kelompok'    => $row->nama_kelompok,
                'induk_akun'  => $induk_akun,
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


    public function listAkunIndukCoa(Request $request)
    {
        if ($request->has('q')) {
            $search = $request->q;

            $result = [];
            $data = DB::table('kelompok_akun_coa')
                ->select('kelompok_akun_coa.*')
                ->where('kelompok_akun_coa.deleted_at', null)
                ->where('kelompok_akun_coa.nama_kelompok', 'LIKE', "%$search%")
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
                ->select('kelompok_akun_coa.*')
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


    public function simpan(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'kode_kelompok' => 'required',
            'nama_kelompok' => 'required',
            'keterangan' => 'required'
        ], [
            'kode_kelompok.required' => 'Kode kelompok tidak boleh kosong',
            'nama_kelompok.required' => 'Nama kelompok tidak boleh kosong',
            'keterangan.required' => 'Keterangan tidak boleh kosong'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        DB::beginTransaction();

        try {
            $kelompok_akun_coa = new KelompokAkunCoa();
            $kelompok_akun_coa->kode_kelompok = $request->kode_kelompok;
            $kelompok_akun_coa->nama_kelompok = $request->nama_kelompok;
            $kelompok_akun_coa->keterangan = $request->keterangan;
            $kelompok_akun_coa->akun_induk_id = $request->akun_induk;
            $kelompok_akun_coa->save();

            $log_kelompok_akun_coa = new LogKelompokCoa();
            $log_kelompok_akun_coa->user_id = Auth::user()->id;
            $log_kelompok_akun_coa->kelompok_akun_coa_id = $kelompok_akun_coa->id;
            $log_kelompok_akun_coa->keterangan = 'menambahkan data kelompok coa';
            $log_kelompok_akun_coa->save();

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Data disimpan'
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => 'erorr',
                'message' > $e->getMessage()
            ], 500);
        }
    }

    public function hapus(Request $request)
    {

        DB::beginTransaction();
        try {
            $kelompok_akun_coa = KelompokAkunCoa::find($request->id);

            $kelompok_akun_coa->delete();

            $log_kelompok_akun_coa = new LogKelompokCoa();
            $log_kelompok_akun_coa->user_id = Auth::user()->id;
            $log_kelompok_akun_coa->kelompok_akun_coa_id = $kelompok_akun_coa->id;
            $log_kelompok_akun_coa->keterangan = 'menghapus data kelompok coa';
            $log_kelompok_akun_coa->save();

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Data dihapus'
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => 'erorr',
                'message' > $e->getMessage()
            ], 500);
        }
    }
}
