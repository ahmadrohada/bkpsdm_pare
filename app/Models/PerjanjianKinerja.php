<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PerjanjianKinerja extends Model
{
    protected $table = 'perjanjian_kinerja';



    /* public function periode_tahunan()
    {
        return $this->hasOne('App\Models\PeriodeTahunan','id','periode_tahunan_id');
    } */


    /*
	 * Relasi One-to-Many
	 * =================
	 * Buat function bernama periode_tahunan(), dimana model 'PerjanjianKinerja' memiliki 
	 * relasi One-to-Many (belongsTo) sebagai penerima 'periode_tahunan_id'
	 */
	public function periode_tahunan() {
		return $this->belongsTo('App\Models\Periode','periode_id');
	}



    public function sasaran_perjanjian_kinerja()
    {
        return $this->belongsTo('App\Models\SasaranPerjanjianKinerja','id');
    }

    public function renja()
    {
       return $this->hasOne('App\Models\Renja', 'id','renja_id');
    }
    
}
