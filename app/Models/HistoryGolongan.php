<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HistoryGolongan extends Model
{
    
    protected $connection = 'mysql2';
    protected $table = 'tb_history_golongan';

    protected $fillable = [
        'id_pegawai', 'golongan','status'
    ];  
 
    /**
     * Untuk mendapatkan data pegawai yang berelasi dengan history jabatan.
     */
    public function Pegawai()
    {
        return $this->belongsTo('App\Models\Pegawai','id_pegawai');
    }


    public function Golongan()
    {
        return $this->hasOne('App\Models\Golongan','id','id_golongan');
    }

  
}
