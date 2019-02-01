<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MasaPemerintahan extends Model
{
    protected $table = 'masa_pemerintahan';

  
    
    public function PeriodeAktif()
    {
    return $this->hasOne('App\Models\Periode', 'masa_pemerintahan_id')->where('status', 1);
    }
	
}
