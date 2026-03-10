<?php

namespace App\Infrastructure\SubKategoriAnggaran\Eloquent;

use App\Applications\SubKategoriAnggaran\DTO\LogSubKategoriAnggaranDTO;
use App\Domain\SubKategoriAnggaran\Repositories\LogSubKategoriAnggaranRepositoryInterface;
use App\Models\LogKategoriAnggaran;

class LogSubKategoriAnggaranRepository implements LogSubKategoriAnggaranRepositoryInterface
{
    public function simpan(LogSubKategoriAnggaranDTO $dto): void
    {
        LogKategoriAnggaran::create([
            'user_id' => $dto->user_id,
            'kategori_anggaran_id' => $dto->kategori_anggaran,
            'keterangan' => $dto->keterangan
        ]);
    }
}
