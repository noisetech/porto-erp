<?php

namespace App\Domain\KategoriAnggaran\Repositories;

use App\Domain\KategoriAnggaran\Entities\LogKategoriAnggaranEntity;

interface LogKategoriAnggaranRepositoryInterface
{
    public function simpan(LogKategoriAnggaranEntity $log): void;
}
