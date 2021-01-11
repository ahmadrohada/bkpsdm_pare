<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class IndikatorSubKegiatan extends Model
{

    protected $table = 'renja_indikator_subkegiatan';


    public function SKPTahunan()
    {
        return $this->hasMany('App\Models\SKPTahunan');
    }


    public function SubKegiatan()
    {
        return $this->belongsTo('App\Models\SubKegiatan','subkegiatan_id');
    }


    public function RencanaAksi()
    {
        return $this->hasMany('App\Models\RencanAksi');
    }



}
