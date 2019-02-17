<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SKPTahunan extends Model
{
    protected $table = 'skp_tahunan';


    public function Renja()
    {
        return $this->hasOne('App\Models\Renja','id','renja_id');
    }
    
    public function PejabatYangDinilai()
    {
        return $this->hasOne('App\Models\HistoryJabatan','id','u_jabatan_id');
    }

    public function PejabatPenilai()
    {
        return $this->hasOne('App\Models\HistoryJabatan','id','p_jabatan_id');
    }

    
}
