<?php

namespace App\Domain\SubKategoriAnggaran\Repositories; ;

use App\Domain\SubKategoriAnggaran\Entities\SubKategoriAnggaranEntity;

interface SubKategoriAnggaranRepositoryInterface
{
    public function simpan(SubKategoriAnggaranEntity $entity): SubKategoriAnggaranEntity;

    public function update(SubKategoriAnggaranEntity $entity): SubKategoriAnggaranEntity;

    public function getDataById(int $id): ?SubKategoriAnggaranEntity;

    public function hapus(int $id): bool;
}
