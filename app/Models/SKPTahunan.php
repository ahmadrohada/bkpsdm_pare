<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SKPTahunan extends Model
{
    protected $table = 'skp_tahunan';


    public function PerjanjianKinerja()
    {
        return $this->hasOne('App\Models\PerjanjianKinerja','id','perjanjian_kinerja_id');
    }
    
    public function PejabatYangDinilai()
    {
        return $this->hasOne('App\Models\HistoryJabatan','id','u_jabatan_id');
    }

    public function PejabatPenilai()
    {
        return $this->hasOne('App\Models\HistoryJabatan','id','p_jabatan_id');
    }

    
}
