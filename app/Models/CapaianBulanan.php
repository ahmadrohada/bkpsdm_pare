<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CapaianBulanan extends Model
{
    protected $table = 'capaian_bulanan';

    //tes

    public function SKPBulanan()
    {
        return $this->hasOne('App\Models\SKPBulanan','id','skp_bulanan_id');
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
