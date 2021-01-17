<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Program extends Model
{
    use SoftDeletes;
    protected $table = 'renja_program';
    protected $dates = ['deleted_at'];

    protected static function boot() 
    {
        parent::boot();

        //delete child when delete parent
        static::deleting(function($program) {
            foreach ($program->IndikatorProgram()->get() as $indikator) {
                $indikator->delete();
            }

            foreach ($program->Kegiatan()->get() as $kegiatan) {
                $kegiatan->delete();
            }
        });

        //restore child when restore parent
        static::restoring(function ($program) {
            foreach ($program->IndikatorProgram()->get() as $indikator) {
                $indikator->restore();
            }

            foreach ($program->Kegiatan()->get() as $kegiatan) {
                $kegiatan->restore();
            }
        }); 

    }


    
    public function IndikatorProgram()
    {
        return $this->hasMany('App\Models\Indikatorprogram');
    }

    public function Kegiatan()
    {
        return $this->hasMany('App\Models\Kegiatan');
    }




    /* public function indikator_sasaran()
    {
        return $this->hasOne('App\Models\IndikatorSasaran','id','indikator_sasaran_id');
    } 
     */
}
