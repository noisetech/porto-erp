<?php

namespace App\Services;

use App\Repositories\Interfaces\SubKategoriAnggaranRepositoryInterface;

use Illuminate\Http\Request;

class SubKategoriAnggaranService
{
    protected SubKategoriAnggaranRepositoryInterface $repository;

    public function __construct(SubKategoriAnggaranRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function dataTableTanpaLibrary(Request $request): array
    {
        $result = $this->repository->customDataTable($request);

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

    public function dataBerdasarkanId(int $id)
    {
        return $this->repository->queryBedasarkanId($id);
    }


    public function simpanDataKeperluanSubKategoriAnggaran(array $data)
    {
        return  $this->repository->simpanSubKategoriAnggaran($data);
    }

    public function hapusDataSubKategoriAnggara(int $id)
    {
        return $this->repository->hapus($id);
    }

    public function update(int $id, array $data)
    {
        return $this->repository->update($id, $data);
    }


    public function select2ListKategoriAnggaran(?string $search = null): array
    {
        return $this->repository->listKategoriAnggaran($search);
    }

    public function select2ListCoa(?string $search = null): array
    {
        return $this->repository->listCoa($search);
    }
}
