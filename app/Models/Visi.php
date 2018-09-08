<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Visi extends Model
{
    //

    protected $table = 'visi';


    public function misi()
    {
        return $this->hasMany('App\Models\Misi');
    }

}
