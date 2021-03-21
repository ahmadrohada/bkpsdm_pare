<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class KodeEtik extends Model
{
   
    //use SoftDeletes;
    protected $table = 'penilaian_kode_etik';
    //protected $dates = ['deleted_at'];


    public function CapaianBulanan()
    {
        return $this->belongsTo('App\Models\CapaianBulanan','capaian_bulanan_id');
    }
}
