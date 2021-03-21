<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SKPTahunan extends Model
{
    //use SoftDeletes;
    protected $table = 'skp_tahunan';
    //protected $dates = ['deleted_at'];


    public function Renja() 
    {
        return $this->hasOne('App\Models\Renja','id','renja_id');
    }

    public function KegiatanTahunan()
    {
        return $this->hasMany('App\Models\KegiatanSKPTahunan','skp_tahunan_id')->select('id');
    }

    public function SKPBulanan()
    {
        return $this->hasMany('App\Models\SKPBulanan','skp_tahunan_id')->select('id');
    }
    
    public function PegawaiYangDinilai()
    {
        return $this->hasOne('App\Models\HistoryJabatan','id','u_jabatan_id');
    }

    public function PejabatPenilai()
    {
        return $this->hasOne('App\Models\HistoryJabatan','id','p_jabatan_id');
    }
    public function AtasanPejabatPenilai()
    {
        return $this->hasOne('App\Models\HistoryJabatan','id','ap_jabatan_id');
    }

    public function GolonganYangDinilai()
    {
        return $this->hasOne('App\Models\HistoryGolongan','id','u_golongan_id');
    }

    public function GolonganPenilai()
    {
        return $this->hasOne('App\Models\HistoryGolongan','id','p_golongan_id');
    }
    public function GolonganAtasanPenilai()
    {
        return $this->hasOne('App\Models\HistoryGolongan','id','ap_golongan_id');
    }

   

    
}
