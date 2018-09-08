<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SKPTahunan extends Model
{
    protected $table = 'skp_tahunan';


    public function perjanjian_kinerja()
    {
        return $this->hasOne('App\Models\PerjanjianKinerja','id','perjanjian_kinerja_id');
    }
    
    public function pejabat_yang_dinilai()
    {
        return $this->hasOne('App\Models\HistoryJabatan','id','jabatan_id');
    }

    public function pejabat_penilai()
    {
        return $this->hasOne('App\Models\HistoryJabatan','id','jabatan_atasan_id');
    }
}
