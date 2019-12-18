<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use App\Models\Kegiatan;
use App\Models\Tujuan;
use App\Models\Sasaran;
use App\Helpers\Pustaka;

use Datatables;
use Validator;
use Gravatar;
use Input;
Use Alert;

class PerjanjianKinerjaAPIController extends Controller {






    public function SasaranStrategisSKPD(Request $request)
    {
            
        $dt = Tujuan::
                    rightjoin('db_pare_2018.renja_sasaran AS sasaran', function ($join) {
                        $join->on('sasaran.tujuan_id', '=', 'renja_tujuan.id');
                    })
                    ->leftjoin('db_pare_2018.renja_indikator_sasaran AS ind_sasaran', function ($join) {
                        $join->on('ind_sasaran.sasaran_id', '=', 'sasaran.id');
                    })
                    ->where('renja_tujuan.renja_id', '=' ,$request->get('renja_id'))
                    ->select([   
                                'sasaran.id AS sasaran_id',
                                'sasaran.label AS sasaran_label',
                                'sasaran.pk_status AS pk_status',
                                'ind_sasaran.label AS ind_sasaran_label',
                                'ind_sasaran.target AS target',
                                'ind_sasaran.satuan AS satuan'
                            ])

                    ->ORDERBY('renja_tujuan.id','DESC')
                    ->ORDERBY('sasaran.id','DESC')
                    ->get();

        $datatables = Datatables::of($dt)
                    ->addColumn('id', function ($x) {
                        return $x->sasaran_id;
                    })
                    ->addColumn('sasaran', function ($x) {
                        return Pustaka::capital_string($x->sasaran_label);
                    })
                    ->addColumn('indikator', function ($x) {
                        return Pustaka::capital_string($x->ind_sasaran_label);
                    })
                    ->addColumn('target', function ($x) {
                        return $x->target." ".$x->satuan;
                    })
                    ->addColumn('pk_status', function ($x) {
                        return $x->pk_status;
                    });

                    if ($keyword = $request->get('search')['value']) {
                        $datatables->filterColumn('rownum', 'whereRawx', '@rownum  + 1 like ?', ["%{$keyword}%"]);
                    } 
        return $datatables->make(true);
    }


    public function ProgramSKPD(Request $request)
    {
            
        $dt = Tujuan::
                    rightjoin('db_pare_2018.renja_sasaran AS sasaran', function ($join) {
                        $join->on('sasaran.tujuan_id', '=', 'renja_tujuan.id');
                        $join->WHERE('sasaran.pk_status', '=', '1');
                    })
                    ->rightjoin('db_pare_2018.renja_program AS program', function ($join) {
                        $join->on('program.sasaran_id', '=', 'sasaran.id');
                    })
                    ->where('renja_tujuan.renja_id', '=' ,$request->get('renja_id'))
                    ->select([   
                                'program.id AS program_id',
                                'program.label AS program_label'
                            ])

                    ->get();

        $datatables = Datatables::of($dt)
                    ->addColumn('id', function ($x) {
                        return $x->program_id;
                    })
                    ->addColumn('program', function ($x) {
                        return $x->program_label;
                    })
                    ->addColumn('anggaran', function ($x) {

                        $dt = Kegiatan::WHERE('program_id',$x->program_id)->select( \DB::raw('SUM(cost) as anggaran'))->get();
                        //return $dt[0]['anggaran'];
                        return "Rp.   " . number_format( $dt[0]['anggaran'], '0', ',', '.');
                    })
                    ->addColumn('keterangan', function ($x) {
                        return "";
                    });

                    if ($keyword = $request->get('search')['value']) {
                        $datatables->filterColumn('rownum', 'whereRawx', '@rownum  + 1 like ?', ["%{$keyword}%"]);
                    } 
        return $datatables->make(true);
    }




    
    
    public function AddSasaranToPK(Request $request)
    {

            $messages = [
                'sasaran_id.required'=> 'Harus diisi'
            ];

        $validator = Validator::make(
                        Input::all(),
                        array(
                            'sasaran_id' => 'required|numeric|min:1',
                        ),
                        $messages
        );

        if ( $validator->fails() ){
            return response()->json(['errors'=>$validator->messages()],422);
            
        }


        $st_update  = Sasaran::find(Input::get('sasaran_id'));

        $st_update->pk_status         = '1';
    
        if ( $st_update->save()){
            return \Response::make('sukses', 200);
        }else{
            return \Response::make('error', 500);
        } 
    } 


