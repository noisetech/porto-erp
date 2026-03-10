<?php

namespace App\Domain\SubKategoriAnggaran\Repositories;

use App\Applications\SubKategoriAnggaran\DTO\LogSubKategoriAnggaranDTO;

interface LogSubKategoriAnggaranRepositoryInterface
{
    public function simpan(LogSubKategoriAnggaranDTO $log): void;
}
