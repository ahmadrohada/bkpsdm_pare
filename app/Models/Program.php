<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Program extends Model
{
    //use SoftDeletes;
    protected $table = 'renja_program';
    //protected $dates = ['deleted_at'];


    
    public function indikator_program()
    {
        return $this->hasMany('App\Models\Indikatorprogram');
    }

    public function indikator_sasaran()
    {
        return $this->hasOne('App\Models\IndikatorSasaran','id','indikator_sasaran_id');
    } 
    
}
