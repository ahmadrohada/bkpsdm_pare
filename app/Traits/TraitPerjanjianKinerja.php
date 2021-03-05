<?php

namespace App\Traits;

use App\Models\Tujuan;
use App\Models\Sasaran;
use App\Models\Program;
use App\Models\Kegiatan;
use App\Models\SubKegiatan;


use App\Models\SKPTahunan;
use App\Models\Jabatan;


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


       
        $item = array();
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
                $subkegiatan = SubKegiatan::with(['Kegiatan'])
                                    ->WhereHas('Kegiatan', function($q) use($program_id){
                                        $q->where('program_id',$program_id);
                                        $q->whereNull('deleted_at');
                                    })
                                    ->WHERE('esl2_pk_status','1');

                $jm_subkegiatan     = $subkegiatan->count();
                $anggaran           = $subkegiatan->sum('cost');

                $item[] = array(
                    'program_id'                => $y->id,
                    'program_label'             => $y->label,
                    'jm_subkegiatan'            => $jm_subkegiatan,
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


    protected function TraitSubKegiatanListSKPD($program_id){


        $subkegiatan = SubKegiatan::with(['Kegiatan'])
                                        ->WhereHas('Kegiatan', function($q) use($program_id){
                                            $q->where('program_id',$program_id);
                                            $q->whereNull('deleted_at');
                                        })
                                        ->GET();

                                        $item = array();
                             
        foreach( $subkegiatan AS $x ){
                $item[] = array(
                        'id'                    => $x->id,
                        'label'                 => $x->label,
                        'esl2_pk_status'        => $x->esl2_pk_status,
                        'kegiatan_target'       => $x->target.' '.$x->satuan,
                        'kegiatan_anggaran'     => "Rp. ".number_format($x->cost,'0',',','.'),
                );
                                            
        }
        return $item; 
     }

     

    protected function TraitTotalAnggaranSubKegiatanSKPD($program_id){


       $anggaran = SubKegiatan::with(['Kegiatan'])
                                    ->WhereHas('Kegiatan', function($q) use($program_id){
                                        $q->where('program_id',$program_id);
                                        $q->whereNull('deleted_at');
                                    })
                                    ->WHERE('esl2_pk_status','1')
                                    ->sum('cost');
        $ta = array(
            'total_anggaran'    => "Rp.   " . number_format( $anggaran, '0', ',', '.'),

        );
        return $ta;
    }



    protected function TraitSasaranEselon3($skp_tahunan_id){

        $skp_tahunan    = SKPTahunan::WHERE('id',$skp_tahunan_id)->first();
        $jabatan_id     = $skp_tahunan->PegawaiYangDinilai->id_jabatan;
        $renja_id       = $skp_tahunan->Renja->id;

        //cari bawahan nya, karena eselon 3 tidak punya kegiatan tahunan,yang punya nya adalah  bawahan nya
        $child = Jabatan::SELECT('id')->WHERE('parent_id', $jabatan_id )->get()->toArray(); 

        $kegiatan = Kegiatan::with(['SubKegiatan','Program'])
                                    ->WhereHas('SubKegiatan', function($q) use($renja_id,$child){
                                        $q->WHERE('renja_id', $renja_id );
                                        $q->WHEREIN('jabatan_id',$child );
                                        $q->whereNull('deleted_at');
                                    })
                                    ->WhereHas('Program', function($q) {
                                        $q->whereNull('deleted_at');
                                    })
                                    ->GroupBy('program_id')
                                    ->GET();
        foreach( $kegiatan AS $x ){
            foreach( $x->Program->IndikatorProgram AS $y ){
                $item[] = array(
                    //'sasaran_id'        => $x->Program->Sasaran->id,
                    //'sasaran_label'     => $x->Program->Sasaran->label,

                    'program_id'        => $x->Program->id,
                    'program_label'     => $x->Program->Sasaran->label.'/'.$x->Program->label,

                    'ind_program_id'    => $y->id,
                    'ind_program_label' => $y->label, 
                    'target'            => $y->target.' '.$y->satuan, 
                    'pk_status'         => $y->pk_status,     
                );

            }                                                          
        }
        return $item; 
       
    }

    protected function TraitProgramEselon3($skp_tahunan_id){
    
        $skp_tahunan    = SKPTahunan::WHERE('id',$skp_tahunan_id)->first();
        $jabatan_id     = $skp_tahunan->PegawaiYangDinilai->id_jabatan;
        $renja_id       = $skp_tahunan->Renja->id;
        //cari bawahan nya, karena eselon 3 tidak punya kegiatan tahunan,yang punya nya adalah  bawahan nya
        $child = Jabatan::SELECT('id')->WHERE('parent_id', $jabatan_id )->get()->toArray(); 

        $program = Program::with(['IndikatorProgram','Kegiatan'])
                                ->WhereHas('IndikatorProgram', function($q){
                                    $q->WHERE('pk_status', '1' );
                                    $q->whereNull('deleted_at');
                                })
                                ->WhereHas('Kegiatan', function($q) use($renja_id) {
                                    $q->WHERE('renja_id', $renja_id );
                                    $q->whereNull('deleted_at');
                                })
                                ->GET();
        $item = array();
        foreach( $program AS $x ){
            $program_id = $x->id;
            $data = SubKegiatan::with(['Kegiatan'])
                                ->WhereHas('Kegiatan', function($q) use($program_id){
                                    $q->where('program_id',$program_id);
                                    $q->whereNull('deleted_at');
                                })
                                ->WHERE('renja_id', $renja_id )
                                ->WHEREIN('jabatan_id',$child )
                                ->WHERE('cost','>', 0 )
                                ->get();
            foreach( $data AS $y ){
                $item[] = array(
                    'subkegiatan_id'        => $y->id,
                    'subkegiatan_label'     => $y->label,
                    'subkegiatan_cost'      => "Rp. ".number_format($y->cost,'0',',','.'),
                    'pk_status'             => $y->esl3_pk_status,
                );     
            }    
        } 
        return $item; 
    }

    protected function TraitTotalAnggaranSubKegiatanEselon3($skp_tahunan_id){


        $skp_tahunan    = SKPTahunan::WHERE('id',$skp_tahunan_id)->first();
        $jabatan_id     = $skp_tahunan->PegawaiYangDinilai->id_jabatan;
        $renja_id       = $skp_tahunan->Renja->id;
        //cari bawahan nya, karena eselon 3 tidak punya kegiatan tahunan,yang punya nya adalah  bawahan nya
        $child = Jabatan::SELECT('id')->WHERE('parent_id', $jabatan_id )->get()->toArray(); 

        $program = Program::with(['IndikatorProgram','Kegiatan'])
                                ->WhereHas('IndikatorProgram', function($q){
                                    $q->WHERE('pk_status', '1' );
                                    $q->whereNull('deleted_at');
                                })
                                ->WhereHas('Kegiatan', function($q) use($renja_id) {
                                    $q->WHERE('renja_id', $renja_id );
                                    $q->whereNull('deleted_at');
                                })
                                ->GET();

        $total_anggaran = 0 ;
        foreach( $program AS $x ){
            $program_id = $x->id;
            $data = SubKegiatan::with(['Kegiatan'])
                                    ->WhereHas('Kegiatan', function($q) use($program_id){
                                        $q->where('program_id',$program_id);
                                        $q->whereNull('deleted_at');
                                    })
                                    ->WHERE('renja_id', $renja_id )
                                    ->WHEREIN('jabatan_id',$child )
                                    ->WHERE('esl3_pk_status', '1' )
                                    ->get();
            foreach( $data AS $y ){ 
                $total_anggaran = $total_anggaran + $y->cost;
            }    
        } 
                  
        $ta = array(
            'total_anggaran'    => "Rp.   " . number_format( $total_anggaran, '0', ',', '.'),
 
        );
        return $ta;
     }


    protected function TraitSasaranEselon4($skp_tahunan_id){
        $skp_tahunan    = SKPTahunan::WHERE('id',$skp_tahunan_id)->first();
        $jabatan_id     = $skp_tahunan->PegawaiYangDinilai->id_jabatan;
        $renja_id       = $skp_tahunan->Renja->id;



        $subkegitan = SubKegiatan::with(['IndikatorSubKegiatan'])
                                    ->WhereHas('IndikatorSubKegiatan', function($q){
                                        $q->whereNull('deleted_at');
                                    }) 
                                    ->WHERE('renja_id', $renja_id )
                                    ->WHERE('jabatan_id',$jabatan_id )
                                    ->get();

        $item = array();
        foreach( $subkegitan AS $x ){
            foreach( $x->IndikatorSubKegiatan AS $y ){
                $item[] = array(
                    'subkegiatan_id'                => $x->id,
                    'subkegiatan_label'             => $x->label,
                    'pk_status'                     => $x->esl4_pk_status,

                    'indikator_subkegiatan_id'      => $y->id,
                    'indikator_subkegiatan_label'   => $y->label,
                    'target'                        => $y->target.' '.$y->satuan, 
                );
            }       
        }
        return $item; 
    }

    protected function TraitProgramEselon4($skp_tahunan_id){
        
        $skp_tahunan    = SKPTahunan::WHERE('id',$skp_tahunan_id)->first();
        $jabatan_id     = $skp_tahunan->PegawaiYangDinilai->id_jabatan;
        $renja_id       = $skp_tahunan->Renja->id;



        $subkegitan = SubKegiatan::with(['IndikatorSubKegiatan'])
                                    ->WhereHas('IndikatorSubKegiatan', function($q){
                                        $q->whereNull('deleted_at');
                                    }) 
                                    ->WHERE('renja_id', $renja_id )
                                    ->WHERE('jabatan_id',$jabatan_id )
                                    ->WHERE('cost','>',0)
                                    ->WHERE('esl4_pk_status', '1' )
                                    ->get();

        $item = array();
        foreach( $subkegitan AS $x ){
                $item[] = array(
                    'subkegiatan_id'                => $x->id,
                    'subkegiatan_label'             => $x->label,
                    'pk_status'                     => $x->esl4_pk_status,
                    'subkegiatan_cost'              => "Rp. ".number_format( $x->cost, '0', ',', '.'),
                );     
        }
        return $item; 
    }

    protected function TraitTotalAnggaranSubKegiatanEselon4($skp_tahunan_id){
        $skp_tahunan    = SKPTahunan::WHERE('id',$skp_tahunan_id)->first();
        $jabatan_id     = $skp_tahunan->PegawaiYangDinilai->id_jabatan;
        $renja_id       = $skp_tahunan->Renja->id;



        $subkegitan = SubKegiatan::with(['IndikatorSubKegiatan'])
                                    ->WhereHas('IndikatorSubKegiatan', function($q){
                                        $q->whereNull('deleted_at');
                                    }) 
                                    ->WHERE('renja_id', $renja_id )
                                    ->WHERE('jabatan_id',$jabatan_id )
                                    ->WHERE('cost','>',0)
                                    ->WHERE('esl4_pk_status', '1' )
                                    ->get();

        $total_anggaran = 0 ;
        foreach( $subkegitan AS $x ){
                $total_anggaran = $total_anggaran + $x->cost;
   
        } 
                  
        $ta = array(
            'total_anggaran'    => "Rp.   " . number_format( $total_anggaran, '0', ',', '.'),
 
        );
        return $ta;
    }

}