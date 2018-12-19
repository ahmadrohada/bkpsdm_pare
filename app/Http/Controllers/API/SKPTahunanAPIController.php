<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Periode;
use App\Models\PerjanjianKinerja;
use App\Models\SKPTahunan;
use App\Models\Pegawai;
use App\Models\HistoryJabatan;
use App\Models\Golongan;
use App\Models\Eselon;


use App\Helpers\Pustaka;

use Datatables;
use Validator;
use Gravatar;
use Input;
Use Alert;

class SKPTahunanAPIController extends Controller {


   

    public function SKPDSKPTahunan_list(Request $request)
    {
            
        $dt = \DB::table('db_pare_2018.renja AS renja')
                   
                    ->join('db_pare_2018.perjanjian_kinerja AS pk', function($join){
                        $join   ->on('pk.renja_id','=','renja.id');
                    })
                    ->rightjoin('db_pare_2018.skp_tahunan AS skp_tahunan', function($join){
                        $join   ->on('pk.id','=','skp_tahunan.perjanjian_kinerja_id');
                    }) 
                    //PERIODE
                    ->leftjoin('db_pare_2018.periode AS periode', function($join){
                        $join   ->on('renja.periode_id','=','periode.id');
                    }) 

                    //PEJABAT YANG DINILAI
                    ->leftjoin('demo_asn.tb_history_jabatan AS pejabat', function($join){
                        $join   ->on('skp_tahunan.u_jabatan_id','=','pejabat.id');
                    }) 

                    //ESELON PEJABAT YANG DINILAI
                     ->leftjoin('demo_asn.m_eselon AS eselon', function($join){
                        $join   ->on('eselon.id','=','pejabat.id_eselon');
                    }) 

                    
                    //jabatan
                    ->leftjoin('demo_asn.m_skpd AS jabatan', 'pejabat.id_jabatan','=','jabatan.id')


                    ->select([  'skp_tahunan.id AS skp_tahunan_id',
                                'periode.label AS periode',
                                'skp_tahunan.pegawai_id AS pegawai_id',
                                'skp_tahunan.u_nama',
                                'skp_tahunan.u_jabatan_id',
                                'skp_tahunan.p_nama',
                                'skp_tahunan.p_jabatan_id',
                                'skp_tahunan.status',
                                'pejabat.nip AS u_nip',
                                'eselon.eselon AS eselon',
                                'jabatan.skpd AS jabatan'

                        ])
                    ->where('renja.skpd_id','=', $request->skpd_id);

       
                    $datatables = Datatables::of($dt)
                    ->addColumn('status', function ($x) {
            
                        return $x->status;
            
                    })->addColumn('periode', function ($x) {
                        
                        return $x->periode;
                    
                    })->addColumn('nip_pegawai', function ($x) {
                        
                        return $x->u_nip;
                    
                    })->addColumn('nama_pegawai', function ($x) {
                        
                        return $x->u_nama;
                    
                    })
                    ->addColumn('eselon', function ($x) {
                        
                        
                        return  $x->eselon;
                        
                    })->addColumn('jabatan', function ($x) {
                        
                        return Pustaka::capital_string($x->jabatan);
                    
                    })
                    ->addColumn('nama_atasan', function ($x) {
                        
                        return $x->p_nama;
                    
                    });
            
                    
                    if ($keyword = $request->get('search')['value']) {
                        $datatables->filterColumn('rownum', 'whereRaw', '@rownum  + 1 like ?', ["%{$keyword}%"]);
                    } 
            
                    return $datatables->make(true);
        
    }






