<?php

namespace App\Http\Controllers\Admin\Finance;

use App\DTO\KategoriAnggaran\KategoriAnggaranDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\KategoriAnggaransimpanRequet;
use App\Http\Requests\kategoriAnggaranUpdateRequest;
use App\Services\KategoriAnggaranService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KategoriAnggaranController extends Controller
{
    private KategoriAnggaranService $service;

    public function __construct(KategoriAnggaranService $kategoriAnggaranService)
    {
        $this->service = $kategoriAnggaranService;
    }

    public function simpan(KategoriAnggaransimpanRequet $request)
    {
        $dto = KategoriAnggaranDTO::formArray($request->validated());

        $result = $this->service->simpanDataKategoriAnggaran($dto, Auth::id());

        return response()->json([
            'status' => 'success',
            'message' => 'Data disimpan',
            'data' => $result
        ], 200);
    }

    public function update(kategoriAnggaranUpdateRequest $request, $id)
    {
        $dto = KategoriAnggaranDTO::formArray($request->validated());

        $dto->id = $id;

        $result = $this->service->update($dto, Auth::id());

        return response()->json([
            'status' => 'success',
            'message' => 'Data disimpan',
            'data' => $result
        ], 200);
    }

    public function hapus($id)
    {
        $result = $this->service->hapus($id, Auth::id());

        return response()->json([
            'status' => 'success',
            'message' => 'Data disimpan',
            'data' => $result
        ], 200);
    }


    public function index()
    {
        return view('pages.finance.anggaran.kategori-anggaran');
    }
    public function data(Request $request)
    {
        $result = $this->service->dataTableTanpaLibrary($request);
        return response()->json($result, 200);
    }
}