    public function RemoveSasaranFromPK(Request $request)
    {

            $messages = [
                'sasaran_id.required'=> 'Harus diisi'
            ];

        $validator = Validator::make(
                        Input::all(),
                        array(
                            'sasaran_id' => 'required|numeric|min:1',
                        ),
                        $messages
        );

        if ( $validator->fails() ){
            return response()->json(['errors'=>$validator->messages()],422);
            
        }


        $st_update  = Sasaran::find(Input::get('sasaran_id'));

        $st_update->pk_status         = '0';
    
        if ( $st_update->save()){
            return \Response::make('sukses', 200);
        }else{
            return \Response::make('error', 500);
        } 
    } 

    
    public function TotalAnggaranSKPD(Request $request)
    {
        $dt = Tujuan::
                    rightjoin('db_pare_2018.renja_sasaran AS sasaran', function ($join) {
                        $join->on('sasaran.tujuan_id', '=', 'renja_tujuan.id');
                        $join->WHERE('sasaran.pk_status', '=', '1');
                    })
                    ->rightjoin('db_pare_2018.renja_program AS program', function ($join) {
                        $join->on('program.sasaran_id', '=', 'sasaran.id');
                    })
                    ->where('renja_tujuan.renja_id', '=' ,$request->get('renja_id'))
                    ->select([   
                                'program.id AS program_id',
                                'program.label AS program_label'
                            ])

                    ->get();

        $total_anggaran = 0 ;
        foreach ($dt as $x) {
            $dt = Kegiatan::WHERE('program_id',$x->program_id)->select( \DB::raw('SUM(cost) as anggaran'))->get();
            $total_anggaran = $total_anggaran+$dt[0]['anggaran'];
            //return "Rp.   " . number_format( $dt[0]['anggaran'], '0', ',', '.');

        }

		
		//return  $kegiatan_tahunan;
        $ta = array(
            'total_anggaran'    => "Rp.   " . number_format( $total_anggaran, '0', ',', '.'),

        );
        return $ta;
    }

