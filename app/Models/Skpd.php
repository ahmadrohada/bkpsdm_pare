<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Skpd extends Model
{

    protected $connection = 'mysql2';
    protected $table = 'm_skpd';

    /* protected $fillable = [
        'id', 'unit_kerja','id_skpd'
    ];  */


   /*  public function history_jabatan()
    {
        return $this->belongsTo('App\Models\HistoryJabatan','id_skpd');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\Users');
    } */

    public function UnitKerja()
    {
        return $this->hasMany('App\Models\Skpd','parent_id','id');
    }

    public function bidang()
    {
        return $this->hasOne('App\Models\UnitKerja','id','id');
    }



   
}
