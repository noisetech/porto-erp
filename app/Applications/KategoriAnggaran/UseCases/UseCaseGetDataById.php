<?php

namespace App\Applications\KategoriAnggaran\UseCases;

use App\Domain\KategoriAnggaran\Repositories\KategoriAnggaranRepositoryInterface;
use Illuminate\Http\Request;

class UseCaseGetDataById
{
    private KategoriAnggaranRepositoryInterface $repository;

    public function __construct(KategoriAnggaranRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function execute(int $id)
    {
        return $this->repository->getDataById($id);
    }

}
