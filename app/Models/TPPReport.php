<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TPPReport extends Model
{

    use SoftDeletes;
    protected $table = 'tpp_report';
    protected $dates = ['deleted_at'];
    

    public function FormulaHitung()
    {
        return $this->hasOne('App\Models\FormulaHitungTPP','id','formula_hitung_id');
    }

    public function SKPD()
    {
        return $this->hasOne('App\Models\Skpd','id','skpd_id')->Select('skpd as nama_skpd');
    }
    
}
