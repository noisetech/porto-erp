<?php

namespace App\Applications\SubKategoriAnggaran\Services;

use App\Applications\SubKategoriAnggaran\UseCases\UseCaseCustomDataTable;
use Illuminate\Http\Request;

class SubKategoriAnggaranService
{

    private UseCaseCustomDataTable $UseCaseCustomDataTable;


    public function __construct(
        UseCaseCustomDataTable $customTable,
    ) {
        $this->UseCaseCustomDataTable = $customTable;
    }


    public function dataTableTanpaLibrary(Request $request)
    {
        return $this->UseCaseCustomDataTable->execute($request);
    }
}
