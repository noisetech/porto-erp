<?php

namespace App\Services;

use App\DTO\KategoriAnggaran\KategoriAnggaranDTO;
use App\DTO\KategoriAnggaran\LogKategoriAnggaranDTO;
use App\Repositories\Interfaces\KategoriAnggaranRepositoryInterface;
use App\Repositories\LogKategoriAnggaranRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class KategoriAnggaranService
{
    protected KategoriAnggaranRepositoryInterface $kategoriAnggaranRepositoryInterface;
    protected LogKategoriAnggaranRepository $logKategoriAnggaranRepository;

    public function __construct(KategoriAnggaranRepositoryInterface $k, LogKategoriAnggaranRepository $l)
    {
        $this->kategoriAnggaranRepositoryInterface = $k;
        $this->logKategoriAnggaranRepository = $l;
    }

    public function simpanDataKategoriAnggara(KategoriAnggaranDTO $dto)
    {
        return DB::transaction(function () use ($dto) {
            $kategori_anggaran = $this->kategoriAnggaranRepositoryInterface->simpan($dto);

            $this->logKategoriAnggaranRepository->simpan(
                new LogKategoriAnggaranDTO(
                    user_id: Auth::user()->id,
                    kategori_anggaran: $kategori_anggaran->id,
                    keterangan: 'menambahkan data'
                )
            );
            return $kategori_anggaran;
        });
    }

    public function dataTableTanpaLibrary(Request $request): array
    {
        $result = $this->kategoriAnggaranRepositoryInterface->customDataTable($request);

        $response = [
            'draw'            => $result['draw'],
            'recordsTotal'    => $result['recordsTotal'],
            'recordsFiltered' => $result['recordsFiltered'],
            'data'            => $result['data'],
            'status'          => 'success',
            'message'         => 'Data berhasil diambil'
        ];

        return $response;
    }
}
