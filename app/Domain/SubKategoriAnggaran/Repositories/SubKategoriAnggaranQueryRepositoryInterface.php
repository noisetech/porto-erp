<?php

namespace App\Domain\SubKategoriAnggaran\Repositories;;

use App\Applications\SubKategoriAnggaran\DTO\SubKategoriAnggaranDataTableDTO;
use App\Domain\SubKategoriAnggaran\Entities\SubKategoriAnggaranEntity;

interface SubKategoriAnggaranQueryRepositoryInterface
{
    public function customDataTable(SubKategoriAnggaranDataTableDTO $dto): array;

    public function listCoa(?string $search = null): array;


    public function listKategoriAnggaran(?string $search = null): array;


    public function getDataById(int $id): ?SubKategoriAnggaranEntity;
}
