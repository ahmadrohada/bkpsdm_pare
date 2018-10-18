<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Support\Facades\Hash;

use App\Models\Pegawai;
use App\Models\SKPTahunan;
use App\Models\Jabatan;
use App\Models\HistoryJabatan;
use App\Models\User;

use App\Helpers\Pustaka;


use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Facades;
use Illuminate\Http\Request;

use Datatables;
use Validator;
use Gravatar;
use Input;
Use Alert;

class UserAPIController extends Controller {

    

    public function add_user(Request $request)
    {
        $cek_data = User::WHERE('id_pegawai',Input::get('pegawai_id'))->count();
        //return $cek_data;

        if ( $cek_data === 0 ){


            $messages = [
                'nip.required'         => 'NIP harus diisi',
            ];
    
            $validator = Validator::make(
                            Input::all(),
                            array(
                                'nip'           => 'required|min:3',
                                'pegawai_id'    => 'required',
                            ),
                            $messages
            );
        
            if ( $validator->fails() ){
                //$messages = $validator->messages();
                return response()->json(['errors'=>$validator->messages()],422);
                
            }

        
            $user               = new User;
            $user->id_pegawai   = Input::get('pegawai_id');
            $user->username     = Input::get('nip');
            $user->password     = Hash::make('bkd12345');

            $user->active       = '1';
            $user->resent       = '1';

            


            if ( $user->save() ){
                return \Response::make('Berhasil', 200);
                
                //return redirect('/admin/pegawai/'.Input::get('pegawai_id'))->with('status', 'Pegawai berhasil didaftarkan');
            }else{
                return \Response::make('Gagal add pegawai', 500);
            }
            
        


        }else{
            
            return redirect('/admin/pegawai/'.Input::get('pegawai_id'))->with('status', 'Pegawai sudaah didaftarkan');
        }



        
        
    }

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
