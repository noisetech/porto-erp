<?php


namespace App\Domain\SubKategoriAnggaran\Entities;

class SubKategoriAnggaranEntity
{
    public function __construct(
        public ?int $id,
        public string $kode_kategori,
        public string $nama_kategori,
        public string $keterangan,
        public array $coa_ids = []
    ) {}

    public function update(
        string $kode,
        string $nama,
        string $keterangan,
        array $coaIds
    ): void {
        $this->kode_kategori = $kode;
        $this->nama_kategori = $nama;
        $this->keterangan = $keterangan;
        $this->coa_ids = $coaIds;
    }
}
