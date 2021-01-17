<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class IndikatorKegiatan extends Model
{

    use SoftDeletes;
    protected $table = 'renja_indikator_kegiatan';
    protected $dates = ['deleted_at'];
    




    public function SKPTahunan()
    {
        return $this->hasMany('App\Models\SkpTahunan');
    }


    public function Kegiatan()
    {
        return $this->belongsTo('App\Models\Kegiatan','kegiatan_id');
    }


    public function RencanaAksi()
    {
        return $this->hasMany('App\Models\RencanAksi');
    }



}
