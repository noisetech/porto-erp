<?php

namespace App\Http\Controllers\Admin\Finance;

use App\Applications\SubKategoriAnggaran\DTO\SubKategoriAnggaranDTO;
use App\Http\Controllers\Controller;

use App\Applications\SubKategoriAnggaran\Services\SubKategoriAnggaranService;
use App\Http\Requests\SubKategoriAnggaranSimpanRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        return response()->json([
            'draw' => $result['draw'],
            'recordsTotal' => $result['recordsTotal'],
            'recordsFiltered' => $result['recordsFiltered'],
            'data' => $result['data'],
            'status' => 'success',
            'message' => 'Data berhasil diambil'
        ], 200);
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


    public function simpan(SubKategoriAnggaranSimpanRequest $request)
    {
        $dto = SubKategoriAnggaranDTO::fromArray($request->validated());

        $result = $this->service->simpanDataSubKategoriAnggaran($dto, Auth::id());

        return response()->json([
            'status' => 'success',
            'message' => 'Data disimpan',
            'data' => $result
        ], 200);
    }


    public function index()
    {
        return view('pages.finance.anggaran.sub-kategori-anggaran');
    }
}
