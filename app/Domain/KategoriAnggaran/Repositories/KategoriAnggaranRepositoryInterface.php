<?php

namespace App\Domain\KategoriAnggaran\Repositories;

use App\Domain\KategoriAnggaran\Entities\KategoriAnggaranEntity;

interface KategoriAnggaranRepositoryInterface
{
    public function simpan(KategoriAnggaranEntity $entity): KategoriAnggaranEntity;

    public function update(KategoriAnggaranEntity $entity): KategoriAnggaranEntity;

    public function getDataById(int $id): ?KategoriAnggaranEntity;

    public function hapus(int $id): bool;
}