    public function Personal_SKP_tahunan_list(Request $request)
    {
            
        \DB::statement(\DB::raw('set @rownum='.$request->get('start')));
       
       
        $dt = SKPTahunan::
                        select([   
                                    
                        \DB::raw('@rownum  := @rownum  + 1 AS rownum'), 
                        'id AS skp_tahunan_id',
                        'perjanjian_kinerja_id',
                        'jabatan_id',
                        'jabatan_atasan_id',
                        'u_nama',
                        'p_nama',
                        'tgl_mulai',
                        'tgl_selesai',
                        'status'
            
            ])
            ->get();

       
            $datatables = Datatables::of($dt)
           ->addColumn('periode', function ($x) {
                //return $x->renja->periode->label;
            }) 
            ->addColumn('masa_penilaian', function ($x) {
                $masa_penilaian = Pustaka::balik($x->tgl_mulai). ' s.d ' . Pustaka::balik($x->tgl_selesai);
                return   $masa_penilaian;
            }) 
            ->addColumn('pejabat_penilai', function ($x) {
            
                if ( !empty($x->p_nama)){
                    return $x->p_nama;
                }else{
                    return "<font style='color:red'>Belum Ada</font>";
                }
                
            }) 
            ->addColumn('status', function ($x) {
                
                return   $x->status;
            })
            ->addColumn('status_btn_edit', function ($x) {
                
                if ( $x->status == 1 ){
                    $btn_status = 'btn-default disabled';
                }else{
                    $btn_status = 'btn-info';
                }
                    return   $btn_status;
            })
            ->addColumn('status_btn_lihat', function ($x) {
                
                if ( $x->status == 0 ){
                    $btn_status = 'btn-default disabled';
                }else{
                    $btn_status = 'btn-success';
                }
                    return   $btn_status;
            })
            ->addColumn('status_btn_hapus', function ($x) {
                
                if ( $x->status == 1 ){
                    $btn_status = 'btn-default disabled';
                }else{
                    $btn_status = 'btn-danger';
                }
                    return   $btn_status;
            })
            ->addColumn('step', function($x){


               /*  if ( ($dt["type_id"] == null) && ($dt['status'] == 1 ) ){
                    $step = '1';   //terkirim tapi belum disetujui
                }else if( ($dt["type_id"] != null) && ($dt['pj'] == 1 ) && ($dt['status'] == 1 ) ) {
                    $step = '2';   //terkirim dan disetujui
                }else if( ($dt["type_id"] != null) && ($dt['pj'] == 0 ) ) {
                    $step = '3'; //terkirim dan ditolak
                }else if( ($dt["type_id"] != null) && ($dt['pj'] == 1 ) && ($dt['status'] == 2) ) {
                    $step = '4'; //sedang proses pengajuan update
                }else{
                    $step = '5'; //default
                } */

                $step = '5';

                return $step;

            })
            ->addColumn('ralat', function($x){
                //boleh ralat jika jika capaian_id == null dan status_periode = 1
                            
                /* if ( ($dt["capaian_id"] == null ) && ($dt["status_periode"] == 1 ) && ( ( $state == 2) | ( $state == 4) ) ){
                    $ralat = '1' ;
                }else{
                    $ralat = '0' ;
                } */
                    $ralat = '0';


                    return $ralat;

             });
    
            if ($keyword = $request->get('search')['value']) {
                $datatables->filterColumn('rownum', 'whereRawx', '@rownum  + 1 like ?', ["%{$keyword}%"]);
            } 
            
    
        return $datatables->make(true);
        
    }


    public function create_skp_tahunan_confirm(Request $request)
	{

        $pegawai                    = Pegawai::where('id',$request->get('pegawai_id'))->first();
        $jabatan                    = $pegawai->history_jabatan->where('status','active')->first();

        // cek apakah user sudah memiliki SKP tahunan atau belum
        $periode_aktif              = PeriodeTahunan::where('status','1')->first();
        $perjanjian_kinerja_publish = $periode_aktif->perjanjian_kinerja
                                            ->where('active','1')
                                            ->where('publish','1')
                                            ->where('skpd_id', $pegawai->history_jabatan->where('status','active')->first()->id_skpd )
                                            ->first();

        $jm_perjanjian_kinerja      = PerjanjianKinerja::where('periode_tahunan_id',$periode_aktif->id)->get();

        //======= tidak boleh ada yang membuat SKP tahunan dengan 
        //======== PERSONAL JABATAN ID dan PERJANJIAN KINERTJA ID 
        // ======= yang sama untuk satu pegawai id
        $cek_data = SKPTahunan::where('pegawai_id',$pegawai->id)
                                ->where('perjanjian_kinerja_id',$perjanjian_kinerja_publish->id)
                                ->where('jabatan_id',$jabatan->id)
                                ->count();


        $response = array();

        //== jika bukan eselon 1,2,3 atau 4 , maka tunggu atasasn nya bikin SKP =================//
        if ( $jabatan->id_eselon == 9 ){
            $h['jabatan']			= 'Harus Atasan nya terlebih dahulu';
						
			array_push($response, $h);
        }

        

        if ( $response == null ){
            if (  $cek_data  == 0 ){
                //Kirim parameter yang dibutuhkan untuk membuat SKP baru
                return ([
                            'status'                => 'ok',
                            'periode_tahunan_id'    => $periode_aktif->id,
                            'periode_tahunan'       => $periode_aktif->label,
                            'tgl_mulai'             => Pustaka::tgl_form($periode_aktif->awal),
                            'tgl_selesai'           => Pustaka::tgl_form($periode_aktif->akhir),
    
    
                            'perjanjian_kinerja_id' => $perjanjian_kinerja_publish->id,
                            'pegawai_id'            => $pegawai->id,
                            'jabatan_id'            => $jabatan->id,
    
                            //DETAIL PEGAWAI
                            'u_nama'                => Pustaka::nama_pegawai($pegawai->gelardpn , $pegawai->nama , $pegawai->gelarblk),
                            'u_nip'                 => $pegawai->nip,
                            'u_pangkat'             => $jabatan->golongan->pangkat,
                            'u_golongan'            => $jabatan->golongan->golongan,
                            'u_jabatan'             => $jabatan->jabatan,
                            'u_unit_kerja'          => Pustaka::capital_string($jabatan->UnitKerja->unit_kerja),
                            'u_skpd'                => Pustaka::capital_string($jabatan->skpd->unit_kerja),
    
                            'msg'                   => $response
    
                          /*   //DETAIL ATASAN
                            'p_nama'                => Pustaka::nama_pegawai($pegawai->gelardpn , $pegawai->nama , $pegawai->gelarblk),
                            'p_nip'                 => $pegawai->nip,
                            //'jabatn'              => $jabatan,
                            'p_jabatan'             => $jabatan->jabatan,
                            'p_eselon'              => $jabatan->eselon->eselon,
                            'p_jenis_jabatan'       => $jabatan->eselon->jenis_jabatan->jenis_jabatan,
                            'p_unit_kerja'          => Pustaka::capital_string($jabatan->UnitKerja->unit_kerja),
                            'p_skpd'                => Pustaka::capital_string($jabatan->skpd->unit_kerja), */
                            
    
    
                        ]);
    
    
    
    
            }else{
                return \Response::make('SKP Tahunan Sudah Dibuat', 400);
            }
        }else{
            return \Response::make('JFU dan JFT nanti saja bikin SKP nya', 400);
        }
        

       
       
         
    }



