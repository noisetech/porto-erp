<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ModelRekeningBank extends Model
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

    public function master_bank()
    {
        return $this->belongsTo(ModelMasterBank::class, 'bank_master_id', 'id');
    }

    public function coa()
    {
        return $this->belongsTo(ModelCoa::class, 'coa_id', 'id');
    }
}
