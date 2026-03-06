<?php

namespace App\Domain\KategoriAnggaran\Exceptions;

use DomainException;

class KategoriAnggaranException extends DomainException
{
    public static function namaKosong(): self
    {
        return new self("Nama kategori tidak boleh kosong.");
    }

    public static function kodeKosong(): self
    {
        return new self("Kode kategori tidak boleh kosong.");
    }

    public static function sudahAda(): self
    {
        return new self("Kategori anggaran sudah ada.");
    }

    public static function tidakDitemukan(): self
    {
        return new self("Kategori anggaran tidak ditemukan.");
    }

    public static function tidakBolehDihapus(): self
    {
        return new self("Kategori tidak dapat dihapus karena sudah digunakan.");
    }
}
