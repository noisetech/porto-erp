<?php

namespace App\Applications\KategoriAnggaran\UseCases;

use App\Domain\KategoriAnggaran\Repositories\KategoriAnggaranQueryRepositoryInterface;
use Illuminate\Http\Request;

class UseCaseCustomDataTable
{
    private KategoriAnggaranQueryRepositoryInterface $kategoriAnggaranQueryRepositoryInterface;

    public function __construct(KategoriAnggaranQueryRepositoryInterface $k)
    {
        $this->kategoriAnggaranQueryRepositoryInterface = $k;
    }

    public function execute(Request $request): array
    {
        return $this->kategoriAnggaranQueryRepositoryInterface->customDataTable($request);
    }
}
