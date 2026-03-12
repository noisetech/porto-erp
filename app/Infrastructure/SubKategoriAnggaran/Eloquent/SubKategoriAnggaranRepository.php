<?php

namespace App\Infrastructure\SubKategoriAnggaran\Eloquent;

use App\Domain\SubKategoriAnggaran\Entities\SubKategoriAnggaranEntity;
use App\Domain\SubKategoriAnggaran\Repositories\SubKategoriAnggaranRepositoryInterface;
use App\Infrastructure\SubKategoriAnggaran\Mapper\SubKategoriAnggaranMapper;
use App\Models\SubKategoriAnggaran;

class SubKategoriAnggaranRepository implements SubKategoriAnggaranRepositoryInterface
{

    public function simpan(SubKategoriAnggaranEntity $entity): SubKategoriAnggaranEntity
    {
        $model = SubKategoriAnggaran::create([
            'kategori_anggaran_id' => $entity->kategoriAnggaranId(),
            'kode_sub_kategori' => $entity->kode(),
            'nama_sub_kategori' => $entity->nama(),
            'keterangan' => $entity->keterangan()
        ]);

        $model->coa()->sync($entity->coaIds());

        $model->load(['coa', 'kategori_anggaran']);

        return SubKategoriAnggaranMapper::toEntity($model);
    }

    public function getDataById(int $id): ?SubKategoriAnggaranEntity
    {
        $model = SubKategoriAnggaran::with(['coa', 'kategori_anggaran'])->find($id);

        if (!$model) {
            return null;
        }

        return SubKategoriAnggaranMapper::toEntity($model);
    }
}
