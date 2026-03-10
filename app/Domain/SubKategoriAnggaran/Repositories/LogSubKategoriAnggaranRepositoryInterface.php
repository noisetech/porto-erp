<?php

namespace App\Domain\SubKategoriAnggaran\Repositories;

use App\Applications\SubKategoriAnggaran\DTO\LogSubKategoriAnggaranDTO;
use App\Domain\KategoriAnggaran\Entities\LogKategoriAnggaranEntity;

interface LogSubKategoriAnggaranRepositoryInterface
{
    public function simpan(LogKategoriAnggaranEntity $log): void;
}
