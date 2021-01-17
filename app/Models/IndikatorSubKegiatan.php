<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class IndikatorSubKegiatan extends Model 
{

    use SoftDeletes;
    protected $table = 'renja_indikator_subkegiatan';
    protected $dates = ['deleted_at'];

    


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
