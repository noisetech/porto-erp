<?php

namespace App\Applications\SubKategoriAnggaran\DTO;

class SubKategoriAnggaranDTO
{
    public function __construct(
        public ?int $id,
        public int $kategori_anggaran_id,
        public string $kode_sub_kategori,
        public string $nama_sub_kategori,
        public string $keterangan,
        public array $coa_ids = []
    ) {}

    public static function fromArray(array $data, ?int $id = null): self
    {
        return new self(
            id: $id,
            kategori_anggaran_id: $data['kategori_anggaran'],
            kode_sub_kategori: $data['kode'],
            nama_sub_kategori: $data['nama'],
            keterangan: $data['keterangan'] ?? '',
            coa_ids: $data['coa'] ?? []
        );
    }
}
