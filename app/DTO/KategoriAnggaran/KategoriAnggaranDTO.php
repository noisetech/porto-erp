<?php

namespace App\DTO\KategoriAnggaran;

class KategoriAnggaranDTO
{
    public function __construct(
        public string $kode_kategori,
        public string $nama_kategori,
        public string $keterangan,
    ) {}


    public static function formArray(array $data): self
    {
        return new self(
            kode_kategori: $data['kode_kategori'],
            nama_kategori: $data['nama_kategori'],
            keterangan: $data['keterangan']
        );
    }
}
