<?php

namespace App\Http\Controllers\Admin\Finance;

use App\Http\Controllers\Controller;
use App\Models\LogPeriodeAnggaran;
use App\Models\MasterPeriodeAnggaran;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class MasterPeriodeAnggaranController extends Controller
{
    public function index()
    {
        return view('pages.finance.anggaran.master-periode-anggaran');
    }

    public function data(Request $request)
    {
        $start  = $request->start;
        $length = $request->length;
        $draw   = $request->draw;

        $query = DB::table('master_periode_anggaran')->whereNull('deleted_at');
        $recordsTotal = $query->count();


        $recordsFiltered = (clone $query)->count();

        $data = $query
            ->orderBy('master_periode_anggaran.created_at', 'ASC')
            ->skip($start)
            ->take($length)
            ->get();

        $result = [];
        $no = $start + 1;

        foreach ($data as $row) {

            // $action =  '<a class="btn btn-secondary text-sm text-white"
            //            href="javascript:void(0)" id="edit" data-id="' . $row->id . '">
            //            <i class="bi bi-pencil px-1"></i> Edit
            //         </a>
            //         <a class="btn btn-secondary text-sm text-white"
            //            href="javascript:void(0)" id="hapus" data-id="' . $row->id . '">
            //            <i class="bi bi-trash px-1"></i> Hapus
            //         </a>';

            $action = '-';

            if ($row->status == 'draf') {
                $status = '  <span class="badge bg-danger text-white"> ' .  Str::ucfirst($row->status) . '
                   </span>';
            }

            $result[] = [
                'no'       => $no++,
                'id'       => $row->id,
                'tahun'       => $row->tahun,
                'status' => $status,
                'tanggal_mulai' => Carbon::parse($row->tanggal_mulai)->format('d-m-Y'),
                'tanggal_selesai' => Carbon::parse($row->tanggal_selesai)->format('d-m-Y'),
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
            'tahun' => 'required',
            'tanggal_mulai' => 'required',
            'tanggal_selesai' => 'required',
        ], [
            'tahun.required' => 'Tahun tidak boleh kosong',
            'tanggal_mulai.required' => 'Tanggal mulai tidak boleh kosong',
            'tanggal_selesai.required' => 'Tanggal selesai tidak boleh kosong'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors(),
            ], 422);
        }

        DB::beginTransaction();

        try {

            $periode_anggaran = new MasterPeriodeAnggaran();
            $periode_anggaran->tahun = $request->tahun;
            $periode_anggaran->tanggal_mulai = $request->tanggal_mulai;
            $periode_anggaran->tanggal_selesai = $request->tanggal_selesai;
            $periode_anggaran->save();

            $log_periode_anggaran = new LogPeriodeAnggaran();
            $log_periode_anggaran->user_id = Auth::user()->id;
            $log_periode_anggaran->master_periode_anggaran_id = $periode_anggaran->id;
            $log_periode_anggaran->keterangan = 'menambah data';
            $log_periode_anggaran->save();

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
            ]);
        }
    }

    public function hapus(Request $request) {}
}
