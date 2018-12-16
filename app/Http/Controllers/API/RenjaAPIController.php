<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\PeriodeTahunan;
use App\Models\PerjanjianKinerja;


use App\Models\Tujuan;
use App\Models\Sasaran;
use App\Models\SKPD;


use App\Models\SasaranPerjanjianKinerja;
use App\Models\IndikatorSasaran;
use App\Models\Program;
use App\Models\IndikatorProgram;
use App\Models\Kegiatan;
use App\Models\IndikatorKegiatan;
use App\Models\PetaJabatan;
use App\Helpers\Pustaka;

use Datatables;
use Validator;
use Gravatar;
use Input;
Use Alert;

class RenjaAPIController extends Controller {


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


    public function skpd_renja_tree(Request $request)
    {
       
        
//TUJUAN
        $tujuan = Tujuan::where('renja_id','=','2')->select('id','label')->get();
		foreach ($tujuan as $x) {
            $sub_data['id']	            = "tujuan".$x->id;
			$sub_data['text']			= Pustaka::capital_string($x->label);
            $sub_data['icon']           = "jstree-tujuan";
            
//SASARAN 
            $sasaran = Sasaran::where('tujuan_id','=',$x->id)->select('id','label')->get();
            foreach ($sasaran as $y) {
                $sub_data_sasaran['id']		        = "sasaran".$y->id;
                $sub_data_sasaran['text']			= Pustaka::capital_string($y->label);
                $sub_data_sasaran['icon']           = "jstree-sasaran";

//INDIKATOR SASARAN 
                $ind_sasaran = IndikatorSasaran::where('sasaran_id','=',$y->id)->select('id','label')->get();
               
                foreach ($ind_sasaran as $z) {
                    $sub_data_ind_sasaran['id']		                    = "ind_sasaran".$z->id;
                    $sub_data_ind_sasaran['text']			            = Pustaka::capital_string($z->label);
                    $sub_data_ind_sasaran['icon']                       = "jstree-ind_sasaran";
                                        
//PROGRAM 
                    $program = Program:: where('indikator_sasaran_id','=',$z->id)->select('id','label')->get();
                        foreach ($program as $d) {
                            $sub_data_program['id']		        = "program".$d->id;
                            $sub_data_program['text']			= Pustaka::capital_string($d->label);
                            $sub_data_program['icon']           = "jstree-program";

//INDIKATOR PROGRAM
                        $ind_program = IndikatorProgram:: where('program_id','=',$d->id)->select('id','label')->get();
                            foreach ($ind_program as $e) {
                                $sub_data_ind_program['id']	                    = "ind_program".$e->id;
                                $sub_data_ind_program['text']			        = Pustaka::capital_string($e->label);
                                $sub_data_ind_program['icon']                   = "jstree-ind_program";
                        

//KEGIATAN

                            $kegiatan = Kegiatan:: where('indikator_program_id','=',$e->id)->select('id','label')->get();
                                foreach ($kegiatan as $f) {
                                    $sub_data_kegiatan['id']	        = "kegiatan".$f->id;
                                    $sub_data_kegiatan['text']			= Pustaka::capital_string($f->label);
                                    $sub_data_kegiatan['icon']          = "jstree-kegiatan";


//INDIKATOR KEGIATAN

                                $ind_kegiatan = IndikatorKegiatan:: where('kegiatan_id','=',$f->id)->select('id','label')->get();
                                    foreach ($ind_kegiatan as $g) {
                                        $sub_data_ind_kegiatan['id']	        = "ind_kegiatan".$g->id;
                                        $sub_data_ind_kegiatan['text']			= Pustaka::capital_string($g->label);
                                        $sub_data_ind_kegiatan['icon']          = "jstree-ind_kegiatan";


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
                $sub_data['children']       = $sasaran_list;
            }
            $data[] = $sub_data ;	
            //reset sasaran list
            $sasaran_list = "";
            unset($sub_data['children']);
		}	
        
       
		return $data;
        
    }
    


    public function skpd_renja_distribusi_kegiatan_tree(Request $request)
    {
       

        $pejabat = SKPD::where('parent_id','=','42')->select('id','skpd')->get();
		foreach ($pejabat as $x) {
            $data_pejabat['id']	            = "pejabat".$x->id;
			$data_pejabat['text']			= Pustaka::capital_string($x->skpd);
            $data_pejabat['icon']           = "jstree-tujuan";
            

            $bawahan = SKPD::where('parent_id','=',$x->id)->select('id','skpd')->get();

            foreach ($bawahan as $y) {
                $data_bawahan['id']	            = "bawahan".$y->id;
                $data_bawahan['text']			= Pustaka::capital_string($y->skpd);
                $data_bawahan['icon']           = "jstree-file";
                

                $kegiatan = Kegiatan::WHERE('jabatan_id','=',$y->id)->select('id','label')->get();
                foreach ($kegiatan as $z) {
                    $data_kegiatan['id']	        = "kegiatan".$z->id;
                    $data_kegiatan['text']			= Pustaka::capital_string($z->label);
                    $data_bawahan['icon']           = "jstree-kegiatan";
                    
    
                    $kegiatan_list[] = $data_kegiatan ;
                   
                    }
                if(!empty($kegiatan_list)) {
                    $data_bawahan['children']     = $kegiatan_list;
                }
                $bawahan_list[] = $data_bawahan ;
                $kegiatan_list = "";
                unset($data_bawahan['children']);
               
                }
               
               

            }	


            if(!empty($bawahan_list)) {
                $data_pejabat['children']     = $bawahan_list;
            }
            $data[] = $data_pejabat ;	
            $bawahan_list = "";
            unset($data_pejabat['children']);
		
		return $data;
        
    }
}
