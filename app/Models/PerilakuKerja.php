<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PerilakuKerja extends Model
{
   
    use SoftDeletes;
    protected $table = 'penilaian_perilaku_kerja';
    protected $dates = ['deleted_at'];


    public function CapaianTahunan()
    {
        return $this->hasOne('App\Models\CapaianTahunan','id','capaian_tahunan_id');
    }
    
}
