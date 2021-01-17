<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class IndikatorProgram extends Model
{
    use SoftDeletes;
    protected $table = 'renja_indikator_program';
    protected $dates = ['deleted_at'];




    public function Program()
    {
        return $this->hasOne('App\Models\Program','id','program_id');
    }
    
} 
