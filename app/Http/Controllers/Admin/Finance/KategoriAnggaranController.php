<?php

namespace App\Http\Controllers\Admin\Finance;

use App\DTO\KategoriAnggaran\KategoriAnggaranDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\KategoriAnggaransimpanRequet;
use App\Http\Requests\kategoriAnggaranUpdateRequest;
use App\Services\KategoriAnggaranService;
use Illuminate\Http\Request;


class KategoriAnggaranController extends Controller
{
    protected KategoriAnggaranService $service;

    public function __construct(KategoriAnggaranService $kategoriAnggaranService)
    {
        $this->service = $kategoriAnggaranService;
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
    public function simpan(KategoriAnggaransimpanRequet $request)
    {
        $dto = KategoriAnggaranDTO::formArray($request->validated());

        $result = $this->service->simpanDataKategoriAnggara($dto);

        return response()->json([
            'status' => 'success',
            'data' => $result
        ]);
    }
    public function update(kategoriAnggaranUpdateRequest $request, $id)
    {
        $data = array_merge($request->validated(), ['id' => $id]);

        $dto = KategoriAnggaranDTO::formArray($data);
    }
    public function hapus($id) {}
}
