<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HistoryJabatan extends Model
{
    
    protected $connection = 'mysql2';
    protected $table = 'tb_history_jabatan';


    protected $fillable = [
        'id_pegawai', 'jabatan','id_skpd'
    ]; 
 
    /**
     * Untuk mendapatkan data pegawai yang berelasi dengan history jabatan.
     */
    public function pegawai()
    {
        return $this->belongsTo('App\Models\Pegawai','id_pegawai');
    }


    public function skpd()
    {
        return $this->hasOne('App\Models\Skpd','id','id_skpd');
    }

    public function UnitKerja()
    {
        return $this->hasOne('App\Models\UnitKerja','id','id_unit_kerja');
    }

    public function eselon()
    {
        return $this->hasOne('App\Models\Eselon','id','id_eselon');
    }

    public function golongan()
    {
        return $this->hasOne('App\Models\Golongan','id','id_golongan');
    }

    public function child_jabatan()
    {
        return $this->hasmany('App\Models\Skpd','parent_id','id_jabatan');
    }
}
