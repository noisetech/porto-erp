<?php

namespace App\Domain\KategoriAnggaran\Repositories\Interfaces;

use App\Applications\KategoriAnggaran\DTO\LogKategoriAnggaranDTO;

interface LogKategoriAnggaranRepositoryInterface
{
    public function save(LogKategoriAnggaranDTO $log): void;
}
