<?php

namespace App\Applications\KategoriAnggaran\Services;

use App\Applications\KategoriAnggaran\DTO\KategoriAnggaranDTO;
use App\Applications\KategoriAnggaran\UseCases\UseCaseCustomDataTable;
use App\Applications\KategoriAnggaran\UseCases\UseCaseHapus;
use App\Applications\KategoriAnggaran\UseCases\UseCaseSimpan;
use App\Applications\KategoriAnggaran\UseCases\UseCaseUpdate;
use Illuminate\Http\Request;

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
