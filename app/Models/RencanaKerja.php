<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RencanaKerja extends Model
{
	
	
	protected $table = 'rencana_kerja';
	
   //category has childs
   public function childs() {
           return $this->hasMany('App\Models\RencanaKerja','parent_id','id') ;
   }

}
