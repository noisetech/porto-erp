<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ModelMasterBank extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'bank_master';

    protected $fillable = [
        'kode_bank',
        'nama_bank'
    ];
}
