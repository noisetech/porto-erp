<?php

namespace App\Http\Controllers\Admin\Finance;

use App\Applications\SubKategoriAnggaran\DTO\SubKategoriAnggaranDTO;
use App\Http\Controllers\Controller;

use App\Applications\SubKategoriAnggaran\Services\SubKategoriAnggaranService;
use App\Http\Requests\SubKategoriAnggaranSimpanRequest;
use Illuminate\Http\Request;


class SubKategoriAnggaranController extends Controller
{

    private SubKategoriAnggaranService $service;

    public function __construct(SubKategoriAnggaranService $subKategoriAnggaranService)
    {
        $this->service = $subKategoriAnggaranService;
    }

    public function data(Request $request)
    {
        $result = $this->service->dataTableTanpaLibrary($request);

        return response()->json($result, 200);
    }

    public function simpan(SubKategoriAnggaranSimpanRequest $request)
    {
        $dto = SubKategoriAnggaranDTO::formArray($request->validated());

        
    }

    public function index()
    {
        return view('pages.finance.anggaran.sub-kategori-anggaran');
    }
}
