<?php

namespace App\Repositories\Interfaces;

use App\Models\LogSubKategoriAnggaran;
use App\Models\SubKategoriAnggaran;
use Illuminate\Http\Request;

interface SubKategoriAnggaranRepositoryInterface
{
    public function customDataTable(Request $request): array;

    public function simpanSubKategoriAnggaran(array $data): SubKategoriAnggaran;

    public function simpanLog(array $data): LogSubKategoriAnggaran;

    public function listKategoriAnggaran(?string $search = null): array;


    public function listCoa(?string $search = null): array;

    public function queryBedasarkanId(int $id): ?SubKategoriAnggaran;

    public function update(int $id, array $data): SubKategoriAnggaran;

    public function hapus(int $id): bool;
}
