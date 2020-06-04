<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class KegiatanSKPBulananJFT extends Model
{
    
    use SoftDeletes;
    protected $table = 'skp_bulanan_kegiatan_jft';
    protected $dates = ['deleted_at'];


    public function KegiatanTahunan()
    {
        return $this->belongsTo('App\Models\KegiatanSKPTahunanJFT','kegiatan_tahunan_id');
    }  

}
