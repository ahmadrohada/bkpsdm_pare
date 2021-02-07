<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sasaran extends Model
{
    use SoftDeletes;
    protected $table = 'renja_sasaran';
    protected $dates = ['deleted_at'];


    protected static function boot() 
    {
        parent::boot();

        static::deleting(function($sasaran) {
            foreach ($sasaran->IndikatorSasaran()->get() as $indikator) {
                $indikator->delete();
            }
            foreach ($sasaran->Program()->get() as $program) {
                $program->delete();
            }
        });

        static::restoring(function($sasaran) {
            foreach ($sasaran->IndikatorSasaran()->get() as $indikator) {
                $indikator->restore();
            }
            foreach ($sasaran->Program()->get() as $program) {
                $program->restore();
            }
        });

    }


    public function Program()
    {
        return $this->hasMany('App\Models\Program');
    }

    public function IndikatorSasaran()
    {
        return $this->hasMany('App\Models\IndikatorSasaran');
    }







    public function Tujuan()
    {
        return $this->belongsTo('App\Models\Tujuan');
    }

    public function sasaran_perjanjian_kinerja()
    {
        return $this->belongsTo('App\Models\SasaranPerjanjianKinerja','sasaran_id','sasaran_id');
    } 
    
    
   
	
}
