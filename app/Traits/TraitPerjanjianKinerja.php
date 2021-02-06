<?php

namespace App\Traits;

use App\Models\Tujuan;
use App\Models\Sasaran;
use App\Models\Program;
use App\Models\Kegiatan;
use App\Models\SubKegiatan;

use App\Helpers\Pustaka;

trait TraitPerjanjianKinerja
{
  
    
    protected function TraitSasaranSKPD($renja_id){

        $sasaran = Sasaran::with(['Tujuan','IndikatorSasaran'])
                    ->WhereHas('Tujuan', function($q) use($renja_id){
                        $q->where('renja_id',$renja_id);
                        $q->whereNull('deleted_at');
                    })
                    ->WhereHas('IndikatorSasaran', function($q){
                        $q->whereNull('deleted_at');
                    })  
                    ->ORDERBY('id','ASC')
                    ->get();


       

        foreach( $sasaran AS $x ){
            foreach( $x->IndikatorSasaran AS $y ){
                $item[] = array(
                    //Tujuan
                    'renja_id'                  => $x->Tujuan->renja_id,
                    'tujuan_label'              => $x->Tujuan->label,

                    //Sasaran
                    'sasaran_id'                => $x->id,
                    'sasaran_label'             => $x->label,
                    'pk_status'                 => $x->pk_status,
                    //Indikator Sasaran
                    'ind_sasaran_label'         => $y->label,
                    'target'                    => $y->target.' '.$y->satuan
                    
                );
            }
        }
       
               
        return $item; 
    }

    protected function TraitProgramSKPD($renja_id){

        $sasaran = Sasaran::with(['Tujuan','Program'])
                            ->WhereHas('Tujuan', function($q) use($renja_id){
                                $q->where('renja_id',$renja_id);
                                $q->whereNull('deleted_at');
                            })
                            ->WhereHas('Program', function($q){
                                $q->whereNull('deleted_at');
                            }) 
                            ->WHERE('pk_status','1') 
                            ->ORDERBY('id','ASC')
                            ->get();

        $item = array();

        foreach( $sasaran AS $x ){
            foreach( $x->Program AS $y ){

                //mencari nilai anggaran nya 
                //Program->Kegiatan->SUbkegiatan
                $program_id = $y->id;
                $anggaran = SubKegiatan::with(['Kegiatan'])
                                    ->WhereHas('Kegiatan', function($q) use($program_id){
                                        $q->where('program_id',$program_id);
                                        $q->whereNull('deleted_at');
                                    })
                                    ->WHERE('esl2_pk_status','1')
                                    ->sum('cost');

                $item[] = array(
                    'program_id'                => $y->id,
                    'program_label'             => $y->label,
                    'anggaran'                  => "Rp. ".number_format($anggaran,'0',',','.'),
                );
               
            }
        }                      
        return $item; 
    }

    protected function TraitTotalAnggaranSKPD($renja_id){

        $sasaran = Sasaran::with(['Tujuan','Program'])
                            ->WhereHas('Tujuan', function($q) use($renja_id){
                                $q->where('renja_id',$renja_id);
                                $q->whereNull('deleted_at');
                            })
                            ->WhereHas('Program', function($q){
                                $q->whereNull('deleted_at');
                            }) 
                            ->WHERE('pk_status','1') 
                            ->ORDERBY('id','ASC')
                            ->get();

       
        $total_anggaran = 0 ;
        foreach( $sasaran AS $x ){
            foreach( $x->Program AS $y ){

                //mencari nilai anggaran nya 
                //Program->Kegiatan->SUbkegiatan
                $program_id = $y->id;
                $anggaran = SubKegiatan::with(['Kegiatan'])
                                    ->WhereHas('Kegiatan', function($q) use($program_id){
                                        $q->where('program_id',$program_id);
                                        $q->whereNull('deleted_at');
                                    })
                                    ->WHERE('esl2_pk_status','1')
                                    ->sum('cost');

                $total_anggaran = $total_anggaran+$anggaran;
               
               
            }
        }  

		//return  $kegiatan_tahunan;
        $ta = array(
            'total_anggaran'    => "Rp.   " . number_format( $total_anggaran, '0', ',', '.'),

        );
        return $ta;
    }

 
}