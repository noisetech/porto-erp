<?php

namespace App\Domain\SubKategoriAnggaran\Entities;

use JsonSerializable;
use DomainException;

class SubKategoriAnggaranEntity implements JsonSerializable
{
    /*
    |--------------------------------------------------------------------------
    | Catatan
    |--------------------------------------------------------------------------
    | coaIds digunakan untuk keperluan sync many-to-many di Infrastructure
    | coa digunakan untuk response relasi COA
    |--------------------------------------------------------------------------
    */

    private ?int $id;
    private int $kategoriAnggaranId;
    private string $kodeSubKategori;
    private string $namaSubKategori;
    private string $keterangan;

    private array $coaIds = [];
    private array $coa = [];
    private ?array $kategoriAnggaran = null;

    public function __construct(
        ?int $id,
        int $kategoriAnggaranId,
        string $kodeSubKategori,
        string $namaSubKategori,
        string $keterangan
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

    public function kode(): string
    {
        return $this->kodeSubKategori;
    }

    public function nama(): string
    {
        return $this->namaSubKategori;
    }

    public function keterangan(): string
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
        $this->coaIds = $ids;  // menyimpan id coa yang dipilih
    }

    public function coaIds(): array
    {
        return $this->coaIds; //mengambil id coa yang tersimpan dalam array digunakan oleh reposity
    }

    public function setCoa(array $coa): void
    {
        $this->coa = $coa;
    }

    public function coa(): array
    {
        return $this->coa;
    }

    public function setKategoriAnggaran(?array $kategori): void
    {
        $this->kategoriAnggaran = $kategori;
    }

    public function kategoriAnggaran(): ?array
    {
        return $this->kategoriAnggaran;
    }

    /*
    |--------------------------------------------------------------------------
    | JSON Response
    |--------------------------------------------------------------------------
    */

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'kategori_anggaran_id' => $this->kategoriAnggaranId,
            'kode_sub_kategori' => $this->kodeSubKategori,
            'nama_sub_kategori' => $this->namaSubKategori,
            'keterangan' => $this->keterangan,
            'coa' => $this->coa,
            'kategori_anggaran' => $this->kategoriAnggaran,
        ];
    }
}
