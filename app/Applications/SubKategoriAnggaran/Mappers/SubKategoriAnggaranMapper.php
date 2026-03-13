<?php

namespace App\Applications\SubKategoriAnggaran\Mappers;

use App\Domain\SubKategoriAnggaran\Entities\SubKategoriAnggaranEntity;
use App\Models\SubKategoriAnggaran;

class SubKategoriAnggaranMapper
{
    public static function toEntity(SubKategoriAnggaran $model): SubKategoriAnggaranEntity
    {
        $entity = new SubKategoriAnggaranEntity(
            $model->id,
            $model->kategori_anggaran_id,
            $model->kode_sub_kategori,
            $model->nama_sub_kategori,
            $model->keterangan
        );

        // mapping coa
        if ($model->relationLoaded('coa') && $model->coa) {
            $entity->setCoa(
                $model->coa->makeHidden('pivot')->toArray()
            );
        }

        // mapping kategori anggaran
        if ($model->relationLoaded('kategori_anggaran') && $model->kategori_anggaran) {
            $entity->setKategoriAnggaran(
                $model->kategori_anggaran->toArray()
            );
        }

        return $entity;
    }
}
