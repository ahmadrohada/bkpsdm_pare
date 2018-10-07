<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;

use App\Models\Pegawai;
use App\Models\SKPTahunan;
use App\Models\Jabatan;
use App\Models\HistoryJabatan;
use App\Models\User;

use App\Helpers\Pustaka;

use Datatables;
use Validator;
use Gravatar;
use Input;
Use Alert;

class UserAPIController extends Controller {


    public function reset_password(Request $request)
    {
       
        $profile = User::findOrFail(1);
        //$profile->nama = Input::get('nama');
        //$profile->jeniskelamin = Input::get('jeniskelamin');
        $profile->active = Input::get('user_id');
        $profile->save(); 
        
    }

   

}
