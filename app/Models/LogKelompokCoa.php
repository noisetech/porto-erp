<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LogKelompokCoa extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'log_kelompok_akun_coa';

    protected $fillable = [
        'user_id', 'kelompk_akun_coa_id', 'keterangan'
    ];

}
