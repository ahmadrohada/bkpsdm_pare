<?php

namespace App\Traits;

use App\Models\CapaianPKTriwulan;
use App\Models\Kegiatan;
use App\Models\RealisasiIndikatorSasaranTriwulan;
use App\Models\RealisasiIndikatorProgramTriwulan;
use App\Models\RealisasiIndikatorKegiatanTriwulan;

use App\Models\CapaianTriwulan;


use App\Helpers\Pustaka;

trait RealisasiCapaianTriwulan
{

    public function realisasi_indikator_sasaran_triwulan($renja_id,$triwulan,$indikator_sasaran_id){ 

        //cari capaian trieulan ID nya dulu
        $dt_tw = CapaianPKTriwulan::WHERE('renja_id','=',$renja_id)
                                    ->WHERE('triwulan','=',$triwulan)
                                    ->first();
        if ( $dt_tw ){
            $data = RealisasiIndikatorSasaranTriwulan::WHERE('capaian_id','=', $dt_tw->id)
                                                    ->WHERE('indikator_sasaran_id','=',$indikator_sasaran_id)
                                                    ->first();
            if ( $data ){
                return $data->realisasi_quantity.' '.$data->satuan;
            }else{
                return "-";
            }
        }else{
            return "-";
        }
    }

    public function realisasi_indikator_program_triwulan($renja_id,$triwulan,$indikator_program_id){ 

        //cari capaian trieulan ID nya dulu
        $dt_tw = CapaianPKTriwulan::WHERE('renja_id','=',$renja_id)
                                    ->WHERE('triwulan','=',$triwulan)
                                    ->first();
        if ( $dt_tw ){
            $data = RealisasiIndikatorProgramTriwulan::WHERE('capaian_id','=', $dt_tw->id)
                                                    ->WHERE('indikator_program_id','=',$indikator_program_id)
                                                    ->first();
            if ( $data ){
                return $data->realisasi_quantity.' '.$data->satuan;
            }else{
                return "-";
            }
        }else{
            return "-";
        }
    }


    public function realisasi_indikator_kegiatan_triwulan($renja_id,$triwulan,$kegiatan_id,$indikator_kegiatan_id){ 


        //Cari pelaksanan ny dulu
        $jabatan_id_data = Kegiatan::WHERE('id','=',$kegiatan_id)->SELECT('jabatan_id')->first();
        if ($jabatan_id_data){
            $jabatan_id = $jabatan_id_data->jabatan_id;
        }else{
            $jabatan_id = 0 ;
        }
       

        //cari capaian trieulan ID nya dulu
        $dt_tw = CapaianTriwulan:: 
                                    rightjoin('db_pare_2018.skp_tahunan AS skp_tahunan', function($join) use($renja_id){ 
                                        $join   ->on('skp_tahunan.id','=','capaian_triwulan.skp_tahunan_id');
                                        $join   ->where('skp_tahunan.renja_id','=',$renja_id);
                                    })
                                    //PEJABAT YANG DINILAI
                                    ->rightjoin('demo_asn.tb_history_jabatan AS pejabat', function($join) use($jabatan_id){
                                        $join   ->on('skp_tahunan.u_jabatan_id','=','pejabat.id');
                                        $join   ->where('pejabat.id_jabatan','=',$jabatan_id);
                                    }) 
                                    ->SELECT(   'capaian_triwulan.id AS capaian_triwulan_id',
                                                'pejabat.id_jabatan'
                                                )
                                    ->WHERE('capaian_triwulan.triwulan','=',$triwulan)
                                    ->first();
     
        if ( $dt_tw ){
            $data = RealisasiIndikatorKegiatanTriwulan::WHERE('capaian_id','=', $dt_tw->capaian_triwulan_id)
                                                    ->WHERE('indikator_kegiatan_id','=',$indikator_kegiatan_id)
                                                    ->first();
            if ( $data ){
                return $data->realisasi_quantity.' '.$data->satuan;
            }else{
                return "-";
            }
        }else{
            return "-";
        } 
    }


    public function hitung_percentage_realisasi_indikator_kegiatan_triwulan($renja_id,$triwulan,$kegiatan_id,$indikator_kegiatan_id,$target){ 


        //Cari pelaksanan ny dulu
        $jabatan_id_data = Kegiatan::WHERE('id','=',$kegiatan_id)->SELECT('jabatan_id')->first();
        if ($jabatan_id_data){
            $jabatan_id = $jabatan_id_data->jabatan_id;
        }else{
            $jabatan_id = 0 ;
        }
       

        //cari capaian trieulan ID nya dulu
        $dt_tw = CapaianTriwulan:: 
                                    rightjoin('db_pare_2018.skp_tahunan AS skp_tahunan', function($join) use($renja_id){ 
                                        $join   ->on('skp_tahunan.id','=','capaian_triwulan.skp_tahunan_id');
                                        $join   ->where('skp_tahunan.renja_id','=',$renja_id);
                                    })
                                    //PEJABAT YANG DINILAI
                                    ->rightjoin('demo_asn.tb_history_jabatan AS pejabat', function($join) use($jabatan_id){
                                        $join   ->on('skp_tahunan.u_jabatan_id','=','pejabat.id');
                                        $join   ->where('pejabat.id_jabatan','=',$jabatan_id);
                                    }) 
                                    ->SELECT(   'capaian_triwulan.id AS capaian_triwulan_id',
                                                'pejabat.id_jabatan'
                                                )
                                    ->WHERE('capaian_triwulan.triwulan','=',$triwulan)
                                    ->first();
     
        if ( $dt_tw ){
            $data = RealisasiIndikatorKegiatanTriwulan::WHERE('capaian_id','=', $dt_tw->capaian_triwulan_id)
                                                    ->WHERE('indikator_kegiatan_id','=',$indikator_kegiatan_id)
                                                    ->first();
            if ( $data ){
                return Pustaka::persen($data->realisasi_quantity,$target);
            }else{
                return "0 %";
            }
        }else{
            return "0 %";
        } 
    }



}