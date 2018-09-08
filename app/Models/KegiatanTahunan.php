<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KegiatanTahunan extends Model
{
    protected $table = 'kegiatan_skp_tahunan';


    public function kegiatan()
    {
        return $this->belongsTo('App\Models\Kegiatan','kegiatan_perjanjian_kinerja_id');
    } 

}
