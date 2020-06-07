<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sasaran extends Model
{
    //use SoftDeletes;
    protected $table = 'renja_sasaran';
    //protected $dates = ['deleted_at'];

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
