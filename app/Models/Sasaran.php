<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sasaran extends Model
{
    protected $table = 'renja_sasaran';

    public function tujuan()
    {
        return $this->belongsTo('App\Models\Tujuan');
    }

    public function sasaran_perjanjian_kinerja()
    {
        return $this->belongsTo('App\Models\SasaranPerjanjianKinerja','sasaran_id','sasaran_id');
    } 
    
    
    public function IndikatorSasaran()
    {
        return $this->hasMany('App\Models\IndikatorSasaran');
    }
	
}
