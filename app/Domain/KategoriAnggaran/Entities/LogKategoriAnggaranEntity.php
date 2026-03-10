<?php

namespace App\Domain\KategoriAnggaran\Entities;

class LogKategoriAnggaranEntity
{
    public function __construct(
        private int $userId,
        private int $kategoriAnggaranId,
        private string $keterangan
    ) {}
}
