<?php

namespace App\Repositories\Interfaces;

use Illuminate\Http\Request;

interface KategoriAnggaranQueryRepositoryInterface
{
    public function customDataTable(Request $request): array;
}
