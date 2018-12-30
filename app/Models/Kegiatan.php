<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kegiatan extends Model
{
    protected $table = 'renja_kegiatan';



    public function indikator_kegiatan()
    {
        return $this->hasMany('App\Models\IndikatorKegiatan');
    }


   /*  public function indikator_program()
    {
        return $this->belongTo('App\Models\IndikatorProgram');
    } 
 */
    public function indikator_program()
    {
        return $this->belongsTo('App\Models\IndikatorProgram','id','indikator_program_id');
    } 

    public function pengelola()
    {
        return $this->hasOne('App\Models\Skpd','id','jabatan_id')->select('skpd as jabatan');
    } 

    public function kegiatan_skp_tahunan()
    {
        return $this->belongsTo('App\Models\KegiatanTahunan','kegiatan_perjanjian_kinerja_id','kegiatan_perjanjian_kinerja_id');
    } 
    
}
