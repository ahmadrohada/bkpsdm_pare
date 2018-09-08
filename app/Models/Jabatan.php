<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jabatan extends Model
{

    protected $connection = 'mysql2';
    protected $table = 'm_skpd';


    //nama jabatan = field skpd

    protected $fillable = [
        'id', 'parent_id','id_skpd','id_eselon','skpd',
    ]; 


    public function historyjabatan()
    {
        return $this->belongsTo('App\Models\HistoryJabatan','id_skpd');
    }

  

}
