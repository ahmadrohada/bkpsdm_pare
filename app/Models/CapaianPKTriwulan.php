<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CapaianPKTriwulan extends Model
{
    
    //use SoftDeletes;
    protected $table = 'capaian_pk_triwulan';
    //protected $dates = ['deleted_at'];

    public function Renja()
    {
        return $this->hasOne('App\Models\Renja','id','renja_id');
    }
   
   
    
}
