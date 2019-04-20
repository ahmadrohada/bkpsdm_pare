<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RealisasiRencanaAksiKaban extends Model
{
    protected $table = 'realisasi_rencana_aksi_kaban';

    public function CapaianBulanan()
    {
        return $this->hasOne('App\Models\CapaianBulanan','id','capaian_bulanan_id');
    }


    public function RencanaAksi() {
		return $this->belongsTo('App\Models\RencanaAksi','rencana_aksi_id');
	}

}
