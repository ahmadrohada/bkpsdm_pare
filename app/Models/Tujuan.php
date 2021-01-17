<?php
 
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tujuan extends Model
{
    use SoftDeletes;
    protected $table = 'renja_tujuan';
    protected $dates = ['deleted_at'];


    protected static function boot() 
    {
        parent::boot();

        static::deleting(function($tujuan) {
            foreach ($tujuan->IndikatorTujuan()->get() as $indikator) {
                $indikator->delete();
            }
            foreach ($tujuan->Sasaran()->get() as $sasaran) {
                $sasaran->delete();
            }
        });

        static::restoring(function($tujuan) {
            foreach ($tujuan->IndikatorTujuan()->get() as $indikator) {
                $indikator->restore();
            }
            foreach ($tujuan->Sasaran()->get() as $sasaran) {
                $sasaran->restore();
            }
        });

    }



    public function IndikatorTujuan()
    {
        return $this->hasMany('App\Models\IndikatorTujuan');
    }

    public function Sasaran()
    {
        return $this->hasMany('App\Models\Sasaran');
    }

    public function misi()
    {
        return $this->belongTo('App\Models\Misi');
    }
}
