<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoleUser extends Model
{
    //

    protected $table = 'role_user';


    public function user()
    {
        return $this->hasMany('App\Models\User');
    }

}
