<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SKPBulanan extends Model
{
    protected $table = 'skp_bulanan';

    //tes

    public function skp_tahunan()
    {
        return $this->hasOne('App\Models\SKPTahunan','id','skp_tahunan_id');
    }

    public function Pejabat_yang_dinilai()
    {
        return $this->hasOne('App\Models\HistoryJabatan','id','u_jabatan_id');
    }

    public function Pejabat_penilai()
    {
        return $this->hasOne('App\Models\HistoryJabatan','id','p_jabatan_id');
    }
}
