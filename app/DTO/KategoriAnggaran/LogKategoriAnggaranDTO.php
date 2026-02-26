<?php

namespace App\DTO\KategoriAnggaran;


class LogKategoriAnggaranDTO
{
    public function __construct(
        public int $user_id,
        public int $kategori_anggaran,
        public string $keterangan,
    ) {}

    public static function formArray(array $data): self
    {
        return new self(
            user_id: $data['user_id'],
            kategori_anggaran: $data['kategori_anggaran'],
            keterangan: $data['keterangan'],
        );
    }
}
