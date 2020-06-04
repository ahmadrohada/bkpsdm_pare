<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KegiatanSKPTahunan extends Model
{
    protected $table = 'skp_tahunan_kegiatan';


    public function Kegiatan() 
    {
        return $this->belongsTo('App\Models\Kegiatan','kegiatan_id'); 
    } 

    

}
