<?php

namespace App\Applications\SubKategoriAnggaran\DTO;


class LogSubKategoriAnggaranDTO
{
    public function __construct(
        public ?int $id,
        public int $user_id,
        public int $kategori_anggaran,
        public string $keterangan,
    ) {}

    public static function formArray(array $data, ?int $id = null): self
    {
        return new self(
            id: $id,
            user_id: $data['user_id'],
            kategori_anggaran: $data['kategori_anggaran'],
            keterangan: $data['keterangan'],
        );
    }
}
