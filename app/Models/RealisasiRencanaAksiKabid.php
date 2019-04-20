<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RealisasiRencanaAksiKabid extends Model
{
    protected $table = 'realisasi_rencana_aksi_kabid';

    public function CapaianBulanan()
    {
        return $this->hasOne('App\Models\CapaianBulanan','id','capaian_bulanan_id');
    }


    public function RencanaAksi() {
		return $this->belongsTo('App\Models\RencanaAksi','rencana_aksi_id');
	}

}
