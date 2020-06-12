<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class KegiatanSKPBulanan extends Model
{
    
    //use SoftDeletes;
    protected $table = 'skp_bulanan_kegiatan';
    //protected $dates = ['deleted_at'];


    public function RencanaAksi()
    {
        return $this->belongsTo('App\Models\RencanaAksi','rencana_aksi_id');
    }  

}
