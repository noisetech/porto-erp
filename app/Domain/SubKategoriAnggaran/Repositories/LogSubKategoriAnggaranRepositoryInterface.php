<?php

namespace App\Domain\SubKategoriAnggaran\Repositories;

use App\Domain\SubKategoriAnggaran\Entities\LogSubKategoriAnggaranEntity;

interface LogSubKategoriAnggaranRepositoryInterface
{
    public function simpan(LogSubKategoriAnggaranEntity $log): void;
}
