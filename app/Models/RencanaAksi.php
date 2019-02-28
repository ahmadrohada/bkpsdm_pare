<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RencanaAksi extends Model
{
    protected $table = 'skp_tahunan_rencana_aksi';

    public function Pelaksana()
    {
        return $this->hasOne('App\Models\Skpd','id','jabatan_id');
    }
    

    public function KegiatanTahunan() {
		return $this->belongsTo('App\Models\KegiatanSKPTahunan','kegiatan_tahunan_id');
	}

}
