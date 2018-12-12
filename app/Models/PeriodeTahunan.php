<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PeriodeTahunan extends Model
{
    protected $table = 'periode_rkpd';

    //protected $fillable = array('label');


	public function perjanjian_kinerja() {
		return $this->hasOne('App\Models\PerjanjianKinerja','periode_id','id');
	} 

	
}
