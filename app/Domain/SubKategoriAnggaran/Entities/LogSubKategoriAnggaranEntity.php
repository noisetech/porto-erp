<?php

namespace App\Domain\SubKategoriAnggaran\Entities;

class LogSubKategoriAnggaranEntity
{

    public function __construct(
        public int $user_id,
        public int $kategori_anggaran,
        public string $keterangan,
    ) {}
}
