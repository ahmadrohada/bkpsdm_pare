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
use App\Models\Periode;
use App\Models\Pegawai;


use App\Models\SasaranPerjanjianKinerja;
use App\Models\IndikatorSasaran;
use App\Models\Program;
use App\Models\IndikatorProgram;
use App\Models\Kegiatan;
use App\Models\IndikatorKegiatan;
use App\Models\KegiatanSKPBulanan;
use App\Models\RencanaAksi;
use App\Models\PetaJabatan;
use App\Models\MasaPemerintahan;

use App\Helpers\Pustaka;

use Datatables;
use Validator;
use Gravatar;
use Input;
Use Alert;

class PohonKinerjaAPIController extends Controller {



    public function PohonKinerjaTreeOld(Request $request)
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
            $sasaran = Sasaran::where('indikator_tujuan_id','=',$v->id)->select('id','label')->get();
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

                            $kegiatan = Kegiatan:: where('indikator_program_id','=',$e->id)->select('id','label','cost')->get();
                                foreach ($kegiatan as $f) {
                                    $sub_data_kegiatan['id']	        = "kegiatan|".$f->id;
                                    $sub_data_kegiatan['text']			= Pustaka::capital_string($f->label); 
                                    $sub_data_kegiatan['type']          = "kegiatan";
                                    if ( $f->cost > 0 ){
                                        $sub_data_kegiatan['icon']          = "jstree-kegiatan";
                                    }else{
                                        $sub_data_kegiatan['icon']          = "jstree-kegiatan_non_anggaran";
                                    }


//INDIKATOR KEGIATAN  

                                $ind_kegiatan = IndikatorKegiatan:: where('kegiatan_id','=',$f->id)->select('id','label')->get();
                                    foreach ($ind_kegiatan as $g) {
                                        $sub_data_ind_kegiatan['id']	        = "ind_kegiatan|".$g->id;
                                        $sub_data_ind_kegiatan['text']			= Pustaka::capital_string($g->label);
                                        $sub_data_ind_kegiatan['icon']          = "jstree-ind_kegiatan";
                                        $sub_data_ind_kegiatan['type']          = "ind_kegiatan";

//RENCANA AKSI
                                    /* $ra = RencanaAksi::WHERE('indikator_kegiatan_id',$g->id)->get();

                                        foreach ($ra as $za) {
                                            $data_rencana_aksi['id']	= "rencana_aksi|".$za->id;
                                            $data_rencana_aksi['text']	= Pustaka::capital_string($za->label).' ['. Pustaka::bulan($za->waktu_pelaksanaan).']';
                                            $data_rencana_aksi['icon']  = 'jstree-rencana_aksi';



 //TARGET PADA KEGIATAN BULANAN
                                        $kb = KegiatanSKPBulanan::WHERE('rencana_aksi_id',$za->id)->get();
                                            foreach ($kb as $az) {
                                                $data_keg_bulanan['id']	    = "kegiatan_bulanan|".$az->id;
                                                $data_keg_bulanan['text']	=  'Target : '. $az->target.' '.$az->satuan.' / Pelaksana : '.Pustaka::capital_string($az->RencanaAksi->pelaksana->jabatan);
                                                $data_keg_bulanan['icon']	= 'jstree-target';
                                            

                                                $keg_bulanan_list[] = $data_keg_bulanan ;
                                            }	
                                                if(!empty($keg_bulanan_list)) {
                                                    $data_rencana_aksi['children']     = $keg_bulanan_list;
                                                }

                                                $rencana_aksi_list[] = $data_rencana_aksi ;
                                                $keg_bulanan_list = "";
                                                unset($data_rencana_aksi['children']);
                                            }
                                            if(!empty($rencana_aksi_list)) {
                                                $sub_data_ind_kegiatan['children']     = $rencana_aksi_list;
                                            }
                                            
                                        $ind_kegiatan_list[] = $sub_data_ind_kegiatan ;
                                        $rencana_aksi_list = "";
                                        unset($sub_data_ind_kegiatan['children']);
                                         */
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
        
        
        if(!empty($data)) { 
            return $data;
        }else{
            return "[{}]";
        }
        
       
		
        
    }


    public function PohonKinerjaTree(Request $request)
    {
       

     
        
//TUJUAN
        $tujuan = Tujuan::where('renja_id','=', $request->renja_id )->select('id','label')->get();
		foreach ($tujuan as $x) {
            $sub_data_tujuan['id']	            = "tujuan|".$x->id;
			$sub_data_tujuan['text']			= Pustaka::capital_string($x->label);
            $sub_data_tujuan['icon']            = "jstree-tujuan";
            $sub_data_tujuan['type']            = "tujuan";


//SASARAN 
            $sasaran = Sasaran::where('tujuan_id','=',$x->id)->select('id','label')->get();
            foreach ($sasaran as $y) {
                $sub_data_sasaran['id']		        = "sasaran|".$y->id;
                $sub_data_sasaran['text']			= Pustaka::capital_string($y->label);
                $sub_data_sasaran['icon']           = "jstree-sasaran";
                $sub_data_sasaran['type']           = "sasaran";


//PROGRAM 
                    $program = Program:: where('sasaran_id','=',$y->id)->select('id','label')->get();
                        foreach ($program as $d) {
                            $sub_data_program['id']		        = "program|".$d->id;
                            $sub_data_program['text']			= Pustaka::capital_string($d->label);
                            $sub_data_program['icon']           = "jstree-program";
                            $sub_data_program['type']           = "program";


//KEGIATAN

                            $kegiatan = Kegiatan:: where('program_id','=',$d->id)->select('id','label','cost')->get();
                                foreach ($kegiatan as $f) {
                                    $sub_data_kegiatan['id']	        = "kegiatan|".$f->id;
                                    $sub_data_kegiatan['text']			= Pustaka::capital_string($f->label); 
                                    $sub_data_kegiatan['type']          = "kegiatan";
                                    if ( $f->cost > 0 ){
                                        $sub_data_kegiatan['icon']          = "jstree-kegiatan";
                                    }else{
                                        $sub_data_kegiatan['icon']          = "jstree-kegiatan_non_anggaran";
                                    }


//INDIKATOR KEGIATAN  

                                $ind_kegiatan = IndikatorKegiatan:: where('kegiatan_id','=',$f->id)->select('id','label')->get();
                                    foreach ($ind_kegiatan as $g) {
                                        $sub_data_ind_kegiatan['id']	        = "ind_kegiatan|".$g->id;
                                        $sub_data_ind_kegiatan['text']			= Pustaka::capital_string($g->label);
                                        $sub_data_ind_kegiatan['icon']          = "jstree-ind_kegiatan";
                                        $sub_data_ind_kegiatan['type']          = "ind_kegiatan";

//RENCANA AKSI
                                    /* $ra = RencanaAksi::WHERE('indikator_kegiatan_id',$g->id)->get();

                                        foreach ($ra as $za) {
                                            $data_rencana_aksi['id']	= "rencana_aksi|".$za->id;
                                            $data_rencana_aksi['text']	= Pustaka::capital_string($za->label).' ['. Pustaka::bulan($za->waktu_pelaksanaan).']';
                                            $data_rencana_aksi['icon']  = 'jstree-rencana_aksi';



 //TARGET PADA KEGIATAN BULANAN
                                        $kb = KegiatanSKPBulanan::WHERE('rencana_aksi_id',$za->id)->get();
                                            foreach ($kb as $az) {
                                                $data_keg_bulanan['id']	    = "kegiatan_bulanan|".$az->id;
                                                $data_keg_bulanan['text']	=  'Target : '. $az->target.' '.$az->satuan.' / Pelaksana : '.Pustaka::capital_string($az->RencanaAksi->pelaksana->jabatan);
                                                $data_keg_bulanan['icon']	= 'jstree-target';
                                            

                                                $keg_bulanan_list[] = $data_keg_bulanan ;
                                            }	
                                                if(!empty($keg_bulanan_list)) {
                                                    $data_rencana_aksi['children']     = $keg_bulanan_list;
                                                }

                                                $rencana_aksi_list[] = $data_rencana_aksi ;
                                                $keg_bulanan_list = "";
                                                unset($data_rencana_aksi['children']);
                                            }
                                            if(!empty($rencana_aksi_list)) {
                                                $sub_data_ind_kegiatan['children']     = $rencana_aksi_list;
                                            }
                                            
                                        $ind_kegiatan_list[] = $sub_data_ind_kegiatan ;
                                        $rencana_aksi_list = "";
                                        unset($sub_data_ind_kegiatan['children']);
                                         */
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
                                $sub_data_program['children']     = $kegiatan_list;
                            }
                            $program_list[] = $sub_data_program ;
                            $kegiatan_list = "";
                            unset($sub_data_program['children']);
                          
                            

                        }

                if(!empty($program_list)) {
                    $sub_data_sasaran['children']     = $program_list;
                }
                $sasaran_list[] = $sub_data_sasaran ;
                $program_list = "";
                unset($sub_data_sasaran['children']);
                
            }	


            

          
        if(!empty($sasaran_list)) { 
            $sub_data_tujuan['children']       = $sasaran_list;
        }
        $data[] = $sub_data_tujuan ;	
        //reset sasaran list
        $sasaran_list = "";
        unset($sub_data_tujuan['children']);
    }	
        
        
        if(!empty($data)) { 
            return $data;
        }else{
            return "[{}]";
        }
        
       
		
        
    }
    



}
