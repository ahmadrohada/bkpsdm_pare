<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TugasTambahan extends Model
{
    use SoftDeletes;
    protected $table = 'skp_tahunan_tugas_tambahan';
    protected $dates = ['deleted_at'];



    
}
