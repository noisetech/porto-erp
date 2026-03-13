<?php

namespace App\Domain\SubKategoriAnggaran\Entities;

class SubKategoriAnggaranEntity
{
    private ?int $id;
    private int $kategoriAnggaranId;
    private string $kodeSubKategori;
    private string $namaSubKategori;
    private ?string $keterangan;

    /*
    |--------------------------------------------------------------------------
    | Relations
    |--------------------------------------------------------------------------
    */

    // many to many (untuk simpan)
    private array $coaIds = [];

    // many to many (untuk response)
    private array $coa = [];

    // belongs to kategori anggaran (untuk response)
    private ?array $kategoriAnggaran = null;


    public function __construct(
        ?int $id,
        int $kategoriAnggaranId,
        string $kodeSubKategori,
        string $namaSubKategori,
        ?string $keterangan
    ) {
        $this->id = $id;
        $this->kategoriAnggaranId = $kategoriAnggaranId;
        $this->kodeSubKategori = $kodeSubKategori;
        $this->namaSubKategori = $namaSubKategori;
        $this->keterangan = $keterangan;
    }

    /*
    |--------------------------------------------------------------------------
    | Getter
    |--------------------------------------------------------------------------
    */

    public function id(): ?int
    {
        return $this->id;
    }

    public function kategoriAnggaranId(): int
    {
        return $this->kategoriAnggaranId;
    }

    public function kodeSubKategori(): string
    {
        return $this->kodeSubKategori;
    }

    public function namaSubKategori(): string
    {
        return $this->namaSubKategori;
    }

    public function keterangan(): ?string
    {
        return $this->keterangan;
    }

    /*
    |--------------------------------------------------------------------------
    | COA relation
    |--------------------------------------------------------------------------
    */

    public function setCoaIds(array $ids): void
    {
        $this->coaIds = $ids;
    }

    public function coaIds(): array
    {
        return $this->coaIds;
    }

    public function setCoa(array $coa): void
    {
        $this->coa = $coa;
    }

    public function coa(): array
    {
        return $this->coa;
    }

    /*
    |--------------------------------------------------------------------------
    | Kategori Anggaran relation
    |--------------------------------------------------------------------------
    */

    public function setKategoriAnggaran(?array $kategori): void
    {
        $this->kategoriAnggaran = $kategori;
    }

    public function kategoriAnggaran(): ?array
    {
        return $this->kategoriAnggaran;
    }
}
