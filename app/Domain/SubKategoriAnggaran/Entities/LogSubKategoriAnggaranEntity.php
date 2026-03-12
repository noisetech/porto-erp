<?php

namespace App\Domain\SubKategoriAnggaran\Entities;

class LogSubKategoriAnggaranEntity
{
    public const ACTION_CREATE = 'Menambahkan kategori anggaran';
    public const ACTION_UPDATE = 'Mengubah kategori anggaran';
    public const ACTION_DELETE = 'Menghapus kategori anggaran';

    private ?int $id;
    private int $userId;
    private int $subKategoriAnggaranId;
    private string $keterangan;

    public function __construct(
        ?int $id,
        int $userId,
        int $subKategoriAnggaranId,
        string $keterangan
    ) {
        $this->id = $id;
        $this->userId = $userId;
        $this->subKategoriAnggaranId = $subKategoriAnggaranId;
        $this->keterangan = $keterangan;
    }

    public function id(): ?int
    {
        return $this->id;
    }

    public function userId(): int
    {
        return $this->userId;
    }

    public function subKategoriAnggaranId(): int
    {
        return $this->subKategoriAnggaranId;
    }

    public function keterangan(): string
    {
        return $this->keterangan;
    }
}
