<?php

namespace App\Models; 

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubKegiatan extends Model
{
    use SoftDeletes;
    protected $table = 'renja_subkegiatan';
    protected $dates = ['deleted_at'];


    //hanya menghapus/restore sampai indikatornya saja.
    protected static function boot() 
    {
        parent::boot();

        static::deleting(function($subkegiatan) {
            foreach ($subkegiatan->IndikatorSubKegiatan()->get() as $indikator) {
                $indikator->delete();
            }
        });

        static::restoring(function($subkegiatan) {
            foreach ($subkegiatan->IndikatorSubKegiatan()->get() as $indikator) {
                $indikator->restore();
            }
        });

    }


   
    public function IndikatorSubKegiatan()
    {
        return $this->hasMany('App\Models\IndikatorSubKegiatan');
    }

    public function KegiatanSKPTahunan()
    {
        return $this->hasMany('App\Models\KegiatanSKPTahunan','subkegiatan_id');
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
