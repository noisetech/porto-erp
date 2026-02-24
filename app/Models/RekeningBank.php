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
        'coa_id',
        'nama_rekening',
        'nama_pemilik',
        'mata_uang'
    ];


    public function bank_master()
    {
        return $this->belongsTo(MasterBank::class, 'bank_master_id', 'id');
    }

    public function coa()
    {
        return $this->belongsTo(COA::class, 'coa_id', 'id');
    }
}
