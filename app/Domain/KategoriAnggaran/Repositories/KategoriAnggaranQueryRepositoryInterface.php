<?php

namespace App\Domain\KategoriAnggaran\Repositories;

use Illuminate\Http\Request;

interface KategoriAnggaranQueryRepositoryInterface
{
    public function customDataTable(Request $request): array;
}
