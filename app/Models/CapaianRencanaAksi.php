<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CapaianRencanaAksi extends Model
{
    
    use SoftDeletes;
    protected $table = 'capaian_bulanan';
    protected $dates = ['deleted_at'];

    //tes

    public function SKPBulanan()
    {
        return $this->hasOne('App\Models\SKPBulanan','id','skp_bulanan_id');
    }

   

   
    public function PegawaiYangDinilai()
    {
        return $this->hasOne('App\Models\HistoryJabatan','id','u_jabatan_id');
    }

    public function PejabatPenilai()
    {
        return $this->hasOne('App\Models\HistoryJabatan','id','p_jabatan_id');
    }
}
