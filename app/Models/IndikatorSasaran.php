<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IndikatorSasaran extends Model
{
    protected $table = 'indikator_sasaran';



    public function program()
    {
        return $this->hasMany('App\Models\Program');
    }


    public function sasaran_perjanjian_kinerja()
    {
        return $this->belongsTo('App\Models\SasaranPerjanjianKinerja');
    }
}
