<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RealisasiKegiatanBulananJFT extends Model
{
    protected $table = 'realisasi_kegiatan_bulanan_jft';

    //tes

    public function CapaianBulanan()
    {
        return $this->hasOne('App\Models\CapaianBulanan','id','capaian_bulanan_id');
    }

    public function KegiatanSKPBulanan()
    {
        return $this->hasOne('App\Models\KegiatanSKPBulananJFT','id','kegiatan_bulanan_id');
    }
}
