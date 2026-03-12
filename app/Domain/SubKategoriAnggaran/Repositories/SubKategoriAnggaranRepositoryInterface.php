<?php

namespace App\Domain\SubKategoriAnggaran\Repositories;
use App\Domain\SubKategoriAnggaran\Entities\SubKategoriAnggaranEntity;

interface SubKategoriAnggaranRepositoryInterface
{
    public function simpan(SubKategoriAnggaranEntity $dto): SubKategoriAnggaranEntity;
}
