<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class IndikatorKegiatanSKPTahunan extends Model
{
    
    //use SoftDeletes;
    protected $table = 'skp_tahunan_indikator_kegiatan';
    protected $dates = ['deleted_at'];


    public function KegiatanSKPTahunan() 
    {
        return $this->belongsTo('App\Models\KegiatanSKPTahunan','kegiatan_id','id'); 
    } 


    public function RencanaAksi()
    {
        return $this->hasMany('App\Models\RencanaAksi','indikator_kegiatan_tahunan_id');
    }

    

}
