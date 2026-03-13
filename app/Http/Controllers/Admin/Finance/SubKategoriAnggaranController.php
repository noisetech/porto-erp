<?php

namespace App\Http\Controllers\Admin\Finance;

use App\Applications\SubKategoriAnggaran\DTO\SubKategoriAnggaranDataTableDTO;
use App\Applications\SubKategoriAnggaran\DTO\SubKategoriAnggaranDTO;
use App\Http\Controllers\Controller;

use App\Applications\SubKategoriAnggaran\Services\SubKategoriAnggaranService;
use App\Http\Requests\SubKategoriAnggaranSimpanRequest;
use App\Http\Resources\SubKategoriAnggaranDatatableResource;
use App\Http\Resources\SubKategoriAnggaranResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubKategoriAnggaranController extends Controller
{

    private SubKategoriAnggaranService $service;

    public function __construct(SubKategoriAnggaranService $subKategoriAnggaranService)
    {
        $this->service = $subKategoriAnggaranService;
    }

    public function simpan(SubKategoriAnggaranSimpanRequest $request)
    {
        $dto = SubKategoriAnggaranDTO::fromArray($request->validated());
        $result = $this->service->simpanDataSubKategoriAnggaran($dto, Auth::id());
        return new SubKategoriAnggaranResource(true, 'Data disimpan', $result);
    }

    public function data(Request $request)
    {
        $dto = SubKategoriAnggaranDataTableDTO::fromRequest($request);

        $result = $this->service->dataTableTanpaLibrary($dto);

        return new SubKategoriAnggaranDatatableResource(true, 'Berhasil menampilkan data', $result);
    }

    public function getDataById($id)
    {
        $result = $this->service->getDataById($id);


        return new SubKategoriAnggaranResource(true, 'Data ditampilkan', $result);
    }


    public function listKategoriAnggaran(Request $request)
    {
        $search = $request->get('q');

        $data = $this->service->select2ListKategoriAnggaran($search);

        return response()->json([
            'data' => $data
        ]);
    }

    public function listCoa(Request $request)
    {
        $search = $request->get('q');

        $data = $this->service->select2ListCoa($search);

        return response()->json([
            'data' => $data
        ]);
    }




    public function index()
    {
        return view('pages.finance.anggaran.sub-kategori-anggaran');
    }
}
