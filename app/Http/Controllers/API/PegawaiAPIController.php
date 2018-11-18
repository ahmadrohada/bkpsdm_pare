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

class PegawaiAPIController extends Controller {


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

                //unit_kerja
                ->leftjoin('demo_asn.m_skpd AS s_skpd', 's_skpd.id','=','a.id_unit_kerja')
                ->leftjoin('demo_asn.m_unit_kerja AS unit_kerja', 's_skpd.parent_id','=','unit_kerja.id')
                
                 ->select([ 'pegawai.nama AS nama',
                            'pegawai.id AS pegawai_id',
                            'pegawai.nip AS nip',
                            'pegawai.gelardpn AS gelardpn',
                            'pegawai.gelarblk AS gelarblk',
                            'eselon.eselon AS eselon',
                            'golongan.golongan AS golongan',
                            'jabatan.skpd AS jabatan',
                            'unit_kerja.unit_kerja',
                            'skpd.skpd AS skpd'
                                
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
        $id_skpd_admin      = \Auth::user()->pegawai->history_jabatan->where('status','active')->first()->id_skpd;

        \DB::statement(\DB::raw('set @rownum='.$request->get('start')));
        // \DB::statement(\DB::raw('set @rownum=0'));
      
        $dt = \DB::table('db_pare_2018.users AS user')
        ->join('demo_asn.tb_pegawai AS pegawai', 'user.id_pegawai', '=', 'pegawai.id')
        ->join('demo_asn.tb_history_jabatan AS a', 'a.id_pegawai','=','pegawai.id')
        ->where('a.status', '=', 'active')
        ->join('demo_asn.m_skpd AS jabatan', 'jabatan.id','=','a.id_skpd')
        ->join('demo_asn.m_skpd AS unit_kerja', 'a.id_jabatan','=','unit_kerja.id')
        ->join('demo_asn.m_unit_kerja AS skpd', 'unit_kerja.id_skpd','=','skpd.id')
        ->select([   'pegawai.nama',
                    'user.username AS username',
                    'user.id AS user_id',
                    'pegawai.nip',
                    'pegawai.gelardpn',
                    'pegawai.gelarblk',
                    'a.jabatan',
                    'a.id_jabatan',
                    'unit_kerja.id AS unit_kerja_id',
                    'unit_kerja.skpd AS unit_kerja',
                    'skpd.unit_kerja AS skpd',
                    \DB::raw('@rownum  := @rownum  + 1 AS rownum')
                ]);
        



        $datatables = Datatables::of($dt)
        ->addColumn('action', function ($x) {
            return '<a href="user/'.$x->user_id.'/edit" class="btn btn-xs btn-primary" style="margin-top:2px; width:70px;"><i class="fa fa-edit"></i> Edit</a>'
					.' <a href="user/'.$x->user_id.'" class="btn btn-xs btn-primary" style="margin-top:2px; width:70px;"><i class="fa  fa-eye"></i> Lihat</a>';
        })->addColumn('nama_pegawai', function ($x) {
            
            return Pustaka::nama_pegawai($x->gelardpn , $x->nama , $x->gelarblk);
        
        })->addColumn('nama_unit_kerja', function ($x) {
            
            return Pustaka::capital_string($x->unit_kerja);
        
        });

        
        if ($keyword = $request->get('search')['value']) {
            $datatables->filterColumn('rownum', 'whereRaw', '@rownum  + 1 like ?', ["%{$keyword}%"]);
        } 

        return $datatables->make(true);
        
    }

}
