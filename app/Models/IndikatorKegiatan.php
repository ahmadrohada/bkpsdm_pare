<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IndikatorKegiatan extends Model
{
    protected $table = 'indikator_kegiatan';



    public function skp_tahunan()
    {
        return $this->hasMany('App\Models\SkpTahunan');
    }


    public function kegiatan()
    {
        return $this->belongTo('App\Models\Kegiatan');
    }
}
