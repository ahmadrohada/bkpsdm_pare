<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CapaianTahunan extends Model
{
    protected $table = 'capaian_tahunan';

    //tes

    public function SKPTahunan()
    {
        return $this->hasOne('App\Models\SKPTahunan','id','skp_tahunan_id');
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
