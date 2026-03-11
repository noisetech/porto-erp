<?php

namespace App\Domain\SubKategoriAnggaran\Entities;

class LogSubKategoriAnggaranEntity
{
    public function __construct(
        public ?int $id,
        public int $user_id,
        public int $sub_kategori_anggaran_id,
        public string $keterangan
    ) {}
}
