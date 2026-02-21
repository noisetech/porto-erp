<?php

use Illuminate\Support\Facades\DB;

if (!function_exists('cek_role_user')) {
    function cek_role_user($userId, $roles = [])
    {
        $user = DB::table('users')
            ->select(
                'users.id',
                DB::raw("STRING_AGG(role.role, ',') as role_name")
            )
            ->join('user_role', 'users.id', '=', 'user_role.user_id')
            ->join('role', 'role.id', '=', 'user_role.role_id')
            ->where('users.id', $userId)
            ->groupBy('users.id')
            ->first();

        if (!$user) {
            return false;
        }

        $userRoles = explode(',', $user->role_name);

        if (empty($roles)) {
            return $userRoles;
        }

        return count(array_intersect($userRoles, (array) $roles)) > 0;
    }
}

