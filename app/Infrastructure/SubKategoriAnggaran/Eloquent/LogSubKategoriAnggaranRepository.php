<?php

namespace App\Infrastructure\KategoriAnggaran\Eloquent;

use App\Domain\KategoriAnggaran\Entities\LogKategoriAnggaranEntity;
use App\Domain\SubKategoriAnggaran\Repositories\LogSubKategoriAnggaranRepositoryInterface;
use App\Models\LogSubKategoriAnggaran;

class LogSubKategoriAnggaranRepository implements LogSubKategoriAnggaranRepositoryInterface
{
    public function simpan(LogKategoriAnggaranEntity $log): void
    {
        LogSubKategoriAnggaran::create([
            'user_id' => $log->user_id,
            'kategori_anggaran_id' => $log->kategori_anggaran_id,
            'keterangan' => $log->keterangan
        ]);
    }
}
