<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LogMasterBank extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'l_bank_master';

    protected $fillable = [
        'user_id', 'bank_master_id', 'keterangan'
    ];
}
