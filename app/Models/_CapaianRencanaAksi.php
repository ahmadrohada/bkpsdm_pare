<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CapaianRencanaAksi extends Model
{
    protected $table = 'capaian_rencana_aksi';

    //tes

    public function CapaianBulanan()
    {
        return $this->hasOne('App\Models\CapaianBulanan','id','capaian_bulanan_id');
    }


    public function RencanaAksi() {
		return $this->belongsTo('App\Models\RencanaAksi','rencana_aksi_id');
	}

    
}
