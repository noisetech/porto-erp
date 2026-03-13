<?php

namespace App\Applications\SubKategoriAnggaran\UseCases;

use App\Domain\SubKategoriAnggaran\Entities\SubKategoriAnggaranEntity;
use App\Infrastructure\SubKategoriAnggaran\QueryBuilder\SubKategoriAnggaranQueryRepository;

class UseCaseGetDataById
{
    public function __construct(
        private SubKategoriAnggaranQueryRepository $repository
    ) {}

    public function execute(int $id): ?SubKategoriAnggaranEntity
    {
        return $this->repository->getDataById($id);
    }
}
