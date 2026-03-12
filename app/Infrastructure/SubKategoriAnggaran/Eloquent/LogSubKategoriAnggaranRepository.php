<?php

namespace App\Infrastructure\SubKategoriAnggaran\Eloquent;

use App\Domain\SubKategoriAnggaran\Entities\LogSubKategoriAnggaranEntity;
use App\Domain\SubKategoriAnggaran\Repositories\LogSubKategoriAnggaranRepositoryInterface;
use App\Models\LogSubKategoriAnggaran;

class LogSubKategoriAnggaranRepository implements LogSubKategoriAnggaranRepositoryInterface
{
    public function simpan(LogSubKategoriAnggaranEntity $entity): void
    {
        $model = LogSubKategoriAnggaran::create([
            'user_id' => $entity->userId(),
            'sub_kategori_anggaran_id' => $entity->subKategoriAnggaranId(),
            'keterangan' => $entity->keterangan()
        ]);
    }
}
