<?php

namespace App\Repositories\Interfaces;

use App\DTO\KategoriAnggaran\KategoriAnggaranDTO;
use App\DTO\KategoriAnggaran\LogKategoriAnggaranDTO;
use App\Models\KategoriAnggaran;
use Illuminate\Http\Request;

interface KategoriAnggaranRepositoryInterface
{
    public function customDataTable(Request $request): array;

    public function simpan(KategoriAnggaranDTO $dto): KategoriAnggaran;

    public function update(KategoriAnggaranDTO $dto): KategoriAnggaran;

    public function getDataById(int $id): ?KategoriAnggaran;

    public function hapus(int $id): bool;
}
