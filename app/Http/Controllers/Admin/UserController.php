<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index() {}

    public function simpan(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
            'role' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            $users = DB::table('users')->insertGetId([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);


            DB::table('user_role')
                ->insert([
                    'user_id' => $users,
                    'role_id' => $request->role
                ]);

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Data disimpan',
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function getDataById($id)
    {
        $user = DB::table('users')
            ->select('users.*', 'roles.role')
            ->join('users_role', 'users.role.id', '=', 'user_role.user_id')
            ->join('role', 'role.id', '=', 'users_role.role_id')
            ->first();

        if ($user) {
            return response()->json([
                'status' => 'success',
                'message' => 'Berhasil menampilkan data',
                'data' => $user
            ]);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Data user gagal ditampilkan',
            'data' => null
        ]);
    }


    public function  update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
            'role' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            $users = DB::table('users')->where('id', $request->id)->first();

            if (!empty($request->password)) {
                DB::table('users')
                    ->update([
                        'name' => $request->name,
                        'email' => $request->email,
                        'password' => Hash::make($request->password),
                    ]);
            }

            DB::table('users')
            ->update([
                'name' => $request->name,
                'email' => $request->email,
            ]);

            DB::table('user_role')
            ->where('user_id', $users->id)
            ->update([
                'role_id' => $request->role
            ]);


            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Data disimpan',
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
        $users = DB::table('users')->where('id', $request->id)->first();

        if (!empty($users)) {
            $users->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Data disimpan'
            ], 200);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Terjadi kesahalan'
        ], 500);
    }
}
