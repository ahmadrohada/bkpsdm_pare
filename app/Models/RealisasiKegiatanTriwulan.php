<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RealisasiKegiatanTriwulan extends Model
{
    protected $table = 'realisasi_kegiatan_triwulan';

    //tes

    /* public function CapaianBulanan()
    {
        return $this->hasOne('App\Models\CapaianBulanan','id','capaian_bulanan_id');
    }

    public function KegiatanSKPBulanan()
    {
        return $this->hasOne('App\Models\KegiatanSKPBulanan','id','kegiatan_bulanan_id');
    } */

    public function KegiatanSKPTahunan()
    {
        return $this->hasOne('App\Models\KegiatanSKPTahunan','id','kegiatan_tahunan_id');
    } 
}
