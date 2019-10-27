<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{

    protected $connection = 'mysql2';
    protected $table = 'tb_pegawai';


    public function user()
    {
       return $this->hasOne('App\Models\User', 'id_pegawai');
    }


    public function history_jabatan()
    {
    return $this->hasMany('App\Models\HistoryJabatan', 'id_pegawai');
    }

    public function JabatanAktif()
    {
    return $this->hasOne('App\Models\HistoryJabatan', 'id_pegawai')->where('status','active');
    }
    

    public function GolonganAktif()
    {
    return $this->hasOne('App\Models\HistoryGolongan', 'id_pegawai')->where('status','active');
    }


    public function Foto()
    {
       return $this->hasOne('App\Models\Foto', 'nipbaru','nip');
    }

    

}
