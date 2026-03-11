<?php

namespace App\Infrastructure\SubKategoriAnggaran\Eloquent;

use App\Domain\SubKategoriAnggaran\Entities\LogSubKategoriAnggaranEntity;
use App\Domain\SubKategoriAnggaran\Repositories\LogSubKategoriAnggaranRepositoryInterface;
use App\Models\LogSubKategoriAnggaran;

class LogSubKategoriAnggaranRepository implements LogSubKategoriAnggaranRepositoryInterface
{
    public function simpan(LogSubKategoriAnggaranEntity $log): void
    {
        LogSubKategoriAnggaran::create([
            'user_id' => $log->user_id,
            'sub_kategori_anggaran_id' => $log->sub_kategori_anggaran_id,
            'keterangan' => $log->keterangan
        ]);
    }
}
