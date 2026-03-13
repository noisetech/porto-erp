<?php

namespace App\Infrastructure\SubKategoriAnggaran\Eloquent;

use App\Applications\SubKategoriAnggaran\Mappers\SubKategoriAnggaranMapper;
use App\Domain\SubKategoriAnggaran\Entities\SubKategoriAnggaranEntity;
use App\Domain\SubKategoriAnggaran\Repositories\SubKategoriAnggaranRepositoryInterface;
use App\Models\SubKategoriAnggaran;

class SubKategoriAnggaranRepository implements SubKategoriAnggaranRepositoryInterface
{
    public function simpan(SubKategoriAnggaranEntity $entity): SubKategoriAnggaranEntity
    {
        $model = SubKategoriAnggaran::create([
            'kategori_anggaran_id' => $entity->kategoriAnggaranId(),
            'kode_sub_kategori' => $entity->kodeSubKategori(),
            'nama_sub_kategori' => $entity->namaSubKategori(),
            'keterangan' => $entity->keterangan(),
        ]);

        // relasi many to many
        if (!empty($entity->coaIds())) {
            $model->coa()->sync($entity->coaIds());
        }

        // load relasi
        $model->load(['coa', 'kategori_anggaran']);

        return SubKategoriAnggaranMapper::toEntity($model);
    }
}
