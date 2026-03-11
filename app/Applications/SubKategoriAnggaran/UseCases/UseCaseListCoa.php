<?php

namespace App\Applications\SubKategoriAnggaran\UseCases;

use App\Domain\SubKategoriAnggaran\Repositories\SubKategoriAnggaranQueryRepositoryInterface;

class UseCaseListCoa
{
    public function __construct(
        private SubKategoriAnggaranQueryRepositoryInterface $queryRepository
    ) {}

    public function execute(?string $search = null): array
    {
        return $this->queryRepository->listCoa($search);
    }
}
