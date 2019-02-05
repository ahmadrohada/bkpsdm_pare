<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\PeriodeTahunan;
use App\Models\PerjanjianKinerja;


use App\Models\Tujuan;
use App\Models\IndikatorTujuan;
use App\Models\Sasaran;
use App\Models\Skpd;
use App\Models\Renja;


use App\Models\SasaranPerjanjianKinerja;
use App\Models\IndikatorSasaran;
use App\Models\Program;
use App\Models\IndikatorProgram;
use App\Models\Kegiatan;
use App\Models\IndikatorKegiatan;
use App\Models\PetaJabatan;
use App\Models\MasaPemerintahan;

use App\Helpers\Pustaka;

use Datatables;
use Validator;
use Gravatar;
use Input;
Use Alert;

class RenjaAPIController extends Controller {


    public function RenjaTimelineStatus( Request $request )
    {
        $response = array();
        $body = array();
        $body_2 = array();


        $renja = Renja::where('id','=', $request->renja_id )
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

        if ( $renja->send_to_kaban == 1 )
        {
            array_push($response, $i);
        }
        
        


        return $response;


    }


    public function RenjaStatusPengisian( Request $request )
    {
       
        $button_kirim = 0 ;


        $renja = Renja::
                            leftjoin('demo_asn.tb_history_jabatan AS kaban', function($join){
                                $join   ->on('kaban.id','=','renja.kepala_skpd_id');
                            })
                            /* ->SELECT(
                                'skp_tahunan.id AS skp_tahunan_id',
                                'atasan.id AS atasan_id',
                                'skp_tahunan.status_approve'
                            ) */
                            ->where('renja.id','=', $request->renja_id )->first();;

        //STATUS SKP
        if ( $skp_tahunan->skp_tahunan_id != null ){
            $created = 'ok';
        }else{
            $created = '-';
        }
        
        //STATUS PEJABAT PENILAI
        if ( $skp_tahunan->atasan_id != null ){
            $atasan = 'ok';
        }else{
            $atasan = '-';
        }


        //button kirim
        if ( ( $created == 'ok') && ( $atasan == 'ok') && ( $kegiatan_tahunan == 'ok' ) && (  $data_rencana_aksi == 'ok') ){
            $button_kirim = 1 ;
        }else{
            $button_kirim = 0 ;
        }
        
         //STATUS APPROVE
         if ( ($skp_tahunan->status_approve) == 1 ){
            $persetujuan_atasan = 'ok';
        }else{
            $persetujuan_atasan = '-';
        }


        $response = array(
                'created'                 => $created,
                'data_pejabat_penilai'    => $atasan,
                'data_kegiatan_tahunan'   => $kegiatan_tahunan,
                'data_rencana_aksi'       => $data_rencana_aksi,
                'persetujuan_atasan'      => $persetujuan_atasan,
                'button_kirim'            => $button_kirim ,


        );
       
        return $response;


    }