    public function set_pejabat_penilai_skp_tahunan(Request $request)
	{
        $messages = [
            'pegawai_id.required'                   => 'Harus set Pegawai ID',
            'skp_tahunan_id.required'               => 'Harus diisi',

        ];

        $validator = Validator::make(
            Input::all(),
            array(
                'pegawai_id'            => 'required',
                'skp_tahunan_id'        => 'required',
            ),
            $messages
        );

        if ( $validator->fails() ){
                return response()->json(['errors'=>$validator->messages()],422);
        }


        //Cari nama dan id pejabatan penilai
        $pegawai     = Pegawai::where('id',$request->get('pegawai_id'))->first();
        $jabatan     = $pegawai->history_jabatan->where('status','active')->first();

        if ( $jabatan ){
            $jabatan_atasan_id = $jabatan->id;
        }else{
            return \Response::make('error', 500);
        }


        
        $data       = [
                'jabatan_atasan_id' => $jabatan->id,
                'p_nama'            => Pustaka::nama_pegawai($pegawai->gelardpn , $pegawai->nama , $pegawai->gelarblk),
        ];

        $skp_tahunan     = SKPTahunan::where('id', $request->get('skp_tahunan_id') );


        
        $item = array(
           
            "p_nip"			=> $pegawai->nip,
            "p_nama"		=> Pustaka::nama_pegawai($pegawai->gelardpn , $pegawai->nama , $pegawai->gelarblk),
            "p_golongan"	=> $jabatan->golongan->pangkat. '/' . $jabatan->golongan->golongan,
            "p_jabatan"		=> $jabatan->jabatan,
            "p_eselon"		=> $jabatan->jabatan,
            "p_unit_kerja"	=> Pustaka::capital_string($jabatan->UnitKerja->unit_kerja),
            );


        
        if (  $skp_tahunan->update($data) ){
            return \Response::make(  $item , 200);


        }else{
            return \Response::make('error', 500);
        } 

    }

    public function Store(Request $request)
	{
        $messages = [
                'pegawai_id.required'                   => 'Harus diisi',
                'perjanjian_kinerja_id.required'        => 'Harus diisi',
                'jabatan_id.required'                   => 'Harus diisi',
                'tgl_mulai.required'                    => 'Harus diisi',
                'tgl_selesai.required'                  => 'Harus diisi',
                'u_nama.required'                       => 'Harus diisi',

        ];

        $validator = Validator::make(
                        Input::all(),
                        array(
                            'pegawai_id'            => 'required',
                            'perjanjian_kinerja_id' => 'required',
                            'jabatan_id'            => 'required',
                            'tgl_mulai'             => 'required',
                            'tgl_selesai'           => 'required',
                            'u_nama'                => 'required',
                        ),
                        $messages
        );
    
        if ( $validator->fails() ){
            //$messages = $validator->messages();
                    return response()->json(['errors'=>$validator->messages()],422);
            
        }


        $skp_tahunan    = new SKPTahunan;
        $skp_tahunan->pegawai_id                  = Input::get('pegawai_id');
        $skp_tahunan->perjanjian_kinerja_id       = Input::get('perjanjian_kinerja_id');
        $skp_tahunan->jabatan_id                  = Input::get('jabatan_id');
        $skp_tahunan->tgl_mulai                   = Pustaka::tgl_sql(Input::get('tgl_mulai'));
        $skp_tahunan->tgl_selesai                 = Pustaka::tgl_sql(Input::get('tgl_selesai'));
        $skp_tahunan->u_nama                      = Input::get('u_nama');

        if ( $skp_tahunan->save()){
            return \Response::make('sukses', 200);
        }else{
            return \Response::make('error', 500);
        } 
            
            
        }   

}
