<?php

namespace App\Services;

use App\DTO\KategoriAnggaran\KategoriAnggaranDTO;
use App\UseCases\KategoriAnggaran\UseCaseCustomDataTable;
use App\UseCases\KategoriAnggaran\UseCaseSimpanKategoriAnggaran;
use Illuminate\Http\Request;


class KategoriAnggaranService
{
    protected UseCaseSimpanKategoriAnggaran $UseCaseSimpanKategoriAnggaran;
    protected UseCaseCustomDataTable $UseCaseCustomDataTable;

    public function __construct(UseCaseSimpanKategoriAnggaran $k, UseCaseCustomDataTable $l)
    {
        $this->UseCaseSimpanKategoriAnggaran = $k;
        $this->UseCaseCustomDataTable = $l;
    }

    public function simpanDataKategoriAnggara(KategoriAnggaranDTO $dto)
    {
        return $this->UseCaseSimpanKategoriAnggaran->execute($dto);
    }

    public function dataTableTanpaLibrary(Request $request)
    {
        return $this->UseCaseCustomDataTable->execute($request);
    }
}
