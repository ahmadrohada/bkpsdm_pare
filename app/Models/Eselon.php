<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Eselon extends Model
{
    protected $connection = 'mysql2';
    protected $table = 'm_eselon';


    public function jenis_jabatan()
    {
        return $this->hasOne('App\Models\JenisJabatan','id','id_jenis_jabatan');
    } 

    public function JenisJabatan()
    {
        return $this->hasOne('App\Models\JenisJabatan','id','id_jenis_jabatan')->select('jenis_jabatan','jenis_jabatan as label');
    } 
   
}
