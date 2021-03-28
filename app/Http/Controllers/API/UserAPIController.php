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
use App\Models\RoleUser;

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



    public function ubah_username(Request $request)
    {
        
        $messages = [
            'new_username.required'         => 'Username harus diisi',
        ];

        $validator = Validator::make(
                        Input::all(),
                        array(
                            'new_username'    => 'required|min:3|max:18|regex:/^[A-Za-z0-9]*$/',
                        ),
                        $messages
        );
    
        if ( $validator->fails() ){
            return response()->json(['errors'=>$validator->messages()],422);
        }

        $cek_user = User::WHERE('username', Input::get('new_username'))->WHERE('id','!=',Input::get('user_id'))->count();

        if ( $cek_user === 1  ){
            return response()->json(['errors'=>array(
                                        'new_username'    => 'Username sudah digunakan',
                                    )],422);
        }

        $profile = User::findOrFail(Input::get('user_id'));
        $profile->username = Input::get('new_username');
       
        
        if ( $profile->save()){
            return \Response::make('sukses', 200);
        }else{
            return \Response::make('error', 500);
        } 
        
    }


    public function administrator_users_list(Request $request)
    {
      
        $dt = User::
                    leftjoin('demo_asn.tb_pegawai AS tb_pegawai', function($join){
                        $join   ->on('users.id_pegawai','=','tb_pegawai.id');
                        
                    })
                    ->leftjoin('demo_asn.tb_history_jabatan AS a', function($join){
                        $join   ->on('a.id_pegawai','=','tb_pegawai.id');
                        $join   ->where('a.status','=', 'active');
                                        
                    })
                    //SKPD
                    ->leftjoin('demo_asn.m_skpd AS skpd', function($join){
                        $join   ->on('skpd.id','=','a.id_skpd');
                    })  
                    //jabatan
                    ->leftjoin('demo_asn.m_skpd AS jabatan', function($join){
                                $join   ->on('jabatan.id','=','a.id_jabatan');
                    })  
                    //eselon
                    ->leftjoin('demo_asn.m_eselon AS eselon', function($join){
                                $join   ->on('eselon.id','=','jabatan.id_eselon');
                    })  
                    //GOL
                    ->leftjoin('demo_asn.tb_history_golongan AS b', function($join){
                                $join   ->on('b.id_pegawai','=','tb_pegawai.id');
                                $join   ->WHERE('b.status','=','active');
                    })  
                    //GOLONGAN
                    ->leftjoin('demo_asn.m_golongan AS golongan', function($join){
                                $join   ->on('golongan.id','=','b.id_golongan');
                    })  
                    ->SELECT([  'users.id AS user_id',
                                'tb_pegawai.nama AS nama',
                                'tb_pegawai.id AS pegawai_id',
                                'tb_pegawai.nip AS nip',
                                'tb_pegawai.gelardpn AS gelardpn',
                                'tb_pegawai.gelarblk AS gelarblk',
                                'jabatan.skpd AS jabatan',
                                'eselon.eselon AS eselon',
                                'golongan.golongan AS golongan',
                                'skpd.skpd AS skpd'
                                    
                            ])
                    ->WHERE('tb_pegawai.status','active')
                    ->ORDERBY('golongan.golongan','IS NULL');
        



        $datatables = Datatables::of($dt)
        ->addColumn('action', function ($x) {
            return User::WHERE('id_pegawai',$x->pegawai_id)->count();
        })->addColumn('nama_pegawai', function ($x) {
            return Pustaka::nama_pegawai($x->gelardpn , $x->nama , $x->gelarblk);
        })->addColumn('jabatan', function ($x) {
            return Pustaka::capital_string($x->jabatan);
        })->addColumn('unit_kerja', function ($x) {
            return Pustaka::capital_string($x->unit_kerja);
        });
            
                    
        if ($keyword = $request->get('search')['value']) {
            $datatables->filterColumn('rownum', 'whereRaw', '@rownum  + 1 like ?', ["%{$keyword}%"]);
        } 
            
        return $datatables->make(true);
                    
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



    public function update_password(Request $request)
    {
        $messages = [
            'username.required'            => 'Harus diisi',
            'old_password.required'        => 'Harus diisi',
            'new_password.required'        => 'Harus diisi',
            'confirm_password.required'    => 'Harus diisi',

        ];

        $validator = Validator::make(
                        Input::all(),
                        array(
                            'username'            => 'required',
                            'old_password'        => 'required|min:6|max:15',
                            'new_password'        => 'required|min:6|max:15',
                            'confirm_password'    => 'required',
                        ),
                        $messages
        );

        if ( $validator->fails() ){
            return response()->json(['errors'=>$validator->messages()],422);
        }
        if ( Input::get('new_password') != Input::get('confirm_password') ){
            $pesan =  ['confirm_password'  => 'Error'] ;
            return response()->json(['errors'=> $pesan ],422);
            
        }

        $dt = \Auth::user();
        $user = User::find($dt->id);

        $has_old = Hash::make(Input::get('old_password'));
     
        if (Hash::check( Input::get('old_password') , $user->password) ) {
            $user->password = Hash::make(Input::get('new_password'));
            $user->save();
        }else{
            $pesan =  ['old_password'  => 'Error'] ;
            return response()->json(['errors'=> $pesan ],422);
        }
 
       
        
        
        
    }

    

   

}
