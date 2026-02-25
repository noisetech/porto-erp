<?php

namespace App\Services;

use App\Models\LogMasterBank;
use App\Models\ModelMasterBank;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MasterBankService
{
    public function simpan(array $data): ModelMasterBank
    {
        return DB::transaction(function () use ($data) {

            $master_bank = ModelMasterBank::create([
                'kode_bank'  => $data['kode_bank'],
                'nomor_rekening' => $data['nama_bank'],
            ]);

            LogMasterBank::create([
                'user_id'          => Auth::id(),
                'master_bank_id' => $master_bank->id,
                'keterangan'       => 'menambah data',
            ]);

            return $master_bank;
        });
    }

    public function update(int $id, array $data): ModelMasterBank
    {
        $master_bank = ModelMasterBank::find($id);

        if (!$master_bank) {
            throw new ModelNotFoundException('Rekening bank tidak ditemukan');
        }

        $master_bank->update([
            'bank_master_id' => $data['bank_master_id'],
            'coa_id'         => $data['coa_id'],
            'nama_rekening'  => $data['nama_rekening'],
            'nama_pemilik'   => $data['nama_pemilik'],
            'mata_uang'      => $data['mata_uang'] ?? 'IDR',
        ]);

        LogMasterBank::create([
            'user_id' => Auth::user()->id,
            'rekening_bank_id' => $master_bank->id,
            'keterangan' => 'mengubah data'
        ]);

        return $master_bank;
    }
}
