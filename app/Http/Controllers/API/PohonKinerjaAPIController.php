<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Tujuan;
use App\Models\Sasaran;
use App\Models\Program;
use App\Models\Kegiatan;
use App\Models\SubKegiatan;
use App\Models\IndikatorSubKegiatan;

use App\Helpers\Pustaka;


class PohonKinerjaAPIController extends Controller {

    /* 
        update 2021
        
        Tujuan
        Sasaran
        Program
        Kegiatan
        SubKegiatan
    */

    public function PohonKinerjaTree(Request $request) 
    {
       
        //klasifikasi get data menurut root node nya,.. 
        if ( $request->id == "#"){
            $data       = 'tujuan';
            $node_id    = '';
        }else{
            $data = $request->data;

            $x			= explode('|',$request->id);
            $node_id    = $x[1];
        }
        $state = array( "opened" => true, "selected" => false );
        
        switch ($data) {
            case 'tujuan':
            
    
            $tujuan = Tujuan::where('renja_id','=', $request->renja_id )->select('id','label')->get();
            foreach ($tujuan as $x) {
                   

                    $sub_data_tujuan['id']	            = 'tujuan|'.$x->id;
                    $sub_data_tujuan['data']	        = "tujuan";
                    $sub_data_tujuan['text']			= Pustaka::capital_string($x->label);
                    $sub_data_tujuan['icon']            = "jstree-tujuan";
                    $sub_data_tujuan['type']            = "tujuan";
                    $sub_data_tujuan['state']           = $state;
                    
                    //$sub_data_tujuan['children']        = true ;

                    $sasaran = Sasaran::where('tujuan_id','=',$x->id)->select('id','label')->get();
                    foreach ($sasaran as $y) {
                        $sub_data_sasaran['id']		        = 'sasaran|'.$y->id;
                        $sub_data_sasaran['data']	        = "sasaran";
                        $sub_data_sasaran['text']			= Pustaka::capital_string($y->label);
                        $sub_data_sasaran['icon']           = "jstree-sasaran";
                        $sub_data_sasaran['type']           = "sasaran";
                        $sub_data_sasaran['children']       = true ;
                        $sub_data_sasaran['state']           = $state;

                        //$sub_data_sasaran['state']['open']    = true ;

                    $sasaran_list[] = $sub_data_sasaran ;
                }	
                if(!empty($sasaran_list)) { 
                    $sub_data_tujuan['children']       = $sasaran_list;
                }
                $tujuan_list[] = $sub_data_tujuan ;	
                $sasaran_list = "";
                unset($sub_data_tujuan['children']);
            }	
                if(!empty($tujuan_list)) { 
                    return $tujuan_list;
                }else{
                    return "[{}]";
                }
            break;
            case 'sasaran':
                $program = Program:: where('sasaran_id','=',$node_id)->select('id','label')->get();
                foreach ($program as $d) {
                    $sub_data_program['id']		        = 'program|'.$d->id;
                    $sub_data_program['data']	        = "program";
                    $sub_data_program['text']			= Pustaka::capital_string($d->label);
                    $sub_data_program['icon']           = "jstree-program";
                    $sub_data_program['type']           = "program";
                    $sub_data_program['children']       = true ;
                    //$sub_data_program['state']          = $state;

                    $program_list[] = $sub_data_program;
                }
                
                if(!empty($program_list)) { 
                    return $program_list;
                }else{
                    return "[{}]";
                }
                
            break;
            case 'program':
                $kegiatan = Kegiatan:: where('program_id','=',$node_id)->select('id','label')->get();
                foreach ($kegiatan as $e) {
                    $sub_data_kegiatan['id']		    = 'kegiatan|'.$e->id;
                    $sub_data_kegiatan['data']	        = "kegiatan";
                    $sub_data_kegiatan['text']			= Pustaka::capital_string($e->label);
                    $sub_data_kegiatan['icon']          = "jstree-kegiatan";
                    $sub_data_kegiatan['type']          = "kegiatan";
                    $sub_data_kegiatan['children']      = true ;

                    $kegiatan_list[] = $sub_data_kegiatan;
                }
                if(!empty($kegiatan_list)) { 
                    return $kegiatan_list;
                }else{
                    return "[{}]";
                }
                
            break;
            case 'kegiatan':
                $subkegiatan = SubKegiatan:: where('kegiatan_id','=',$node_id)->select('id','label')->get();
                foreach ($subkegiatan as $g) {
                    $sub_data_subkegiatan['id']	            = 'subkegiatan|'.$g->id;
                    $sub_data_subkegiatan['data']	        = "subkegiatan";
                    $sub_data_subkegiatan['text']			= Pustaka::capital_string($g->label);
                    $sub_data_subkegiatan['icon']           = "jstree-subkegiatan";
                    $sub_data_subkegiatan['type']           = "subkegiatan";
                    $sub_data_subkegiatan['children']       = false ;

                    $subkegiatan_list[] = $sub_data_subkegiatan;
                }
                
                if(!empty($subkegiatan_list)) { 
                    return $subkegiatan_list;
                }else{
                    return "[{}]";
                }
                
            break;
            case 'subkegiatan':
                $ind_subkegiatan = IndikatorSubKegiatan:: where('subkegiatan_id','=',$node_id)->select('id','label')->get();
                foreach ($ind_subkegiatan as $g) {
                    $sub_data_ind_subkegiatan['id']	            = 'ind_subkegiatan|'.$g->id;
                    $sub_data_ind_subkegiatan['data']	        = "ind_subkegiatan";
                    $sub_data_ind_subkegiatan['text']			= Pustaka::capital_string($g->label);
                    $sub_data_ind_subkegiatan['icon']           = "jstree-ind_subkegiatan";
                    $sub_data_ind_subkegiatan['type']           = "ind_subkegiatan";

                    $ind_subkegiatan_list[] = $sub_data_ind_subkegiatan;
                }
                
                if(!empty($ind_subkegiatan_list)) { 
                    return $ind_subkegiatan_list;
                }else{
                    return "[{}]";
                }
                
            break;
            default:
            return "[{}]";
            break;
        }
 
           

    }


}
