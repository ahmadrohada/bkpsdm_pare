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
use App\Models\RoleUSer;

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

    public function administrator_users_list(Request $request)
    {
      
        $dt = \DB::table('db_pare_2018.users AS users')
                    ->leftjoin('demo_asn.tb_pegawai AS pegawai', function($join){
                        $join   ->on('users.id_pegawai','=','pegawai.id');
                        
                    })
                    ->leftjoin('demo_asn.tb_history_jabatan AS a', function($join){
                        $join   ->on('a.id_pegawai','=','pegawai.id');
                        $join   ->where('a.status','=', 'active');
                                        
                    })
                    //eselon
                    ->leftjoin('demo_asn.m_eselon AS eselon', 'a.id_eselon','=','eselon.id')
    
                    //golongan
                    ->leftjoin('demo_asn.m_golongan AS golongan', 'a.id_golongan','=','golongan.id')
                    
                    //jabatan
                    ->leftjoin('demo_asn.m_skpd AS jabatan', 'a.id_jabatan','=','jabatan.id')
                    
                    //skpd
                    ->leftjoin('demo_asn.m_skpd AS skpd', 'a.id_skpd','=','skpd.id')
    
                    //unit_kerja
                    ->leftjoin('demo_asn.m_skpd AS s_skpd', 's_skpd.id','=','a.id_unit_kerja')
                    ->leftjoin('demo_asn.m_unit_kerja AS unit_kerja', 's_skpd.parent_id','=','unit_kerja.id')
                    

                    
                     ->select([ 'users.id AS user_id',
                                'pegawai.nama AS nama',
                                'pegawai.id AS pegawai_id',
                                'pegawai.nip AS nip',
                                'pegawai.gelardpn AS gelardpn',
                                'pegawai.gelarblk AS gelarblk',
                                'eselon.eselon AS eselon',
                                'golongan.golongan AS golongan',
                                'jabatan.skpd AS jabatan',
                                'unit_kerja.unit_kerja',
                                'skpd.skpd AS skpd'
                                    
                            ]) ;
        



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

                $data_user = User::WHERE('id_pegawai', Input::get('pegawai_id') )
                                ->SELECT('users.id AS user_id')
                                ->first();



                $role               = new RoleUSer;
                $role->user_id      = $data_user->user_id;
                $role->role_id      = '1';
                $role->save();


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
