<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SkpBulanan extends Model
{
    protected $table = 'skp_bulanan';



    public function skp_tahunan()
    {
        return $this->belongTo('App\Models\SkpTahunan');
    }
}
