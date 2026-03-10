<?php

namespace App\Domain\SubKategoriAnggaran\Repositories; ;

use Illuminate\Http\Request;

interface SubKategoriAnggaranQueryRepositoryInterface
{
    public function customDataTable(Request $request): array;
}
