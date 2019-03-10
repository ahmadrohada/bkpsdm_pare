<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KegiatanSKPBulanan extends Model
{
    protected $table = 'skp_bulanan_kegiatan';


    public function RencanaAksi()
    {
        return $this->belongsTo('App\Models\RencanaAksi','rencana_aksi_id');
    }  

}
