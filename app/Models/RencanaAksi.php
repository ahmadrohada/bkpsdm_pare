<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RencanaAksi extends Model
{
    protected $table = 'skp_tahunan_rencana_aksi';

    public function Pelaksana()
    {
        return $this->hasOne('App\Models\SKPD','id','jabatan_id');
    }
    

}
