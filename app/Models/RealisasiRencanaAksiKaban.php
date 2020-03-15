<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RealisasiRencanaAksiKaban extends Model
{
    protected $table = 'realisasi_rencana_aksi_eselon2';

    public function CapaianBulanan()
    {
        return $this->hasOne('App\Models\CapaianBulanan','id','capaian_bulanan_id');
    }


    public function RencanaAksi() {
		return $this->belongsTo('App\Models\RencanaAksi','rencana_aksi_id');
	}

    public function KegiatanSKPTahunan()
    {
        return $this->hasOne('App\Models\KegiatanSKPTahunan','id','kegiatan_tahunan_id');
    }
}
