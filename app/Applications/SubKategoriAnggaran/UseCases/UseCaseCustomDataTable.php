<?php

namespace App\Applications\SubKategoriAnggaran\UseCases;

use App\Infrastructure\SubKategoriAnggaran\QueryBuilder\SubKategoriAnggaranQueryRepository;
use Illuminate\Http\Request;

class UseCaseCustomDataTable
{
    private SubKategoriAnggaranQueryRepository $subKategoriAnggaranQueryRepository;

    public function __construct(SubKategoriAnggaranQueryRepository $k)
    {
        $this->subKategoriAnggaranQueryRepository = $k;
    }

    public function execute(Request $request): array
    {
        $result = $this->subKategoriAnggaranQueryRepository->customDataTable($request);

        $response = [
            'draw'            => $result['draw'],
            'recordsTotal'    => $result['recordsTotal'],
            'recordsFiltered' => $result['recordsFiltered'],
            'data'            => $result['data'],
            'status'          => 'success',
            'message'         => 'Data berhasil ditampilkan'
        ];

        return $response;
    }
}
