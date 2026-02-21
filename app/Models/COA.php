<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class COA extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'coa';

    protected $fillable = [
        'kode_akun',
        'nama_akun',
        'jenis_akun',
        'kelompok_akun',
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
}
