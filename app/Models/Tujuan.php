<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tujuan extends Model
{
    protected $table = 'renja_tujuan';



    public function sasaran()
    {
        return $this->hasMany('App\Models\Sasaran');
    }


    public function misi()
    {
        return $this->belongTo('App\Models\Misi');
    }
}
