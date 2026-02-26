<?php

namespace App\Repositories\Interfaces;

use App\DTO\KategoriAnggaran\KategoriAnggaranDTO;
use App\DTO\KategoriAnggaran\LogKategoriAnggaranDTO;
use Illuminate\Http\Request;

interface KategoriAnggaranRepositoryInterface
{
    public function customDataTable(Request $request): array;

    public function simpan(KategoriAnggaranDTO $dto);
}
