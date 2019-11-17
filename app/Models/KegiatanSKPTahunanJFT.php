<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KegiatanSKPTahunanJFT extends Model
{
    protected $table = 'skp_tahunan_kegiatan_jft';


    public function Sasaran()
    {
        return $this->belongsTo('App\Models\Sasaran','sasaran_id');
    } 

    

}
