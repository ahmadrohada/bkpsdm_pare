<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class KegiatanSKPTahunan extends Model
{

    use SoftDeletes;
    protected $table = 'skp_tahunan_kegiatan';
    protected $dates = ['deleted_at'];


    public static function boot()
    {
        parent::boot();

        static::deleting(function($kegiatan) {
            foreach ($kegiatan->IndikatorKegiatanSKPTahunan()->get() as $indikator) {
                $indikator->delete();
            }
        });

        static::restoring(function($kegiatan) {
            foreach ($kegiatan->IndikatorKegiatanSKPTahunan()->withTrashed()->get() as $indikator) {
                $indikator->restore();
            } 
        });

    } 



    public function IndikatorKegiatanSKPTahunan()
    {
        return $this->hasMany('App\Models\IndikatorKegiatanSKPTahunan','kegiatan_id');
    }

    


    public function SubKegiatan() 
    {
        return $this->belongsTo('App\Models\SubKegiatan','subkegiatan_id'); 
    } 

    

}
