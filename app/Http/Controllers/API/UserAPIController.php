<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Hash;

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
       
        $profile = User::findOrFail(Input::get('user_id'));
        //$profile->nama = Input::get('nama');
        //$profile->jeniskelamin = Input::get('jeniskelamin');
        //$profile->active = '1';
        $profile->api_token = '';
        $profile->password = Hash::make('bkd12345');
        $profile->save(); 
        
    }


    public function ubah_username(Request $request)
    {
        
        


        $messages = [
            'new_username.required'         => 'Username harus diisi',
        ];

        $validator = Validator::make(
                        Input::all(),
                        array(
                            'new_username'    => 'required|min:3',
                        ),
                        $messages
        );
    
        if ( $validator->fails() ){
            //$messages = $validator->messages();
            return response()->json(['errors'=>$validator->messages()],422);
            
        }
        $profile = User::findOrFail(Input::get('user_id'));
        $profile->username = Input::get('new_username');
        //$profile->jeniskelamin = Input::get('jeniskelamin');
       
        
        if ( $profile->save()){
            return \Response::make('sukses', 200);
        }else{
            return \Response::make('error', 500);
        } 
        
    }

   

}
