<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;

use App\Models\Pegawai;
use App\Models\Renja;
use App\Models\SKPTahunan;
use App\Models\CapaianBulanan;
use App\Models\CapaianTriwulan;
use App\Models\CapaianTahunan;
use App\Models\Jabatan;
use App\Models\HistoryJabatan;
use App\Models\TPPReport;
use App\Models\PegawaiPuskesmas;
use App\Models\User;
use App\Models\RoleUser;

use App\Helpers\Pustaka;

use Datatables;
use Validator;
use Gravatar;
use Input;
Use Alert;
Use Hash;

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
               
            }else{
                return \Response::make('Gagal add pegawai', 500);
            }
            
        
 

        }else{

        }



        
        
    }


    public function select_pegawai_list(Request $request)
    {
        $pegawai     = Pegawai::Where('nama','like', '%'.$request->get('nama').'%')
                        ->where('id','!=',$request->get('pegawai_id'))
                        ->where('status','active')
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
                        ->where('status','active')
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

    public function select_ka_skpd_list(Request $request)
    {

        //cari kepals skpd renja
        $renja    = Renja::where('id', $request->get('renja_id'))->first();
        if ( $renja->KepalaSKPD != null ){
            $kepala_skpd_id = $renja->KepalaSKPD->id_pegawai;
        }else{
            $kepala_skpd_id = "0";
        }

        $pegawai     = Pegawai::Where('nama','like', '%'.$request->get('nama').'%')
                        ->where('id','!=',$kepala_skpd_id )
                        ->where('status','active')
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
                        ->where('id','!=',$capaian->PegawaiYangDinilai->id )
                        ->where('id','!=',$atasan_id )
                        ->where('status','active')
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
                        ->where('id','!=',$capaian->PegawaiYangDinilai->id )
                        ->where('id','!=',$atasan_id )
                        ->where('status','active')
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
                        ->where('id','!=',$capaian->PegawaiYangDinilai->id )
                        ->where('id','!=',$atasan_id )
                        ->where('status','active')
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
       
        
        $dt = Pegawai::WHERE('tb_pegawai.status', '=', 'active')
                    ->WHERE('tb_pegawai.nip','!=','admin')
                    ->leftjoin('demo_asn.tb_history_jabatan AS a', function($join){
                                $join   ->on('a.id_pegawai','=','tb_pegawai.id');
                                $join   ->WHERE('a.status','=','active');
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
                    ->SELECT([  'tb_pegawai.nama AS nama',
                                'tb_pegawai.id AS pegawai_id',
                                'tb_pegawai.nip AS nip',
                                'tb_pegawai.gelardpn AS gelardpn',
                                'tb_pegawai.gelarblk AS gelarblk',
                                'jabatan.skpd AS jabatan',
                                'eselon.eselon AS eselon',
                                'golongan.golongan AS golongan',
                                'skpd.skpd AS skpd'
                                    
                            ])
                    
                    ->ORDERBY('golongan.golongan','IS NULL');
                    
                    //->simplePaginate($request->dtpage);
                    
              
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

    
   
    public function SKPDPegawaiList(Request $request)
    {
        $id_skpd = $request->skpd_id ;
        $dt = \DB::table('demo_asn.tb_pegawai AS pegawai')
                ->rightjoin('demo_asn.tb_history_jabatan AS a', function($join) use($id_skpd){
                    $join   ->on('a.id_pegawai','=','pegawai.id');
                    $join   ->where('a.id_skpd','=', $id_skpd);
                    $join   ->where('a.status', '=', 'active');
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
                            $join   ->on('b.id_pegawai','=','pegawai.id');
                            $join   ->WHERE('b.status','=','active');
                })  
                //GOLONGAN
                ->leftjoin('demo_asn.m_golongan AS golongan', function($join){
                            $join   ->on('golongan.id','=','b.id_golongan');
                })  
                
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
                ->where('pegawai.status', '=', 'active')
                //->ORDERBY('golongan.golongan','IS NULL')
                ->ORDERBY('a.id_eselon','ASC');
               
        
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

    public function PuskesmasPegawaiList(Request $request)
    {
        $puskesmas_id = $request->puskesmas_id ;

        
        $dt = \DB::table('demo_asn.tb_pegawai AS pegawai')
                ->rightjoin('demo_asn.tb_history_jabatan AS a', function($join) use($puskesmas_id){
                    $join   ->on('a.id_pegawai','=','pegawai.id')
                    ->where(function ($query) use($puskesmas_id) {
                        $query  ->where('a.id_unit_kerja','=', $puskesmas_id)
                                ->orwhere('a.id_jabatan','=', $puskesmas_id);
                    });
                    $join   ->where('a.status', '=', 'active');
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
                            $join   ->on('b.id_pegawai','=','pegawai.id');
                            $join   ->WHERE('b.status','=','active');
                })  
                //GOLONGAN
                ->leftjoin('demo_asn.m_golongan AS golongan', function($join){
                            $join   ->on('golongan.id','=','b.id_golongan');
                })  
                
                //LEFT JOIN ke user
                ->leftjoin('db_pare_2018.users', 'users.id_pegawai','=','pegawai.id')

                //LEFT JOIN ke roles admin SKPD
                ->leftjoin('db_pare_2018.role_user AS role', function($join){
                            $join   ->on('role.user_id','=','users.id');
                            $join   ->where('role.role_id','=','4');
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
                ->where('pegawai.status', '=', 'active')
                //->ORDERBY('golongan.golongan','IS NULL')
                ->ORDERBY('a.id_eselon','ASC');
               
        
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

    public function PuskesmasPegawaiListError(Request $request)
    {
        $puskesmas_id = $request->puskesmas_id ;
        $month = date('m');

        //pencarian TPP report bulanan Dinkes pada bulan ini, SKPD_ID = 19
        $tpp = TPPReport::
                                    SELECT([
                                        'tpp_report.id'
                                    ])
                                    ->WHERE('tpp_report.skpd_id', 19)
                                    ->WHERE('tpp_report.bulan', $month)
                                    ->first();
        if ( $tpp ){
            $tpp_report_id = $tpp->id;
        }else{
            $tpp_report_id = 0 ;
        }


        
        $dt = PegawaiPuskesmas::
                leftjoin('demo_asn.tb_history_jabatan AS hijab', function($join) use($puskesmas_id){
                    $join   ->on('hijab.nip','=','pegawai_puskesmas.nip');
                    /* ->where(function ($query) use($puskesmas_id) {
                        $query  ->where('a.id_unit_kerja','=', $puskesmas_id)
                                ->orwhere('a.id_jabatan','=', $puskesmas_id);
                    }); */
                    $join   ->where('hijab.status', '=', 'active');
                })
                //jabatan pada Hijab
                ->leftjoin('demo_asn.m_skpd AS jabatan', function($join){
                    $join   ->on('jabatan.id','=','hijab.id_jabatan');
                })  
                //jabatan pada Hijab
                ->leftjoin('db_pare_2018.tpp_report_data AS tpp', function($join) use($tpp_report_id){
                    $join   ->on('tpp.pegawai_id','=','hijab.id_pegawai');
                    $join   ->WHERE('tpp.tpp_report_id','=',$tpp_report_id);
                }) 
                
                
                ->select([  'pegawai_puskesmas.id AS pp_id',
                            'pegawai_puskesmas.nip AS pp_nip',
                            'pegawai_puskesmas.nama AS pp_nama',
                            'pegawai_puskesmas.gol AS pp_gol',
                            'pegawai_puskesmas.jabatan AS pp_jabatan',
                            'pegawai_puskesmas.unit_kerja_id AS pp_unit_kerja_id',
                            'hijab.id_jabatan AS hijab_jabatan_id',
                            'hijab.id_unit_kerja AS hijab_unit_kerja_id',
                            'jabatan.skpd AS hijab_jabatan',
                            'jabatan.id_unit_kerja AS m_skpd_id_uk',
                            'tpp.id AS tpp_id',
                            'tpp.unit_kerja_id AS tpp_unit_kerja_id',
                            'tpp.cap_skp AS tpp_capaian'
                
                        ])

                ->WHERE('pegawai_puskesmas.unit_kerja_id',$puskesmas_id)
                ->get();
               
        
        //unit kerja pegawai yaitu history_jabatan(id_unit_kerja)->m_skpd(parent_id)->m_unit_kerja(unit_kerja)


        $datatables = Datatables::of($dt);
        /* ->addColumn('nama_pegawai', function ($x) {
            return Pustaka::nama_pegawai($x->gelardpn , $x->nama , $x->gelarblk);
        })->addColumn('nama_unit_kerja', function ($x) {
            return Pustaka::capital_string($x->unit_kerja);
        })->addColumn('jabatan', function ($x) {
            return Pustaka::capital_string($x->jabatan);
        }); */

        
        if ($keyword = $request->get('search')['value']) {
            $datatables->filterColumn('rownum', 'whereRaw', '@rownum  + 1 like ?', ["%{$keyword}%"]);
        } 

        return $datatables->make(true);
    } 

}
