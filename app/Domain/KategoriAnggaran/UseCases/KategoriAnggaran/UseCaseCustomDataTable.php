<?php
namespace App\Domain\KategoriAnggaran\UseCases\KategoriAnggaran;

use App\Domain\KategoriAnggaran\Repositories\Interfaces\KategoriAnggaranQueryRepositoryInterface;
use Illuminate\Http\Request;

class UseCaseCustomDataTable
{
    private KategoriAnggaranQueryRepositoryInterface $kategoriAnggaranQueryRepositoryInterface;

    public function __construct(KategoriAnggaranQueryRepositoryInterface $k)
    {
        $this->kategoriAnggaranQueryRepositoryInterface = $k;
    }

    public function execute(Request $request): array
    {
        $result = $this->kategoriAnggaranQueryRepositoryInterface->customDataTable($request);

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
