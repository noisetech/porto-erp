<?php

namespace App\Repositories\Interfaces;

use App\Models\ModelRekeningBank;

interface RekeningBankRepositoryInterface
{
    public function getById(int $id): ?ModelRekeningBank;

    public function simpan(array $data): ModelRekeningBank;
    public function update(int $id, array $data): ModelRekeningBank;
    public function hapus(int $id): bool;
}
