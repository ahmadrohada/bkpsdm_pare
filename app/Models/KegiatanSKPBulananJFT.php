<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KegiatanSKPBulananJFT extends Model
{
    protected $table = 'skp_bulanan_kegiatan_jft';


    public function KegiatanTahunan()
    {
        return $this->belongsTo('App\Models\KegiatanSKPTahunanJFT','kegiatan_tahunan_id');
    }  

}
