<?php

namespace  App\Repositories\Interfaces;

use App\Models\ModelKelompokAkunnCoa;

interface KelompokAkunRepositoryInterface
{
    public function getById(int $id): ?ModelKelompokAkunnCoa;

    public function simpan(array $data): ModelKelompokAkunnCoa;
    public function update(int $id, array $data): ModelKelompokAkunnCoa;
    public function hapus(int $id): bool;
}
