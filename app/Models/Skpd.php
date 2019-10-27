<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SKPD extends Model
{

    protected $connection = 'mysql2';
    protected $table = 'm_skpd';


    public function UnitKerja()
    {
        return $this->hasMany('App\Models\Skpd','parent_id','id');
    }

    public function Bidang()
    {
        return $this->hasOne('App\Models\UnitKerja','id','id');
    }

  

  
   
}
