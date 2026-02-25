<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ModelCoa extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'coa';

    protected $fillable = [
        'kode_akun',
        'nama_akun',
        'jenis_akun',
        'kelompok_akun_coa_id',
        'akun_induk_id',
        'boleh_posting',
        'aktif',
        'keterangan'
    ];

    public function akunInduk()
    {
        return $this->belongsTo(COA::class, 'akun_induk_id');
    }

    public function akunAnak()
    {
        return $this->hasMany(COA::class, 'akun_induk_id');
    }

    public function sub_kategori_anggaran()
    {
        return $this->belongsToMany(SubKategoriAnggaran::class, 'mapping_sub_kategori_coa', 'sub_kategori_anggaran_id', 'coa_id');
    }
}