    public function skpd_renja_list(Request $request)
    {
       
        
        $dt = \DB::table('db_pare_2018.renja AS renja')
                //PERIODE
                ->join('db_pare_2018.periode AS periode', function($join){
                    $join   ->on('periode.id','=','renja.periode_id');
                    
                })

                //ID KEPALA SKPD
                ->leftjoin('demo_asn.tb_history_jabatan AS id_ka_skpd', function($join){
                    $join   ->on('id_ka_skpd.id','=','renja.kepala_skpd_id');
                })
                //NAMA KEPALA SKPD
                ->leftjoin('demo_asn.tb_pegawai AS kepala_skpd', function($join){
                    $join   ->on('kepala_skpd.id','=','id_ka_skpd.id_pegawai');
                })
                
                ->select([  'renja.id AS renja_id',
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


    public function SKPDRenjaactivity(Request $request)
    {
       

     
        
//TUJUAN
        $tujuan = Tujuan::where('renja_id','=', $request->renja_id )->select('id','label')->get();
		foreach ($tujuan as $x) {
            $sub_data_tujuan['id']	            = "tujuan|".$x->id;
			$sub_data_tujuan['text']			= Pustaka::capital_string($x->label);
            $sub_data_tujuan['icon']            = "jstree-tujuan";
            $sub_data_tujuan['type']            = "tujuan";


//INDIKATOR TUJUAN 
            $ind_tujuan = IndikatorTujuan::where('tujuan_id','=',$x->id)->select('id','label')->get();
            foreach ($ind_tujuan as $v) {
                $sub_data_ind_tujuan['id']		        = "ind_tujuan|".$v->id;
                $sub_data_ind_tujuan['text']			= Pustaka::capital_string($v->label);
                $sub_data_ind_tujuan['icon']            = "jstree-ind_tujuan";
                $sub_data_ind_tujuan['type']            = "ind_tujuan";
               
            
//SASARAN 
            $sasaran = Sasaran::where('indikator_tujuan_id','=',$v->id)
                                ->select('id','label')->get();
            foreach ($sasaran as $y) {
                $sub_data_sasaran['id']		        = "sasaran|".$y->id;
                $sub_data_sasaran['text']			= Pustaka::capital_string($y->label);
                $sub_data_sasaran['icon']           = "jstree-sasaran";
                $sub_data_sasaran['type']           = "sasaran";

//INDIKATOR SASARAN 
                $ind_sasaran = IndikatorSasaran::where('sasaran_id','=',$y->id)->select('id','label')->get();
               
                foreach ($ind_sasaran as $z) {
                    $sub_data_ind_sasaran['id']		                    = "ind_sasaran|".$z->id;
                    $sub_data_ind_sasaran['text']			            = Pustaka::capital_string($z->label);
                    $sub_data_ind_sasaran['icon']                       = "jstree-ind_sasaran";
                    $sub_data_ind_sasaran['type']                       = "ind_sasaran";
                                        
//PROGRAM 
                    $program = Program:: where('indikator_sasaran_id','=',$z->id)->select('id','label')->get();
                        foreach ($program as $d) {
                            $sub_data_program['id']		        = "program|".$d->id;
                            $sub_data_program['text']			= Pustaka::capital_string($d->label);
                            $sub_data_program['icon']           = "jstree-program";
                            $sub_data_program['type']           = "program";
//INDIKATOR PROGRAM
                        $ind_program = IndikatorProgram:: where('program_id','=',$d->id)->select('id','label')->get();
                            foreach ($ind_program as $e) {
                                $sub_data_ind_program['id']	                    = "ind_program|".$e->id;
                                $sub_data_ind_program['text']			        = Pustaka::capital_string($e->label);
                                $sub_data_ind_program['icon']                   = "jstree-ind_program";
                                $sub_data_ind_program['type']                   = "ind_program";
                        

//KEGIATAN

                            $kegiatan = Kegiatan:: where('indikator_program_id','=',$e->id)->select('id','label')->get();
                                foreach ($kegiatan as $f) {
                                    $sub_data_kegiatan['id']	        = "kegiatan|".$f->id;
                                    $sub_data_kegiatan['text']			= Pustaka::capital_string($f->label);
                                    $sub_data_kegiatan['icon']          = "jstree-kegiatan";
                                    $sub_data_kegiatan['type']          = "kegiatan";
                                   


//INDIKATOR KEGIATAN

                                $ind_kegiatan = IndikatorKegiatan:: where('kegiatan_id','=',$f->id)->select('id','label')->get();
                                    foreach ($ind_kegiatan as $g) {
                                        $sub_data_ind_kegiatan['id']	        = "ind_kegiatan|".$g->id;
                                        $sub_data_ind_kegiatan['text']			= Pustaka::capital_string($g->label);
                                        $sub_data_ind_kegiatan['icon']          = "jstree-ind_kegiatan";
                                        $sub_data_ind_kegiatan['type']          = "ind_kegiatan";


                                        $ind_kegiatan_list[] = $sub_data_ind_kegiatan ;
                                    }

                                    if(!empty($ind_kegiatan_list)) {
                                        $sub_data_kegiatan['children']     = $ind_kegiatan_list;
                                    }

                                    $kegiatan_list[] = $sub_data_kegiatan ;
                                    $ind_kegiatan_list = "";
                                    unset($sub_data_kegiatan['children']);
                                }

                                if(!empty($kegiatan_list)) {
                                    $sub_data_ind_program['children']     = $kegiatan_list;
                                }

                                $ind_program_list[] = $sub_data_ind_program ;
                                $kegiatan_list = "";
                                unset($sub_data_ind_program['children']);

                            }


                            if(!empty($ind_program_list)) {
                                $sub_data_program['children']     = $ind_program_list;
                            }
                            $program_list[] = $sub_data_program ;
                            $ind_program_list = "";
                            unset($sub_data_program['children']);
                          
                            

                        }

                        if(!empty($program_list)) {
                            $sub_data_ind_sasaran['children']     = $program_list;
                        }
                        
                        
                        $ind_sasaran_list[] = $sub_data_ind_sasaran ;
                        $program_list = "";
                        unset($sub_data_ind_sasaran['children']);
                        
                    
                }	
                if(!empty($ind_sasaran_list)) {
                    $sub_data_sasaran['children']     = $ind_sasaran_list;
                }
                $sasaran_list[] = $sub_data_sasaran ;
                $ind_sasaran_list = "";
                unset($sub_data_sasaran['children']);
                
            }	


            

            if(!empty($sasaran_list)) { 
                $sub_data_ind_tujuan['children']       = $sasaran_list;
            }
            $ind_tujuan_list[] = $sub_data_ind_tujuan ;	
            $sasaran_list = "";
            unset($sub_data_ind_tujuan['children']);
        }	


        if(!empty($ind_tujuan_list)) { 
            $sub_data_tujuan['children']       = $ind_tujuan_list;
        }
        $data[] = $sub_data_tujuan ;	
        //reset sasaran list
        $ind_tujuan_list = "";
        unset($sub_data_tujuan['children']);
    }	
        
        
        
       
		return $data;
        
    }
    


    















}
