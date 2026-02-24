<?php

namespace App\Services;

use App\Models\COA;
use App\Models\RekeningBank;
use App\Models\LogRekeningBank;
use App\Models\MasterBank;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RekeningBankService
{
    public function simpan(array $data): RekeningBank
    {
        return DB::transaction(function () use ($data) {

            $rekeningBank = RekeningBank::create([
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
        $query = MasterBank::query()->select('id', 'kode_bank', 'nama_bank');

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
    public function getDataById(int $id): ?RekeningBank
    {
        return RekeningBank::with([
            'bank_master',
            'coa'
        ])
            ->where('id', $id)
            ->whereNull('deleted_at')
            ->first();
    }

    public function hapus(int $id){

    }
}
