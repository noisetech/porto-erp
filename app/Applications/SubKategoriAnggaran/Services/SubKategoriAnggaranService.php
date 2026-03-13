<?php

namespace App\Applications\SubKategoriAnggaran\Services;

use App\Applications\SubKategoriAnggaran\UseCases\UseCaseGetDataById;
use App\Applications\SubKategoriAnggaran\DTO\SubKategoriAnggaranDataTableDTO;
use App\Applications\SubKategoriAnggaran\DTO\SubKategoriAnggaranDTO;
use App\Applications\SubKategoriAnggaran\Mappers\SubKategoriAnggaranResponseMapper;
use App\Applications\SubKategoriAnggaran\UseCases\UseCaseCustomDataTable;
use App\Applications\SubKategoriAnggaran\UseCases\UseCaseListCoa;
use App\Applications\SubKategoriAnggaran\UseCases\UseCaseSimpan;
use App\Applications\SubKategoriAnggaran\UseCases\UseeCaseListKategoriAnggaran;

class SubKategoriAnggaranService
{
    public function __construct(
        private UseCaseCustomDataTable $customDataTable,
        private UseCaseListCoa $listCoa,
        private UseeCaseListKategoriAnggaran $listKategoriAnggaran,
        private UseCaseSimpan $simpan,
        private UseCaseGetDataById $getDataById
    ) {}

    public function dataTableTanpaLibrary(SubKategoriAnggaranDataTableDTO $dto): array
    {
        return $this->customDataTable->execute($dto);
    }

    public function select2ListCoa(?string $search = null): array
    {
        return $this->listCoa->execute($search);
    }

    public function select2ListKategoriAnggaran(?string $search = null): array
    {
        return $this->listKategoriAnggaran->execute($search);
    }

    public function getDataById(int $id): ?array
    {
        $entity = $this->getDataById->execute($id);

        if (!$entity) {
            return null;
        }

        return SubKategoriAnggaranResponseMapper::map($entity);
    }
    public function simpanDataSubKategoriAnggaran(SubKategoriAnggaranDTO $dto, int $userId)
    {
        $entity = $this->simpan->execute($dto, $userId);

        if (!$entity) {
            return null;
        }

        return SubKategoriAnggaranResponseMapper::map($entity);
    }
}
