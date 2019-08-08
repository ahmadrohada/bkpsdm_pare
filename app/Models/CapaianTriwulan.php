<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CapaianTriwulan extends Model
{
    protected $table = 'capaian_triwulan';

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
