<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Misi extends Model
{
    use SoftDeletes;
    protected $table = 'misi';
    protected $dates = ['deleted_at'];

    public function tujuan()
    {
        return $this->hasMany('App\Models\Tujuan');
    }

    public function visi()
    {
        return $this->belongTo('App\Models\Visi');
    }

}
