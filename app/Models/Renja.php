<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Renja extends Model
{
	
        protected $table = 'renja';
	
        public function Periode()
        {
            return $this->hasOne('App\Models\Periode','id','periode_id');
        } 

        public function SKPD()
        {
            return $this->hasOne('App\Models\SKPD','id','skpd_id');
        } 

        public function KepalaSKPD()
        {
            return $this->hasOne('App\Models\HistoryJabatan','id','kaban_id');
        } 

        public function AdminSKPD()
        {
            return $this->hasOne('App\Models\HistoryJabatan','id','admin_skpd_id');
        } 
    

}
