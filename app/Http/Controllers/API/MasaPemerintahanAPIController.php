<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use App\Models\MasaPemerintahan;
use App\Models\Periode;
use App\Models\PerjanjianKinerja;
use App\Models\SasaranPerjanjianKinerja;
use App\Models\IndikatorSasaran;
use App\Models\Program;
use App\Models\SKPD;
use App\Models\Renja;
use App\Models\IndikatorProgram;
use App\Models\Kegiatan;
use App\Models\IndikatorKegiatan;
use App\Helpers\Pustaka;

use Datatables;
use Validator;
use Gravatar;
use Input;
Use Alert;

class MasaPemerintahanAPIController extends Controller {


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
            
        $dt = \DB::table('db_pare_2018_demo.renja AS renja')
                   
                    ->rightjoin('db_pare_2018_demo.perjanjian_kinerja AS pk', function($join){
                        $join   ->on('pk.renja_id','=','renja.id');
                    }) //ID KEPALA SKPD
                    ->leftjoin('demo_asn.tb_history_jabatan AS id_mp', function($join){
                        $join   ->on('id_mp.id','=','renja.kepala_skpd_id');
                    })
                    //NAMA KEPALA SKPD
                    ->leftjoin('demo_asn.tb_pegawai AS kepala_skpd', function($join){
                        $join   ->on('kepala_skpd.id','=','id_mp.id_pegawai');
                    })//PERIODE
                    ->join('db_pare_2018_demo.periode AS periode', function($join){
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
 */

    public function AdministratorMasaPemerintahanList(Request $request)
    {
        
        $dt = MasaPemerintahan::select([    'id AS masa_pemerintahan_id',
                                            'kepala_daerah',
                                            'wakil_kepala_daerah',
                                            'status',
                                            'label'
                                    ]);


        $datatables = Datatables::of($dt)
                            ->addColumn('status', function ($x) {
                                if ($x->status == 1){
                                    $status = 'Aktif';
                                }else{
                                    $status = 'tidak Aktif';
                                }
                                return $status;

                            })
                            ->addColumn('periode', function ($x) {
                                
                                return $x->label;
                            
                            });

        
        if ($keyword = $request->get('search')['value']) {
            $datatables->filterColumn('rownum', 'whereRaw', '@rownum  + 1 like ?', ["%{$keyword}%"]);
        } 

        return $datatables->make(true);
        
    }



    public function AdministratorMasaPemerintahanTree(Request $request)
    {
       

        $mp = MasaPemerintahan::select('id','label')->get();
		foreach ($mp as $x) {
            $data_mp['id']	            = "mp|".$x->id;
			$data_mp['text']			= Pustaka::capital_string($x->label);
            //$data_mp['icon']          = "jstree-default";
            $data_mp['type']            = "mp";
            

            $periode = Periode::where('masa_pemerintahan_id','=',$x->id)->select('id','label','status')->get();
            foreach ($periode as $y) {
                if ( $y->status == 1 ){
                    $data_periode['icon']       = "jstree-ind_kegiatan";
                }else{
                    $data_periode['icon']       = "";
                }

                $data_periode['id']	        = "periode|".$y->id;
                $data_periode['text']	    = Pustaka::capital_string($y->label);
                $data_periode['type']       = "periode";


                $renja = Renja::where('periode_id','=',$y->id)
                                    ->rightjoin('db_pare_2018_demo.perjanjian_kinerja AS pk', function($join){
                                        $join   ->on('pk.renja_id','=','renja.id');
                                        
                                    })
                                    ->select('renja.id','renja.skpd_id')
                                    ->get();
                foreach ($renja as $z) {
                    

                    $data_renja['id']	            = "renja|".$z->id;
                    $data_renja['text']			    = Pustaka::capital_string($z->SKPD->skpd);
                    $data_renja['icon']             = "jstree-people";
                    $data_renja['type']             = "renja";
                    

                    $kegiatan = Kegiatan::WHERE('jabatan_id','=',$z->id)->select('id','label')->get();
                    foreach ($kegiatan as $a) {
                        $data_kegiatan['id']	        = "kegiatan|".$a->id;
                        $data_kegiatan['text']			= Pustaka::capital_string($a->label);
                        $data_kegiatan['icon']          = "jstree-ind_kegiatan";
                        $data_kegiatan['type']          = "kegiatan";
                        
        
                        $kegiatan_list[] = $data_kegiatan ;
                   
                    }

                    if(!empty($kegiatan_list)) {
                        $data_renja['children']     = $kegiatan_list;
                    }
                    $renja_list[] = $data_renja ;
                    $kegiatan_list = "";
                    unset($data_renja['children']);
                
                }

                if(!empty($renja_list)) {
                    $data_periode['children']     = $renja_list;
                }
                $periode_list[] = $data_periode ;
                $renja_list = "";
                unset($data_periode['children']);
            
            }
               
               

        }	

            if(!empty($periode_list)) {
                $data_mp['children']     = $periode_list;
            }
            $data[] = $data_mp ;	
            $periode_list = "";
            unset($data_mp['children']);
		
		return $data;
        
    }

}
