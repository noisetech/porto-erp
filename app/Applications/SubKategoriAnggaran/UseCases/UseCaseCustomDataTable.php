<?php

namespace App\Applications\SubKategoriAnggaran\UseCases;

use App\Infrastructure\SubKategoriAnggaran\QueryBuilder\SubKategoriAnggaranQueryRepository;
use Illuminate\Http\Request;

class UseCaseCustomDataTable
{
    private SubKategoriAnggaranQueryRepository $subKategoriAnggaranQueryRepository;

    public function __construct(SubKategoriAnggaranQueryRepository $k)
    {
        $this->subKategoriAnggaranQueryRepository = $k;
    }

    public function execute(Request $request): array
    {
        return $this->subKategoriAnggaranQueryRepository->customDataTable($request);
    }
}
