<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    protected $table = 'program';



    public function indikator_program()
    {
        return $this->hasMany('App\Models\Indikatorprogram');
    }


  /*   public function indikator_sasaran()
    {
        return $this->belongTo('App\Models\IndikatorSasaran');
    } */

    public function indikator_sasaran()
    {
        return $this->hasOne('App\Models\IndikatorSasaran','id','indikator_sasaran_id');
    }
}
