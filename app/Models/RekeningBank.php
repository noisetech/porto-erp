<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RekeningBank extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'rekening_bank';

    protected $fillable = [
        'bank_master_id',
        'coa_d',
        'nama_rekening',
        'nama_pemilik',
        'mata_uang'
    ];
}
