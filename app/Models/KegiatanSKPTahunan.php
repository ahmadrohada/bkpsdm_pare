<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KegiatanSKPTahunan extends Model
{
    protected $table = 'skp_tahunan_kegiatan';


    public function IndikatorKegiatan()
    {
        return $this->belongsTo('App\Models\IndikatorKegiatan','indikator_kegiatan_id');
    } 

  

}
