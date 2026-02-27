<?php

namespace App\Domain\KategoriAnggaran\Repositories\Adapter\Eloquent;

use App\Domain\KategoriAnggaran\DTO\KategoriAnggaran\LogKategoriAnggaranDTO;
use App\Models\LogKategoriAnggaran;

class LogKategoriAnggaranRepository

{
    public function simpan(LogKategoriAnggaranDTO $dto)
    {
        LogKategoriAnggaran::create([
            'user_id' => $dto->user_id,
            'kategori_anggaran_id' => $dto->kategori_anggaran,
            'keterangan' => $dto->keterangan
        ]);
    }
}
