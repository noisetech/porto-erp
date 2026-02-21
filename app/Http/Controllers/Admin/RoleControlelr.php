<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class RoleControlelr extends Controller
{
    public function index()
    {
        return view('pages.admin.role.index');
    }

    public function data(Request $request)
    {
        $start  = $request->start;
        $length = $request->length;
        $draw   = $request->draw;
        $search = $request->input('search.value');


        $query = DB::table('roles')->where('deleted_at', null);
        $recordsTotal = $query->count();

        $baseQuery = (clone $query)->select('roles.*');

        if ($search) {
            $baseQuery->where('name', 'ILIKE', "%$search%");
        }

        $recordsFiltered = (clone $baseQuery)->count();

        $data = $baseQuery
            ->orderBy('role.id', 'ASC')
            ->skip($start)
            ->take($length)
            ->get();

        $result = [];
        $no = $start + 1;

        foreach ($data as $row) {

            $action =  '<a class="btn btn-secondary text-sm text-white"
                       href="#">
                       <i class="bi bi-pencil px-1"></i> Edit
                    </a>
                    <a class="btn btn-secondary text-sm text-white"
                       href="#" id="hapus" data-id="' . $row->id . '">
                       <i class="bi bi-trash px-1"></i> Hapus
                    </a>';

            $result[] = [
                'no'       => $no++,
                'id'       => $row->id,
                'role'     => $row->nama,
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
            'nama' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'sttatus' => 'error',
                'errors' => $validator->errors(),
            ]);
        }


        $role = new Role();
        $role->name = $request->name;
        $role->guard_name = 'web';
        $role->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Data disimpan',
        ], 200);
    }

    public function getDataById($id)
    {
        $data = DB::table('role')->where('id', $id)->first();

        if (!empty($data)) {
            return response()->json([
                'status' => 'succes',
                'message' => 'data ditemukan',
                'data' => $data
            ], 200);
        }
        return response()->json([
            'status' => 'succes',
            'message' => 'data ditemukan',
            'data' => null
        ], 404);
    }


    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'sttatus' => 'error',
                'errors' => $validator->errors(),
            ]);
        }

        $role = new Role();
        $role->name = $request->name;
        $role->guard_name = 'web';
        $role->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Data diubah',
        ], status: 200);
    }

    public function hapus(Request $request)
    {
        $role = Role::find($request->id);

        if ($role) {
            $role->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Data dihapus'
            ], 200);
        }
    }
}
