<?php

namespace App\Repositories\Query;

use App\DTO\KategoriAnggaran\LogKategoriAnggaranDTO;
use App\Models\LogKategoriAnggaran;

class QueryLogKategoriAnggaranRepository

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
