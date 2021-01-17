<?php

namespace App\Models; 

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kegiatan extends Model
{
    use SoftDeletes;
    protected $table = 'renja_kegiatan';
    protected $dates = ['deleted_at'];


    protected static function boot() 
    {
        parent::boot();

        static::deleting(function($kegiatan) {
            foreach ($kegiatan->IndikatorKegiatan()->get() as $indikator) {
                $indikator->delete();
            }
            foreach ($kegiatan->SubKegiatan()->get() as $subkegiatan) {
                $subkegiatan->delete();
            }
        });

        static::restoring(function($kegiatan) {
            foreach ($kegiatan->IndikatorKegiatan()->get() as $indikator) {
                $indikator->restore();
            }
            foreach ($kegiatan->SubKegiatan()->get() as $subkegiatan) {
                $subkegiatan->restore();
            }
        });

    }

    public function IndikatorKegiatan()
    {
        return $this->hasMany('App\Models\IndikatorKegiatan');
    }

    public function SubKegiatan()
    {
        return $this->hasMany('App\Models\SubKegiatan');
    }


    public function indikator_program()
    {
        return $this->belongsTo('App\Models\IndikatorProgram','id','indikator_program_id');
    } 

    public function PenanggungJawab()
    {
        return $this->hasOne('App\Models\Skpd','id','jabatan_id')->select('skpd as jabatan');
    } 

    public function kegiatan_skp_tahunan()
    {
        return $this->belongsTo('App\Models\KegiatanTahunan','kegiatan_perjanjian_kinerja_id','kegiatan_perjanjian_kinerja_id');
    } 
    
}
