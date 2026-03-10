<?php

namespace App\Domain\KategoriAnggaran\Repositories\Interfaces;

use App\Applications\KategoriAnggaran\DTO\KategoriAnggaranDTO;
use App\Domain\KategoriAnggaran\Entities\KategoriAnggaranEntity;
use App\Models\KategoriAnggaran;

interface KategoriAnggaranRepositoryInterface
{
    public function simpan(KategoriAnggaranDTO $dto): KategoriAnggaranEntity;

    public function update(KategoriAnggaranDTO $dto): KategoriAnggaranEntity;

    public function getDataById(int $id): ?KategoriAnggaranEntity;

    public function hapus(int $id): bool;
}
