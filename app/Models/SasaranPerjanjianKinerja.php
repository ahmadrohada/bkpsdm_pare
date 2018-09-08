<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SasaranPerjanjianKinerja extends Model
{
    protected $table = 'sasaran_perjanjian_kinerja';



    public function sasaran()
    {
        return $this->hasOne('App\Models\Sasaran','id','sasaran_id');
    }


    public function perjanjian_kinerja()
    {
        return $this->hasOne('App\Models\PerjanjianKinerja','id','perjanjian_kinerja_id');
    }
    
    public function indikator_sasaran()
    {
        return $this->hasMany('App\Models\IndikatorSasaran');
    }
    

    public function jabatan()
    {
        return $this->hasOne('App\Models\Jabatan','id','jabatan_id');
    }
}
