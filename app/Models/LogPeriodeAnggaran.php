<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LogPeriodeAnggaran extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'l_m_periode_anggaran';

    protected $fillabe = [
        'user_id',
        'master_periode_anggaran_id',
        'keterangan'
    ];
}
