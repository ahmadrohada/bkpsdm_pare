<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Foto extends Model
{
    protected $connection = 'mysql2';
    protected $table = 'foto';



   /*  public function pegawai()
    {
        return $this->belongTo('App\Models\Pegawai');
    } */

}
