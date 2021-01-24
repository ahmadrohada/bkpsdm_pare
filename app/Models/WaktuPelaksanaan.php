<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WaktuPelaksanaan extends Model
{

    use SoftDeletes;
    protected $table = 'skp_tahunan_rencana_aksi_waktu_pelaksanaan';
    protected $dates = ['deleted_at'];


   

    public function RencanaAksi() 
    {
        return $this->belongsTo('App\Models\RencanaAksi','rencana_aksi_id'); 
    } 

    

}
