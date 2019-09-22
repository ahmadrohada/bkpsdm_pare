<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Hash;

use App\Models\Pegawai;
use App\Models\SKPTahunan;
use App\Models\CapaianBulanan;
use App\Models\CapaianTriwulan;
use App\Models\CapaianTahunan;
use App\Models\Jabatan;
use App\Models\HistoryJabatan;
use App\Models\User;
use App\Models\RoleUser;

use App\Helpers\Pustaka;

use Datatables;
use Validator;
use Gravatar;
use Input;
Use Alert;

class PegawaiAPIController extends Controller {

    public function add_pegawai(Request $request)
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

                /* $data_user = User::WHERE('id_pegawai', Input::get('pegawai_id') )
                                ->SELECT('users.id AS user_id')
                                ->first(); */

                $role               = new RoleUser;
                $role->user_id      = $user->id;
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


    public function select_pegawai_list(Request $request)
    {
        $pegawai     = Pegawai::Where('nama','like', '%'.$request->get('nama').'%')
                        ->where('id','!=',$request->get('pegawai_id'))
                        ->get();


        $no = 0;
        $pegawai_list = [];
        foreach  ( $pegawai as $x){
            $no++;
            $pegawai_list[] = array(
                            'id'		=> $x->id,
                            'nama'		=> Pustaka::nama_pegawai($x->gelardpn , $x->nama , $x->gelarblk),
                            );
            } 
        
        return $pegawai_list;
        
        
    }

    public function select_pejabat_penilai_list(Request $request)
    {

        //cari pejabat dan penilai SKP
        $skp_tahunan    = SKPTahunan::where('id', $request->get('skp_tahunan_id'))->first();
        if ( $skp_tahunan->jabatan_atasan_id != 0 ){
            $atasan_id = $skp_tahunan->pejabat_penilai->id_pegawai;
        }else{
            $atasan_id = "0";
        }

        $pegawai     = Pegawai::Where('nama','like', '%'.$request->get('nama').'%')
                        ->where('id','!=',$skp_tahunan->pegawai_id )
                        ->where('id','!=',$atasan_id )
                        ->get();


        $no = 0;
        $pegawai_list = [];
        foreach  ( $pegawai as $x){
            $no++;
            $pegawai_list[] = array(
                            'id'		=> $x->id,
                            'nama'		=> Pustaka::nama_pegawai($x->gelardpn , $x->nama , $x->gelarblk),
                            );
            } 
        
        return $pegawai_list;
        
        
    }

    public function selectAtasanCapaianBulanan(Request $request)
    {

        //cari pejabat dan penilai Capaian
        $capaian    = CapaianBulanan::where('id', $request->get('capaian_bulanan_id'))->first();
        if ( $capaian->p_jabatan_id != 0 ){
            $atasan_id = $capaian->PejabatPenilai->id;
        }else{
            $atasan_id = "0";
        }

        $pegawai     = Pegawai::Where('nama','like', '%'.$request->get('nama').'%')
                        ->where('id','!=',$capaian->PejabatYangDinilai->id )
                        ->where('id','!=',$atasan_id )
                        ->get();


        $no = 0;
        $pegawai_list = [];
        foreach  ( $pegawai as $x){
            $no++;
            $pegawai_list[] = array(
                            'id'		=> $x->id,
                            'nama'		=> Pustaka::nama_pegawai($x->gelardpn , $x->nama , $x->gelarblk),
                            );
            } 
        
        return $pegawai_list;
        
        
    }


    public function selectAtasanCapaianTriwulan(Request $request)
    {

        //cari pejabat dan penilai Capaian
        $capaian    = CapaianTriwulan::where('id', $request->get('capaian_triwulan_id'))->first();
        if ( $capaian->p_jabatan_id != 0 ){
            $atasan_id = $capaian->PejabatPenilai->id;
        }else{
            $atasan_id = "0";
        }

        $pegawai     = Pegawai::Where('nama','like', '%'.$request->get('nama').'%')
                        ->where('id','!=',$capaian->PejabatYangDinilai->id )
                        ->where('id','!=',$atasan_id )
                        ->get();


        $no = 0;
        $pegawai_list = [];
        foreach  ( $pegawai as $x){
            $no++;
            $pegawai_list[] = array(
                            'id'		=> $x->id,
                            'nama'		=> Pustaka::nama_pegawai($x->gelardpn , $x->nama , $x->gelarblk),
                            );
            } 
        
        return $pegawai_list;
        
        
    }

