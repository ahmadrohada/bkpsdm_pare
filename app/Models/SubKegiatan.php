<?php

namespace App\Models; 

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubKegiatan extends Model
{
 
    protected $table = 'renja_subkegiatan';
  
   
    public function IndikatorSubKegiatan()
    {
        return $this->hasMany('App\Models\IndikatorSubKegiatan');
    }


  /*   public function IndikatorKegiatan()
    {
        return $this->belongsTo('App\Models\IndikatorKegiatan','id','indikator_kegiatan_id');
    }  */

    public function PenanggungJawab()
    {
        return $this->hasOne('App\Models\Skpd','id','jabatan_id')->select('skpd as jabatan');
    } 

    public function KegiatanTahunan()
    {
        return $this->belongsTo('App\Models\KegiatanTahunan');
    } 
    
}
