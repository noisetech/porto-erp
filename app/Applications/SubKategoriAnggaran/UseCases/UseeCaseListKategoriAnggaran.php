<?php

namespace App\Applications\SubKategoriAnggaran\UseCases;

use App\Domain\SubKategoriAnggaran\Repositories\SubKategoriAnggaranQueryRepositoryInterface;

class UseeCaseListKategoriAnggaran
{
    public function __construct(
        private SubKategoriAnggaranQueryRepositoryInterface $queryRepository
    ) {}    

    public function execute(?string $search = null): array
    {
        return $this->queryRepository->listKategoriAnggaran($search);
    }
}
