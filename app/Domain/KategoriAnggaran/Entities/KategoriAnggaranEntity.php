<?php


namespace App\Domain\KategoriAnggaran\Entities;

class KategoriAnggaranEntity
{
    public function __construct(
        public ?int $id,
        public string $kode_kategori,
        public string $nama_kategori,
        public string $keterangan
    ) {}

    public function update(string $kode, string $nama, string $keterangan): void
    {
        $this->kode_kategori = $kode;
        $this->nama_kategori = $nama;
        $this->keterangan = $keterangan;
    }
}
