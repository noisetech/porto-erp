<?php

namespace App\Services;

use App\Models\COA;
use App\Models\LogRekeningBank;
use App\Models\ModelMasterBank;
use App\Models\ModelRekeningBank;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RekeningBankService
{
    public function simpan(array $data): ModelRekeningBank
    {
        return DB::transaction(function () use ($data) {

            $rekeningBank = ModelRekeningBank::create([
                'bank_master_id' => $data['bank_master'],
                'coa_id'         => $data['coa'],
                'nama_rekening'  => $data['nama_rekening'],
                'nomor_rekening' => $data['nomor_rekening'],
                'nama_pemilik'   => $data['nama_pemilik'],
            ]);

            LogRekeningBank::create([
                'user_id'          => Auth::id(),
                'rekening_bank_id' => $rekeningBank->id,
                'keterangan'       => 'menambah data',
            ]);

            return $rekeningBank;
        });
    }

    public function listMasterBank(?string $search = null): array
    {
        $query = ModelMasterBank::query()->select('id', 'kode_bank', 'nama_bank');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('kode_bank', 'LIKE', "%{$search}%")
                    ->orWhere('nama_bank', 'LIKE', "%{$search}%");
            });
        }

        return $query->get()->map(function ($master_bank) {
            return [
                'id'   => $master_bank->id,
                'text' => $master_bank->kode_bank . ' | ' . $master_bank->nama_bank
            ];
        })->toArray();
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


    //  ini bisa balikan null data ketika menggunakan ? sebelum model
    public function getDataById(int $id): ?ModelRekeningBank
    {
        return ModelRekeningBank::with([
            'bank_master',
            'coa'
        ])
            ->where('id', $id)
            ->whereNull('deleted_at')
            ->first();
    }

    public function update(int $id, array $data): ModelRekeningBank
    {
        $rekening = ModelRekeningBank::find($id);

        if (!$rekening) {
            throw new ModelNotFoundException('Rekening bank tidak ditemukan');
        }

        $rekening->update([
            'bank_master_id' => $data['bank_master_id'],
            'coa_id'         => $data['coa_id'],
            'nama_rekening'  => $data['nama_rekening'],
            'nama_pemilik'   => $data['nama_pemilik'],
            'mata_uang'      => $data['mata_uang'] ?? 'IDR',
        ]);

        LogRekeningBank::create([
            'user_id' => Auth::user()->id,
            'rekening_bank_id' => $rekening->id,
            'keterangan' => 'mengubah data'
        ]);

        return $rekening;
    }
}
