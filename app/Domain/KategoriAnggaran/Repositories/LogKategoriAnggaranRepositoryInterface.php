<?php

namespace App\Domain\KategoriAnggaran\Repositories;

use App\Applications\KategoriAnggaran\DTO\LogKategoriAnggaranDTO;

interface LogKategoriAnggaranRepositoryInterface
{
    public function simpan(LogKategoriAnggaranDTO $log): void;
}
