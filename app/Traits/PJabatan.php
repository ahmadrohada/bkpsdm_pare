<?php

namespace App\Traits;

use App\Models\PerlakuanJabatan;
use App\Models\HistoryJabatan;

use App\Helpers\Pustaka;

trait PJabatan
{


    protected function jenis_PJabatan($label){
        $data = PerlakuanJabatan::WHERE('label', $label )->pluck('jabatan_id');
        return json_encode($data);
    }


    protected function JabatanFromHistoryId($history_jabatan_id ){
        $data = HistoryJabatan::WHERE('tb_history_jabatan.id',$history_jabatan_id)
                                ->leftjoin('demo_asn.m_skpd AS skpd', function($join){
                                    $join   ->on('skpd.id','=','tb_history_jabatan.id_jabatan');
                                })

                                ->SELECT('skpd.skpd AS jabatan')
                                ->first();
        if ( $data != null ){
            return $data->jabatan;
        }else{
            return "-";
        }
        
    }
    

    //=======================================================================================//
    protected function jabatan($id_jabatan){ 
        $jabatan       = HistoryJabatan::WHERE('tb_history_jabatan.id',$id_jabatan)
                                        ->leftjoin('demo_asn.m_skpd AS m_skpd', function($join){
                                            $join   ->on('tb_history_jabatan.id_jabatan','=','m_skpd.id');
                                        })
                                        ->SELECT('m_skpd.skpd AS jabatan')
                                        ->first();
        if ( $jabatan == null ){
            return $jabatan;
        }else{
            return Pustaka::capital_string($jabatan->jabatan);
        }
        
    }

    //=======================================================================================//
    protected function golongan($id_golongan){ 
        $golongan       = HistoryGolongan::WHERE('id',$id_golongan)
                        ->SELECT('jabatan')
                        ->first();
        if ( $golongan == null ){
            return $golongan;
        }else{
            return Pustaka::capital_string($golongan->golongan);
        }
        
    }

    //=======================================================================================//
    protected function atasan_id($pegawai_id){

        $tes =  HistoryJabatan::WHERE('tb_history_jabatan.id_pegawai', $pegawai_id)
                                //cari id jabatan nya
                                ->leftjoin('demo_asn.m_skpd AS m_skpd', function($join){
                                    $join   ->on('m_skpd.id','=','tb_history_jabatan.id_jabatan');
                                })

                                //
                                ->leftjoin('demo_asn.tb_history_jabatan AS atasan', function($join){
                                    $join   ->on('atasan.id_jabatan','=','m_skpd.parent_id');
                                    $join   ->WHERE('atasan.status','=','active');
                                })
                                ->WHERE('tb_history_jabatan.status','active')
                                ->SELECT('atasan.id_pegawai AS atasan_id')
                                ->first();


        return $tes->atasan_id;
       
    }


}