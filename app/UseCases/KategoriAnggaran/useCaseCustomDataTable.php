<?php

namespace App\UseCases\KategoriAnggaran;

use App\Repositories\Interfaces\KategoriAnggaranRepositoryInterface;
use Illuminate\Http\Request;

class UseCaseCustomDataTable
{
    protected KategoriAnggaranRepositoryInterface $kategoriAnggaranRepositoryInterface;

    public function __construct(KategoriAnggaranRepositoryInterface $k)
    {
        $this->kategoriAnggaranRepositoryInterface = $k;
    }

    public function excute(Request $request): array
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
