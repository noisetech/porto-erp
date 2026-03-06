<?php

namespace App\Domain\KategoriAnggaran\Entities;

use App\Domain\KategoriAnggaran\Exceptions\KategoriAnggaranException;

class KategoriAnggaran
{
    public function __construct(
        private ?int $id,
        private string $kodeKategori,
        private string $namaKategori,
        private ?string $keterangan
    ) {}

    public function rename(string $nama): void
    {
        if (empty($nama)) {
            throw new KategoriAnggaranException('Nama tidak boleh kosong');
        }

        $this->namaKategori = $nama;
    }

    public function getKode(): string
    {
        return $this->kodeKategori;
    }
    public function getNama(): string
    {
        return $this->namaKategori;
    }
    public function getKeterangan(): ?string
    {
        return $this->keterangan;
    }
}
