<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RealisasiKegiatanTahunan extends Model
{
    protected $table = 'realisasi_kegiatan_tahunan';

    //tes

    public function CapaianTahunan()
    {
        return $this->hasOne('App\Models\CapaianTahunan','id','capaian_id');
    }

    public function KegiatanSKPTahunan()
    {
        return $this->hasOne('App\Models\KegiatanSKPTahunan','id','kegiatan_tahunan_id');
    }
}
