<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IndikatorProgram extends Model
{
    protected $table = 'renja_indikator_program';



    public function kegiatan()
    {
        return $this->hasMany('App\Models\Kegiatan');
    }

/* 
     public function program()
    {
        return $this->belongTo('App\Models\Program');
    } */

    public function program()
    {
        return $this->hasOne('App\Models\Program','id','program_id');
    }
    
} 
