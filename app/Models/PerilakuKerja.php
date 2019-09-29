<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PerilakuKerja extends Model
{
    protected $table = 'penilaian_perilaku_kerja';


    public function CapaianTahunan()
    {
        return $this->hasOne('App\Models\CapaianTahunan','id','capaian_tahunan_id');
    }
    
}
