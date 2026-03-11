<?php

namespace App\Infrastructure\SubKategoriAnggaran\Eloquent;

use App\Domain\SubKategoriAnggaran\Entities\SubKategoriAnggaranEntity;
use App\Domain\SubKategoriAnggaran\Repositories\SubKategoriAnggaranRepositoryInterface;
use App\Models\SubKategoriAnggaran;

class SubKategoriAnggaranRepository implements SubKategoriAnggaranRepositoryInterface
{

    private function mapToEntity(SubKategoriAnggaran $model): SubKategoriAnggaranEntity
    {
        return new SubKategoriAnggaranEntity(
            id: $model->id,
            kategori_anggaran_id: $model->kategori_anggaran_id,
            kode_sub_kategori: $model->kode_sub_kategori,
            nama_sub_kategori: $model->nama_sub_kategori,
            keterangan: $model->keterangan,
            coa_ids: $model->coa->pluck('id')->toArray()
        );
    }

    public function simpan(SubKategoriAnggaranEntity $entity): SubKategoriAnggaranEntity
    {
        $model = SubKategoriAnggaran::create([
            'kategori_anggaran_id' => $entity->kategori_anggaran_id,
            'kode_sub_kategori' => $entity->kode_sub_kategori,
            'nama_sub_kategori' => $entity->nama_sub_kategori,
            'keterangan' => $entity->keterangan
        ]);

        $model->coa()->sync($entity->coa_ids);

        $model->load('coa');

        return $this->mapToEntity($model);
    }
}
    