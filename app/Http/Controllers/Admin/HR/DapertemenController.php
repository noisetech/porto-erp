<?php

namespace App\Http\Controllers\Admin\HR;

use App\Http\Controllers\Controller;
use App\Models\Dapertemen;
use App\Models\LogDapertemen;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class DapertemenController extends Controller
{
    public function index()
    {
        return view('pages.admin.bagian-hr.dapertemen.index');
    }

    public function data(Request $request)
    {
        $start  = $request->start;
        $length = $request->length;
        $draw   = $request->draw;
        $search = $request->input('search.value');


        $query = DB::table('dapertemen')->where('deleted_at', null);
        $recordsTotal = $query->count();

        $baseQuery = (clone $query)->select('dapertemen.*');

        if ($search) {
            $baseQuery->where('nama_dapertemen', 'ILIKE', "%$search%");
        }

        $recordsFiltered = (clone $baseQuery)->count();

        $data = $baseQuery
            ->orderBy('dapertemen.nama_dapertemen', 'ASC')
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
                'kode'       => $row->kode,
                'nama_dapertemen'     => $row->nama_dapertemen,
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



    public function getDataById($id)
    {
        $dapertemen = Dapertemen::find($id);

        return response()->json([
            'status' => 'success',
            'message' => 'Berhasil menampilkan data',
            'data' => $dapertemen
        ], 200);
    }

    public function simpan(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'kode' => 'required|unique:dapertemen,kode',
            'nama_dapertemen' => 'required',
        ], [
            'kode.required' => 'Kode tidak boleh kosong',
            'kode.unique' => 'Kode sudah digunakan',
            'nama_dapertemen.required' => 'Nama dapertemen tidak boleh kosong',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors(),
            ], 422);
        }

        DB::beginTransaction();

        try {
            $dapertemen = new Dapertemen();
            $dapertemen->kode = $request->kode;
            $dapertemen->nama_dapertemen = $request->nama_dapertemen;
            $dapertemen->slug = Str::slug($request->nama_dapertemen);
            $dapertemen->save();


            $log_dapertemen = new LogDapertemen();
            $log_dapertemen->user_id = Auth::user()->id;
            $log_dapertemen->dapertemen_id = $dapertemen->id;
            $log_dapertemen->keterangan = "menambahkan data dapertemen";
            $log_dapertemen->save();

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

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'kode' => 'required|unique:dapertemen,kode,' . $request->id,
            'nama_dapertemen' => 'required',
        ], [
            'kode.required' => 'Kode tidak boleh kosong',
            'kode.unique' => 'Kode sudah digunakan',
            'nama_dapertemen.required' => 'Nama Dapertemen tidak boleh kosong',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors(),
            ], 422);
        }

        dd($request->all());

        DB::beginTransaction();

        try {
            $dapertemen = Dapertemen::find($request->id);
            $dapertemen->kode = $request->kode;
            $dapertemen->nama_dapertemen = $request->nama_dapertemen;
            $dapertemen->slug = Str::slug($request->nama_dapertemen);
            $dapertemen->save();

            $log_dapertemen = new LogDapertemen();
            $log_dapertemen->user_id = Auth::user()->id;
            $log_dapertemen->dapertemen_id = $dapertemen->id;
            $log_dapertemen->keterangan = "mengubah data dapertemen";
            $log_dapertemen->save();

            DB::commit();


            return response()->json([
                'status' => 'success',
                'message' => 'Data diubah'
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function hapus(Request $request)
    {
        $dapertemen = Dapertemen::find($request->id);

        $dapertemen->delete();

        $log_dapertemen = new LogDapertemen();
        $log_dapertemen->user_id = Auth::user()->id;
        $log_dapertemen->dapertemen_id = $dapertemen->id;
        $log_dapertemen->keterangan = "menghapus data dapertemen";
        $log_dapertemen->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Data dihapus'
        ], 200);
    }
}
