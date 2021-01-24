<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RencanaAksi extends Model
{
    
    protected $table = 'skp_tahunan_rencana_aksi';

    public function WaktuPelaksanaan()
    {
        return $this->hasMany('App\Models\WaktuPelaksanaan','rencana_aksi_id');
    }


    public function Pelaksana()
    {
        return $this->hasOne('App\Models\Skpd','id','jabatan_id')->select('skpd as jabatan');
    }
    

    public function IndikatorKegiatanSKPTahunan() {
		return $this->belongsTo('App\Models\IndikatorKegiatanSKPTahunan','indikator_kegiatan_tahunan_id');
	}

}
