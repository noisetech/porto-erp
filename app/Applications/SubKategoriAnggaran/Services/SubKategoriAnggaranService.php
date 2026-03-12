<?php

namespace App\Applications\SubKategoriAnggaran\Services;

use App\Applications\SubKategoriAnggaran\DTO\SubKategoriAnggaranDataTableDTO;
use App\Applications\SubKategoriAnggaran\DTO\SubKategoriAnggaranDTO;
use App\Applications\SubKategoriAnggaran\UseCases\UseCaseCustomDataTable;
use App\Applications\SubKategoriAnggaran\UseCases\UseCaseListCoa;
use App\Applications\SubKategoriAnggaran\UseCases\UseCaseSimpan;
use App\Applications\SubKategoriAnggaran\UseCases\UseeCaseListKategoriAnggaran;
use Illuminate\Http\Request;

class SubKategoriAnggaranService
{

    private UseCaseCustomDataTable $UseCaseCustomDataTable;
    private UseCaseListCoa $useCaseListCoa;

    private UseeCaseListKategoriAnggaran $useeCaseListKategoriAnggaran;
    private UseCaseSimpan $useCaseSimpan;

    public function __construct(
        UseCaseCustomDataTable $customTable,
        UseCaseListCoa $useCaseListCoa,
        UseeCaseListKategoriAnggaran $useeCaseListKategoriAnggaran,
        UseCaseSimpan $useCaseSimpan
    ) {
        $this->UseCaseCustomDataTable = $customTable;
        $this->useCaseListCoa = $useCaseListCoa;
        $this->useeCaseListKategoriAnggaran = $useeCaseListKategoriAnggaran;
        $this->useCaseSimpan = $useCaseSimpan;
    }


    public function dataTableTanpaLibrary(SubKategoriAnggaranDataTableDTO $dto): array
    {
        return $this->UseCaseCustomDataTable->execute($dto);
    }

    public function select2ListCoa(?string $search = null): array
    {
        return $this->useCaseListCoa->execute($search);
    }

    public function select2ListKategoriAnggaran(?string $search = null): array
    {
        return $this->useeCaseListKategoriAnggaran->execute($search);
    }

    public function simpanDataSubKategoriAnggaran(SubKategoriAnggaranDTO $dto, int $userId)
    {
        return $this->useCaseSimpan->execute($dto, $userId);
    }
}
