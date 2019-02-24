<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SKPTahunanTimeline extends Model
{
    protected $table = 'skp_tahunan_timeline';



    
    public function SKPTahunan()
    {
        return $this->hasOne('App\Models\SKPTahunan','id','skp_tahunan_id');
    }

}