    public function selectAtasanCapaianTahunan(Request $request)
    {

        //cari pejabat dan penilai Capaian
        $capaian    = CapaianTahunan::where('id', $request->get('capaian_tahunan_id'))->first();
        if ( $capaian->p_jabatan_id != 0 ){
            $atasan_id = $capaian->PejabatPenilai->id;
        }else{
            $atasan_id = "0";
        }

        $pegawai     = Pegawai::Where('nama','like', '%'.$request->get('nama').'%')
                        ->where('id','!=',$capaian->PejabatYangDinilai->id )
                        ->where('id','!=',$atasan_id )
                        ->get();


        $no = 0;
        $pegawai_list = [];
        foreach  ( $pegawai as $x){
            $no++;
            $pegawai_list[] = array(
                            'id'		=> $x->id,
                            'nama'		=> Pustaka::nama_pegawai($x->gelardpn , $x->nama , $x->gelarblk),
                            );
            } 
        
        return $pegawai_list;
        
        
    }

  
    public function administrator_pegawai_list(Request $request)
    {
       
        
        $dt = \DB::table('demo_asn.tb_pegawai AS pegawai')
                ->rightjoin('demo_asn.tb_history_jabatan AS a', function($join){
                                $join   ->on('a.id_pegawai','=','pegawai.id');
                                    
                            })
                //eselon
                ->leftjoin('demo_asn.m_eselon AS eselon', 'a.id_eselon','=','eselon.id')

                //golongan
                ->leftjoin('demo_asn.m_golongan AS golongan', 'a.id_golongan','=','golongan.id')
                
                //jabatan
                ->leftjoin('demo_asn.m_skpd AS jabatan', 'a.id_jabatan','=','jabatan.id')
                
                //skpd
                ->leftjoin('demo_asn.m_skpd AS skpd', 'a.id_skpd','=','skpd.id')

                
                 ->select([ 'pegawai.nama AS nama',
                            'pegawai.id AS pegawai_id',
                            'pegawai.nip AS nip',
                            'pegawai.gelardpn AS gelardpn',
                            'pegawai.gelarblk AS gelarblk',
                            'eselon.eselon AS eselon',
                            'golongan.golongan AS golongan',
                            'jabatan.skpd AS jabatan',
                            'skpd.skpd AS skpd',
                            'a.unit_kerja AS unit_kerja'
                                
                        ])
                //->where('a.id_skpd','=', $id_skpd)
                ->where('a.status', '=', 'active');
        



        $datatables = Datatables::of($dt)
        ->addColumn('action', function ($x) {

            return User::WHERE('id_pegawai',$x->pegawai_id)->count();

        })->addColumn('nama_pegawai', function ($x) {
            
            return Pustaka::nama_pegawai($x->gelardpn , $x->nama , $x->gelarblk);
        
        })->addColumn('jabatan', function ($x) {
            
            return Pustaka::capital_string($x->jabatan);
        
        })->addColumn('skpd', function ($x) {
            
            return Pustaka::capital_string($x->skpd);
        
        });

        
        if ($keyword = $request->get('search')['value']) {
            $datatables->filterColumn('rownum', 'whereRaw', '@rownum  + 1 like ?', ["%{$keyword}%"]);
        } 

        return $datatables->make(true);
        
    }

    
   
    public function skpd_pegawai_list(Request $request)
    {
        $id_skpd = $request->skpd_id ;

        
        $dt = \DB::table('demo_asn.tb_pegawai AS pegawai')
                ->rightjoin('demo_asn.tb_history_jabatan AS a', function($join){
                    $join   ->on('a.id_pegawai','=','pegawai.id');
                    
                })
                //eselon
                ->leftjoin('demo_asn.m_eselon AS eselon', 'a.id_eselon','=','eselon.id')

                 //golongan
                 ->leftjoin('demo_asn.m_golongan AS golongan', 'a.id_golongan','=','golongan.id')

                //jabatan
                ->leftjoin('demo_asn.m_skpd AS jabatan', 'a.id_jabatan','=','jabatan.id')


                
                //LEFT JOIN ke user
                ->leftjoin('db_pare_2018.users', 'users.id_pegawai','=','pegawai.id')

                //LEFT JOIN ke roles admin SKPD
                ->leftjoin('db_pare_2018.role_user AS role', function($join){
                            $join   ->on('role.user_id','=','users.id');
                            $join   ->where('role.role_id','=','2');
                })
                
                ->select([  'pegawai.nama',
                            'pegawai.id AS pegawai_id',
                            'pegawai.nip',
                            'pegawai.gelardpn',
                            'pegawai.gelarblk',
                            'eselon.eselon AS eselon',
                            'golongan.golongan AS golongan',
                            'jabatan.skpd AS jabatan',
                            'a.unit_kerja AS unit_kerja',
                            'users.id AS user_id',
                            'role.id AS admin_role_user'
                
                        ])
                       
                ->where('a.id_skpd','=', $id_skpd)
                ->where('a.status', '=', 'active');
               
        
        //unit kerja pegawai yaitu history_jabatan(id_unit_kerja)->m_skpd(parent_id)->m_unit_kerja(unit_kerja)


        $datatables = Datatables::of($dt)
        ->addColumn('nama_pegawai', function ($x) {
            
            return Pustaka::nama_pegawai($x->gelardpn , $x->nama , $x->gelarblk);
        
        })->addColumn('nama_unit_kerja', function ($x) {
            
            return Pustaka::capital_string($x->unit_kerja);
        
        })->addColumn('jabatan', function ($x) {
            
            return Pustaka::capital_string($x->jabatan);
        
        })->addColumn('user', function ($x) {

           // $num_rows = User::WHERE('id_pegawai',$x->pegawai_id)->count();
            //return $num_rows;

            if ( $x->user_id != null ){
                return 1 ;
            }else{
                return 0 ;
            }
        })->addColumn('role_admin', function ($x) {
            if ( $x->admin_role_user != null ){
                return 1 ;
            }else{
                return 0 ;
            }
           
        });

        
        if ($keyword = $request->get('search')['value']) {
            $datatables->filterColumn('rownum', 'whereRaw', '@rownum  + 1 like ?', ["%{$keyword}%"]);
        } 

        return $datatables->make(true);
    } 

}
