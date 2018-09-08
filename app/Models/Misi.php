<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Misi extends Model
{
    protected $table = 'misi';

    public function tujuan()
    {
        return $this->hasMany('App\Models\Tujuan');
    }

    public function visi()
    {
        return $this->belongTo('App\Models\Visi');
    }

}
