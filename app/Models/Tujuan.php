<?php
 
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tujuan extends Model
{
    //use SoftDeletes;
    protected $table = 'renja_tujuan';
    //protected $dates = ['deleted_at'];

    public function sasaran()
    {
        return $this->hasMany('App\Models\Sasaran');
    }

    public function misi()
    {
        return $this->belongTo('App\Models\Misi');
    }
}