    /* public function PerjanjianKinerjaTimelineStatus( Request $request )
    {
        $response = array();
        $body = array();
        $body_2 = array();


        $renja = PerjanjianKinerja::where('id','=', $request->perjanjian_kinerja_id )
                                ->select('*')
                                ->firstOrFail();

        
        //CREATED AT - Dibuat
        $x['tag']	    = 'p';
        $x['content']	= 'Dibuat';
        array_push($body, $x);
        $x['tag']	    = 'p';
        $x['content']	= $renja->nama_admin_skpd;
        array_push($body, $x);

        //CREATED AT - Dibuat
        $x['tag']	    = 'p';
        $x['content']	= 'Kepala SKPD';
        array_push($body, $x);
        $x['tag']	    = 'p';
        $x['content']	= $renja->nama_kepala_skpd;
        array_push($body, $x);

        $h['time']	    = $renja->created_at->format('Y-m-d H:i:s');
        $h['body']	    = $body;
        array_push($response, $h);
        //=====================================================================//

        //UPDATED AT - Dikirim
        $y['tag']	    = 'p';
        $y['content']	= 'Dikirim';
        array_push($body_2, $y);
        $y['tag']	    = 'p';
        $y['content']	= $renja->nama_admin_skpd;
        array_push($body_2, $y);

        $i['time']	    = $renja->updated_at->format('Y-m-d H:i:s');
        $i['body']	    = $body_2;

        if ( $renja->updated_at->format('Y') > 1 )
        {
            array_push($response, $i);
        }
        


        return $response;


    }

    public function SKPDPerjanjianKinerja_list(Request $request)
    {
            
        $dt = \DB::table('db_pare_2018.renja AS renja')
                   
                    ->rightjoin('db_pare_2018.perjanjian_kinerja AS pk', function($join){
                        $join   ->on('pk.renja_id','=','renja.id');
                    }) //ID KEPALA SKPD
                    ->leftjoin('demo_asn.tb_history_jabatan AS id_ka_skpd', function($join){
                        $join   ->on('id_ka_skpd.id','=','renja.kepala_skpd_id');
                    })
                    //NAMA KEPALA SKPD
                    ->leftjoin('demo_asn.tb_pegawai AS kepala_skpd', function($join){
                        $join   ->on('kepala_skpd.id','=','id_ka_skpd.id_pegawai');
                    })//PERIODE
                    ->join('db_pare_2018.periode AS periode', function($join){
                        $join   ->on('periode.id','=','renja.periode_id');
                        
                    })

                    ->select([  'pk.id AS pk_id',
                                'periode.label AS periode',
                                'kepala_skpd.nama',
                                'kepala_skpd.gelardpn',
                                'kepala_skpd.gelarblk',
                                'renja.status'
                                
                        ])
                    ->where('renja.skpd_id','=', $request->skpd_id);

       
                    $datatables = Datatables::of($dt)
                    ->addColumn('status', function ($x) {
            
                        return $x->status;
            
                    })->addColumn('periode', function ($x) {
                        
                        return $x->periode;
                    
                    })->addColumn('kepala_skpd', function ($x) {
                        
                        return Pustaka::nama_pegawai($x->gelardpn , $x->nama , $x->gelarblk);
                    
                    })->addColumn('skpd', function ($x) {
                        
                        //return Pustaka::capital_string($x->skpd);
                    
                    });
            
                    
                    if ($keyword = $request->get('search')['value']) {
                        $datatables->filterColumn('rownum', 'whereRaw', '@rownum  + 1 like ?', ["%{$keyword}%"]);
                    } 
            
                    return $datatables->make(true);
        
    }


    public function SKPDPerjanjianKinerjaBreadcrumb(Request $request)
    {
        
        $perjanjian_kinerja	= PerjanjianKinerja::where('id', '=', Request('perjanjian_kinerja_id') )->firstOrFail();

        $data            = SasaranPerjanjianKinerja::where('perjanjian_kinerja_id',$perjanjian_kinerja->id);
        $sasaran         = $data->count();


        
        $jm_indikator_sasaran   = 0;
        $jm_program             = 0 ;
        $jm_indikator_program   = 0 ;
        $jm_kegiatan            = 0 ;
        $jm_indikator_kegiatan  = 0 ;
        $publish_status         = 1 ;

        if ( $sasaran == 0){
            $publish_status =  $publish_status * 0;
        }

        //JUMLAH INDIKATOR SASARAN
        foreach ( $data->get() as $dt) {
            $ind_sasaran = IndikatorSasaran::where('sasaran_perjanjian_kinerja_id',$dt->id);

            //JUMLAH PROGRAM
            foreach( $ind_sasaran->get() as  $x ) {
                $program = Program::where('indikator_sasaran_id',$x->id);

                //JUMLAH INDIKATOR PROGRAM
                foreach( $program->get() as  $y ) {
                    $indikator_program = IndikatorProgram::where('program_id',$y->id);

                    //JUMLAH KEGIATAN
                    foreach( $indikator_program->get() as  $z ) {
                        $kegiatan = Kegiatan::where('indikator_program_id',$z->id);

                        //JUMLAH INDIKATOR KEGIATAN
                        foreach( $kegiatan->get() as  $a ) {
                            $indikator_kegiatan = IndikatorKegiatan::where('kegiatan_id',$a->id);
                            $jm_indikator_kegiatan = $jm_indikator_kegiatan+$indikator_kegiatan->count();
                            if ( $indikator_kegiatan->count() == 0 ){
                                $publish_status =  $publish_status * 0;
                            }
                        }  
                        $jm_kegiatan = $jm_kegiatan+$kegiatan->count();
                        if ( $kegiatan->count() == 0 ){
                            $publish_status =  $publish_status * 0;
                        }
                    }  
                    $jm_indikator_program = $jm_indikator_program+$indikator_program->count();
                    if ( $indikator_program->count() == 0 ){
                        $publish_status =  $publish_status * 0;
                    }
                }  
                $jm_program = $jm_program+$program->count();
                if ( $program->count() == 0 ){
                    $publish_status =  $publish_status * 0;
                }
            } 

            $jm_indikator_sasaran = $jm_indikator_sasaran+$ind_sasaran->count();
            if ( $ind_sasaran->count() == 0 ){
                $publish_status =  $publish_status * 0;
            }
            
        }

        

        return ( [
            //'perjanjian_kinerja_id'=> $perjanjian_kinerja,
            'data'                 => $data->select('id')->get(),
            'sasaran'              => $sasaran,
            'indikator_sasaran'    => $jm_indikator_sasaran,
            'program'              => $jm_program,
            'indikator_program'    => $jm_indikator_program,
            'kegiatan'             => $jm_kegiatan,
            'indikator_kegiatan'   => $jm_indikator_kegiatan,
            'publish_status'       => $publish_status,
            
              ]);
        
    }



    public function Store()
    {

        $pk = new PerjanjianKinerja;
        $pk->skpd_id                 = Input::get('skpd_id');
        $pk->periode_tahunan_id      = Input::get('periode_tahunan_id');
        $pk->active                  = '0';

        

        if ( $pk->save()){
            return \Response::make('sukses', 200);
        }else{
            return \Response::make('error', 500);
        }
        
       
    } */






}
