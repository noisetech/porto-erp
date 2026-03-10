<?php

namespace App\Infrastructure\KategoriAnggaran\Eloquent;

use App\Domain\KategoriAnggaran\Repositories\LogKategoriAnggaranRepositoryInterface;
use App\Applications\KategoriAnggaran\DTO\LogKategoriAnggaranDTO;
use App\Models\LogKategoriAnggaran;

class LogKategoriAnggaranRepository implements LogKategoriAnggaranRepositoryInterface
{
    public function simpan(LogKategoriAnggaranDTO $dto): void
    {
        LogKategoriAnggaran::create([
            'user_id' => $dto->user_id,
            'kategori_anggaran_id' => $dto->kategori_anggaran,
            'keterangan' => $dto->keterangan
        ]);
    }
}
