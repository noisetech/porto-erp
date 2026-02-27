<?php

namespace App\Domain\KategoriAnggaran\Repositories\Interfaces;

use App\Domain\KategoriAnggaran\DTO\KategoriAnggaran\KategoriAnggaranDTO;
use App\Models\KategoriAnggaran;

interface KategoriAnggaranRepositoryInterface
{
    public function simpan(KategoriAnggaranDTO $dto): KategoriAnggaran;

    public function update(KategoriAnggaranDTO $dto): KategoriAnggaran;

    public function getDataById(int $id): ?KategoriAnggaran;

    public function hapus(int $id): bool;
}
