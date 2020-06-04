<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MasaPemerintahan extends Model
{
    
    use SoftDeletes;
    protected $table = 'masa_pemerintahan';
    protected $dates = ['deleted_at'];

  
    
    public function PeriodeAktif()
    {
    return $this->hasOne('App\Models\Periode', 'masa_pemerintahan_id')->where('status', 1);
    }
	
}
