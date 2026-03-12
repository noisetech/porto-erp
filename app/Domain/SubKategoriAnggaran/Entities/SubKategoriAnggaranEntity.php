<?php

namespace App\Domain\SubKategoriAnggaran\Entities;

class SubKategoriAnggaranEntity
{


    private ?int $id;
    private int $kategoriAnggaranId;
    private string $kodeSubKategori;
    private string $namaSubKategori;
    private string $keterangan;

    private array $coaIds = []; //dipakai untuk memanggil relasi many to many
    private array $coa = []; // dipakai untuk reponse json relasi sub kategori anggaran dengan master coa
    private ?array $kategoriAnggaran = null; // dipanggil untuk response relasi sub kategori anggaran dengan kategori anggaran

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
        $this->coaIds = $ids;  // menyimpan daftar ID COA yang dipilih
    }

    public function coaIds(): array
    {
        return $this->coaIds; //mengambil ID COA dari entity
    }

    public function setCoa(array $coa): void
    {
        $this->coa = $coa;  //menyimpan data COA lengkap biasanya dipanggil di Mapper setelah mengambil data dari databas
    }

    public function coa(): array
    {
        return $this->coa;  //menyimpan data COA lengkap biasanya dipanggil di Mapper setelah mengambil data dari database biasanya digunakan saat mengembalikan response API.

    }

    /*
    |--------------------------------------------------------------------------
    | Kategori anggaran relation
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
