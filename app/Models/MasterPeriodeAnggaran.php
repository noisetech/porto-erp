<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MasterPeriodeAnggaran extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'master_periode_anggaran';

    protected $fillable = [
        'tahun',
        'status',
        'tanggal_mulai',
        'tanggal_selesai',
        'tangggal_aktif',
        'diaktifkan_oleh_id',
        'keterangan'
    ];
}
