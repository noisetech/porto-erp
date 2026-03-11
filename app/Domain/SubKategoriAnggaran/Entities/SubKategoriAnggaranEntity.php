<?php


namespace App\Domain\SubKategoriAnggaran\Entities;

class SubKategoriAnggaranEntity
{
    public function __construct(
        public ?int $id,
        public int $kategori_anggaran_id,
        public string $kode_sub_kategori,
        public string $nama_sub_kategori,
        public string $keterangan,
        public array $coa_ids = []
    ) {}

    public function update(
        int $kategoriAnggaranId,
        string $kode,
        string $nama,
        string $keterangan,
        array $coaIds
    ): void {
        $this->kategori_anggaran_id = $kategoriAnggaranId;
        $this->kode_sub_kategori = $kode;
        $this->nama_sub_kategori = $nama;
        $this->keterangan = $keterangan;
        $this->coa_ids = $coaIds;
    }
}
