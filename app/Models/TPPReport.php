<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TPPReport extends Model
{
    protected $table = 'tpp_report';

    public function FormulaHitung()
    {
        return $this->hasOne('App\Models\FormulaHitungTPP','id','formula_hitung_id');
    }
    
}
