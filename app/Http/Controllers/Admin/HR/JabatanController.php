<?php

namespace App\Http\Controllers\Admin\HR;

use App\Http\Controllers\Controller;
use App\Models\Jabatan;
use App\Models\LogJabatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class JabatanController extends Controller
{
    public function index()
    {
        return view('pages.admin.bagian-hr.jabatan.index');
    }

    public function data(Request $request)
    {
        $start  = $request->start;
        $length = $request->length;
        $draw   = $request->draw;
        $search = $request->input('search.value');


        $query = DB::table('jabatan')
            ->join('dapertemen', 'dapertemen.id', '=', 'jabatan.dapertemen_id')
            ->where('jabatan.deleted_at', null);
        $recordsTotal = $query->count();

        $baseQuery = (clone $query)->select('jabatan.*', 'dapertemen.nama_dapertemen');

        if ($search) {
            $baseQuery->where('jabatan.jabatan', 'ILIKE', "%$search%");
        }

        $recordsFiltered = (clone $baseQuery)->count();

        $data = $baseQuery
            ->orderBy('jabatan.id', 'ASC')
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
                       href="#" id="hapus" data-id="' . $row->id . '">
                       <i class="bi bi-trash px-1"></i> Hapus
                    </a>';

            $result[] = [
                'no'       => $no++,
                'id'       => $row->id,
                'jabatan'     => $row->jabatan,
                'nama_dapertemen' => $row->nama_dapertemen,
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


    public function listDapertemen(Request $request)
    {
        if ($request->has('q')) {
            $search = $request->q;

            $result = [];
            $data = DB::table('dapertemen')
                ->select('*')
                ->where('dapertemen.deleted_at', null)
                ->where('nama_dapertemen', 'LIKE', "%$search%")
                ->get();

            foreach ($data as $d) {
                $result[] = [
                    'id' => $d->id,
                    'text' => $d->nama_dapertemen
                ];
            }

            return response()->json($result);
        } else {
            $result = [];
            $data = DB::table('dapertemen')
                ->select('*')
                ->where('dapertemen.deleted_at', null)
                ->get();

            foreach ($data as $d) {
                $result[] = [
                    'id' => $d->id,
                    'text' => $d->nama_dapertemen
                ];
            }

            return response()->json($result);
        }
    }


    public function simpan(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'dapertemen' => 'required',
            'jabatan' => 'required',
        ], [
            'dapertemen.required' => 'Dapertemen tidak boleh kosong',
            'jabatan.required' => 'Jabatan tidak boleh kosong',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }


        DB::beginTransaction();

        try {
            $jabatan = new Jabatan();
            $jabatan->dapertemen_id = $request->dapertemen;
            $jabatan->jabatan = $request->jabatan;
            $jabatan->slug = Str::slug($request->jabatan);
            $jabatan->save();

            $log_jabatan = new LogJabatan();
            $log_jabatan->user_id = Auth::user()->id;
            $log_jabatan->jabatan_id = $jabatan->id;
            $log_jabatan->keterangan = 'menambahkan data jabatan';
            $log_jabatan->save();

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
        $jabatan = Jabatan::with(['dapertemen'])->find($id);

        return response()->json([
            'status' => 'success',
            'message' => 'Data ditemukan',
            'data' => $jabatan
        ], 200);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'dapertemen' => 'required',
            'jabatan' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ]);
        }

        try {
            $jabatan = Jabatan::find($request->id);
            $jabatan->dapertemen_id = $request->dapertemen;
            $jabatan->jabatan = $request->jabatan;
            $jabatan->slug = Str::slug($request->jabatan);
            $jabatan->save();

            $log_jabatan = new LogJabatan();
            $log_jabatan->user_id = Auth::user()->id;
            $log_jabatan->jabatan_id = $jabatan->id;
            $log_jabatan->keterangan = 'mengubah data jabatan';
            $log_jabatan->save();

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Data diubah'
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

            $jabatan = Jabatan::find($request->id);
            $jabatan->delete();

            $log_jabatan = new LogJabatan();
            $log_jabatan->user_id = Auth::user()->id;
            $log_jabatan->jabatan_id = $jabatan->id;
            $log_jabatan->keterangan = 'menghapus data jabatan';
            $log_jabatan->save();

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Data dihapus',
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
