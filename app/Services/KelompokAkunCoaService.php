<?php

namespace App\Services;

use App\Models\COA;
use App\Models\LogKelompokCoa;
use App\Models\ModelKelompokAkunnCoa;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class KelompokAkunCoaService
{
    public function simpan(array $data): ModelKelompokAkunnCoa
    {
        return DB::transaction(function () use ($data) {

            $kelompok_akun_coa = ModelKelompokAkunnCoa::create([
                'kode_kelompok' => $data['kode_kelompok'],
                'nama_kelompok' => $data['nama_kelompok'],
                'keterangan' => $data['keterangan'],
                'akun_induk_id' => $data['akun_induk']
            ]);

            LogKelompokCoa::create([
                'kelompok_akun_coa_id' => $kelompok_akun_coa->id,
                'user_id' => Auth::user()->id,
                'keterangan' => 'menambahkan data'
            ]);
            return $kelompok_akun_coa;
        });
    }

    public function listCoa(?string $search = null): array
    {
        $query = COA::query()->select('id', 'kode_akun', 'nama_akun');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('kode_akun', 'LIKE', "%{$search}%")
                    ->orWhere('nama_akun', 'LIKE', "%{$search}%");
            });
        }

        return $query->get()->map(function ($coa) {
            return [
                'id'   => $coa->id,
                'text' => $coa->kode_akun . ' | ' . $coa->nama_akun
            ];
        })->toArray();
    }
}
