<?php

namespace App\Domain\SubKategoriAnggaran\Repositories;;

use Illuminate\Http\Request;

interface SubKategoriAnggaranQueryRepositoryInterface
{
    public function customDataTable(Request $request): array;

    public function listCoa(?string $search = null): array;


    public function listKategoriAnggaran(?string $search = null): array;
}
