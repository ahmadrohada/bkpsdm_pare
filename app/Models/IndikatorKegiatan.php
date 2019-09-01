<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IndikatorKegiatan extends Model
{
    protected $table = 'renja_indikator_kegiatan';


    public function skp_tahunan()
    {
        return $this->hasMany('App\Models\SkpTahunan');
    }


    public function Kegiatan()
    {
        return $this->belongsTo('App\Models\Kegiatan','kegiatan_id');
    }



}
