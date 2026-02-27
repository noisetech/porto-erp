<?php

namespace App\Domain\KategoriAnggaran\DTO\KategoriAnggaran;

class KategoriAnggaranDTO
{
    public function __construct(
        public ?int $id,
        public string $kode_kategori,
        public string $nama_kategori,
        public string $keterangan
    ) {}

    public static function formArray(array $data, ?int $id = null): self
    {
        return new self(
            id: $id,
            kode_kategori: $data['kode_kategori'],
            nama_kategori: $data['nama_kategori'],
            keterangan: $data['keterangan'],
        );
    }
}
