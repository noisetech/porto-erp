<?php

namespace App\Infrastructure\KategoriAnggaran\Eloquent;

use App\Domain\KategoriAnggaran\Entities\LogKategoriAnggaranEntity;
use App\Domain\KategoriAnggaran\Repositories\LogKategoriAnggaranRepositoryInterface;
use App\Models\LogKategoriAnggaran;

class LogKategoriAnggaranRepository implements LogKategoriAnggaranRepositoryInterface
{
    public function simpan(LogKategoriAnggaranEntity $log): void
    {
        LogKategoriAnggaran::create([
            'user_id' => $log->user_id,
            'kategori_anggaran_id' => $log->kategori_anggaran_id,
            'keterangan' => $log->keterangan
        ]);
    }
}
