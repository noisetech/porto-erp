<?php

namespace App\Domain\KategoriAnggaran\Entities;

class LogKategoriAnggaranEntity
{
    public function __construct(
        public ?int $id,
        public int $user_id,
        public int $kategori_anggaran_id,
        public string $keterangan
    ) {}
}
