<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Renja extends Model
{
	
        
        use SoftDeletes;
        protected $table = 'renja';
        protected $dates = ['deleted_at'];
        
	
        public function Periode()
        {
            return $this->hasOne('App\Models\Periode','id','periode_id');
        } 

        public function SKPD()
        {
            return $this->hasOne('App\Models\Skpd','id','skpd_id');
        } 

        public function KepalaSKPD()
        {
            return $this->hasOne('App\Models\HistoryJabatan','id','kepala_skpd_id');
        } 

        public function AdminSKPD()
        {
            return $this->hasOne('App\Models\HistoryJabatan','id','admin_skpd_id');
        } 
    

}
