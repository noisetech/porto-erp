<?php

namespace App\Http\Controllers\Admin\Finance;

use App\Http\Controllers\Controller;
use App\Http\Requests\SubKategoriAnggranSimpanRequest;
use App\Http\Requests\SubKateogriAnggaranUpdateRequest;
use App\Services\SubKategoriAnggaranService;
use Illuminate\Http\Request;


class SubKategoriAnggaranController extends Controller
{

    protected SubKategoriAnggaranService $subKategoriAnggaranService;

    public function __construct(SubKategoriAnggaranService $subKategoriAnggaranService)
    {
        $this->subKategoriAnggaranService = $subKategoriAnggaranService;
    }

    public function data(Request $request)
    {
        try {
            $result = $this->subKategoriAnggaranService
                ->dataTableTanpaLibrary($request);
            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function simpan(SubKategoriAnggranSimpanRequest $request)
    {
        try {
            $result = $this->subKategoriAnggaranService
                ->simpanDataKeperluanSubKategoriAnggaran($request->validated());
            return response()->json([
                'status' => 'success',
                'message' => 'Data disimpan',
                'data' => $result
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function getDataById($id)
    {
        try {
            $result = $this->subKategoriAnggaranService->dataBerdasarkanId($id);
            return response()->json([
                'status' => 'success',
                'message' => 'Data berhasil ditampilkan',
                'data' => $result
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => $th->getMessage()
            ], 500);
        }
    }


    public function listKategoriAnggaran(Request $request)
    {
        try {
            $search = $request->q ?? null;
            $data = $this->subKategoriAnggaranService->select2ListKategoriAnggaran($search);
            return response()->json([
                'status' => 'success',
                'message' => 'Data ditemukan',
                'data' => $data
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function listCoa(Request $request)
    {
        try {
            $search = $request->q ?? null;
            $data = $this->subKategoriAnggaranService->select2ListCoa($search);
            return response()->json([
                'status' => 'success',
                'message' => 'Data ditemukan',
                'data' => $data
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function update(SubKateogriAnggaranUpdateRequest $request, $id) {}

    public function hapus($id)
    {
        try {
            $this->subKategoriAnggaranService->hapusDataSubKategoriAnggara($id);

            return response()->json([
                'status' => 'success',
                'message' => 'Data berhasil dihapus',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function index()
    {
        return view('pages.finance.anggaran.sub-kategori-anggaran');
    }
}
