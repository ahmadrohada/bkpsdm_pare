<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RealisasiKegiatanTahunanJFT extends Model
{
    protected $table = 'realisasi_kegiatan_tahunan_jft';

    //tes

    public function CapaianTahunan()
    {
        return $this->hasOne('App\Models\CapaianTahunan','id','capaian_id');
    }

    public function KegiatanSKPTahunanJFT()
    {
        return $this->hasOne('App\Models\KegiatanSKPTahunanJFT','id','kegiatan_tahunan_id');
    }
}
