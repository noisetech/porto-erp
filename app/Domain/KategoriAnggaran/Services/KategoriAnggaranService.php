<?php

namespace App\Domain\KategoriAnggaran\Services;

use App\Domain\KategoriAnggaran\DTO\KategoriAnggaran\KategoriAnggaranDTO;
use App\Domain\KategoriAnggaran\UseCases\KategoriAnggaran\UseCaseCustomDataTable;
use App\Domain\KategoriAnggaran\UseCases\KategoriAnggaran\UseCaseHapus;
use App\Domain\KategoriAnggaran\UseCases\KategoriAnggaran\UseCaseSimpan;
use App\Domain\KategoriAnggaran\UseCases\KategoriAnggaran\UseCaseUpdate;
use Symfony\Component\HttpFoundation\Request;

class KategoriAnggaranService
{
    private UseCaseSimpan $UseCaseSimpanKategoriAnggaran;
    private UseCaseUpdate $UseCaseUpdateKategoriAnggaran;
    private UseCaseCustomDataTable $UseCaseCustomDataTable;
    private UseCaseHapus $UseCaseHapusKategoriAnggaran;


    public function __construct(
        UseCaseSimpan $useCaseSimpan,
        UseCaseCustomDataTable $customTable,
        UseCaseUpdate $useCaseUpdate,
        UseCaseHapus $useCaseHapus
    ) {
        $this->UseCaseSimpanKategoriAnggaran = $useCaseSimpan;
        $this->UseCaseCustomDataTable = $customTable;
        $this->UseCaseUpdateKategoriAnggaran = $useCaseUpdate;
        $this->UseCaseHapusKategoriAnggaran = $useCaseHapus;
    }
    public function simpanDataKategoriAnggaran(KategoriAnggaranDTO $dto, int $userId)
    {
        return $this->UseCaseSimpanKategoriAnggaran->execute($dto, $userId);
    }

    public function dataTableTanpaLibrary(Request $request)
    {
        return $this->UseCaseCustomDataTable->execute($request);
    }

    public function hapus(int $id, $userId)
    {
        return $this->UseCaseHapusKategoriAnggaran->execute($id, $userId);
    }

    public function update(KategoriAnggaranDTO $dto, int $userId)
    {
        return $this->UseCaseUpdateKategoriAnggaran->execute($dto, $userId);
    }
}
