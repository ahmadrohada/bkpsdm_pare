<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CapaianTahunan extends Model
{
   
    use SoftDeletes;
    protected $table = 'capaian_tahunan';
    protected $dates = ['deleted_at'];

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
    public function GolonganYangDinilai()
    {
        return $this->hasOne('App\Models\HistoryGolongan','id','u_golongan_id');
    }

    public function GolonganPenilai()
    {
        return $this->hasOne('App\Models\HistoryGolongan','id','p_golongan_id');
    }
    
}
