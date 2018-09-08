<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;

use App\Models\Pegawai;
use App\Models\SKPTahunan;
use App\Models\Jabatan;
use App\Models\HistoryJabatan;


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

  
   

}
