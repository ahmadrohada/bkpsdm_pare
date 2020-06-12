<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class KegiatanSKPTahunanJFT extends Model
{
   
    //use SoftDeletes;
    protected $table = 'skp_tahunan_kegiatan_jft';
    //protected $dates = ['deleted_at'];


    public function Sasaran()
    {
        return $this->belongsTo('App\Models\Sasaran','sasaran_id');
    } 

    

}
