<?php

namespace App\Traits;

use App\Models\CapaianBulanan;
use App\Models\Jabatan;
use App\Models\RencanaAksi;
use App\Models\KegiatanSKPBulanan;
use App\Models\SKPD;
use App\Models\SKPBulanan;

use App\Helpers\Pustaka;

trait TraitSKPBulanan
{
    use PJabatan;

    

    //========================= PEJABAT ==========================================//
    protected function Pejabat($skp_bulanan_id){
        $skp_bulanan            = SKPBulanan::WHERE('id',$skp_bulanan_id)->first();
        if ( $skp_bulanan ){
            $u_detail   = $skp_bulanan->PegawaiYangDinilai;
            $p_detail   = $skp_bulanan->PejabatPenilai;  //penilai
            $ap_detail  = $skp_bulanan->AtasanPejabatPenilai;  //atasan pejabat

            //GOLONGAN
            $p_golongan   = $skp_bulanan->GolonganPenilai;
            $ap_golongan  = $skp_bulanan->GolonganAtasanPenilai;
            $u_golongan   = $skp_bulanan->GolonganYangDinilai;

            $h = null ;
        

            $h['u_jabatan_id']	    = $u_detail->id;
            $h['u_nip']	            = $u_detail->nip;
            $h['u_nama']		    = $skp_bulanan->u_nama;
            $h['u_pangkat']	   	    = ($u_golongan ? $u_golongan->Golongan->pangkat : '') .' / '. ($u_golongan ? $u_golongan->Golongan->golongan : '') ;
            $h['u_eselon']	   	    = $u_detail->Eselon ? $u_detail->Eselon->eselon : '';
            $h['u_jabatan']	   	    = Pustaka::capital_string($u_detail->Jabatan ? $u_detail->Jabatan->skpd : '');
            $h['u_unit_kerja']	   	= Pustaka::capital_string($u_detail->UnitKerja ? $u_detail->UnitKerja->unit_kerja : '');
            $h['u_skpd']	   	    = Pustaka::capital_string($u_detail->Skpd ? $u_detail->Skpd->skpd : '');

            //JIKA PENILAI TIDAK NULL
            if ( $p_detail != null ){
                $h['p_jabatan_id']	    = $p_detail->id;
                $h['p_nip']	            = $p_detail->nip;
                $h['p_nama']		    = $skp_bulanan->p_nama;
                $h['p_pangkat']	   	    = ($p_golongan ? $p_golongan->Golongan->pangkat : '') .' / '. ($p_golongan ? $p_golongan->Golongan->golongan : '') ;
                $h['p_eselon']	   	    = $p_detail->Eselon ? $p_detail->Eselon->eselon : '';
                $h['p_jabatan']	   	    = Pustaka::capital_string($p_detail->Jabatan ? $p_detail->Jabatan->skpd : '');
                $h['p_unit_kerja']	   	= Pustaka::capital_string($p_detail->unitKerja ? $p_detail->unitKerja->unit_kerja : '');
                $h['p_skpd']	   	    = Pustaka::capital_string($p_detail->Skpd ? $p_detail->Skpd->skpd : '');
            }

            //JIKA ATASAN PENILAI TIDAK NULL
            if ( $ap_detail != null ){
                $h['ap_jabatan_id']	    = $ap_detail->id;
                $h['ap_nip']	        = $ap_detail->nip;
                $h['ap_nama']		    = $skp_bulanan->ap_nama;
                $h['ap_pangkat']	   	= ($ap_golongan ? $ap_golongan->Golongan->pangkat : '') .' / '. ($ap_golongan ? $ap_golongan->Golongan->golongan : '') ;
                $h['ap_eselon']	   	    = $ap_detail->Eselon ? $ap_detail->Eselon->eselon : '';
                $h['ap_jabatan']	   	= Pustaka::capital_string($ap_detail->Jabatan ? $ap_detail->Jabatan->skpd : '');
                $h['ap_unit_kerja']	   	= Pustaka::capital_string($ap_detail->unitKerja ? $ap_detail->unitKerja->unit_kerja : '');
                $h['ap_skpd']	   	    = Pustaka::capital_string($ap_detail->Skpd ? $ap_detail->Skpd->skpd : '');
            }else{
                $h['ap_jabatan_id']	    = "";
                $h['ap_nip']	        = "";
                $h['ap_nama']		    = "";
                $h['ap_pangkat']	   	= "";
                $h['ap_eselon']	   	    = "";
                $h['ap_jabatan']	   	= "";
                $h['ap_unit_kerja']	   	= "";
                $h['ap_skpd']	   	    = "";
            }
            

            return $h;
        }else{
            return null;
        }
    }


    protected function TraitKegiatanBulananEselon4($skp_bulanan_id){

        $skp_bulanan    = SKPBulanan::WHERE('id',$skp_bulanan_id)->first();
        $jabatan_id     = $skp_bulanan->PegawaiYangDinilai->id_jabatan;
        $renja_id       = $skp_bulanan->SKPTahunan->Renja->id;

        $skp_bln = SKPBulanan::WHERE('id',$skp_bulanan->id)->SELECT('bulan','status')->first();
       
        //id eselon
        //1 : I.a 2 : II.a 3 : II.b 4 : III.a  5 : III.b  6 : IV.a  7 : IV.b  8 : V.a  9 : JFU  10: JFT
        
        //cari bawahan  , jabatanpelaksanan atau jabatan sendiri ( untuk keg yang dilaksanakan sendiri)
        $child = Jabatan::SELECT('id')->WHERE('parent_id',  $jabatan_id  )->ORWHERE('id',  $jabatan_id )->get()->toArray(); 
    
        /* $rencana_aksi = RencanaAksi::with(['KegiatanBulanan','IndikatorKegiatanSKPTahunan'])
                                    ->WhereHas('IndikatorKegiatanSKPTahunan', function($q) use($renja_id){
                                        $q->with(['KegiatanSKPTahunan'])
                                        ->WhereHas('KegiatanSKPTahunan', function($r) use($renja_id){
                                            $r->with(['SubKegiatan']);
                                            $r->WHERE('renja_id',$renja_id);
                                        });
                                    }) 
                                    ->WHEREIN('jabatan_id',$child )
                                    ->WHERE('waktu_pelaksanaan',$skp_bln->bulan)
                                    ->get();
 

        $item = array();
        foreach( $rencana_aksi AS $x ){
          
                 $item[] = array(
                    'id'                            => $x->id,
                    'label'                         => $x->label,
                    'target'                        => $x->target.' '.$x->satuan,
                    'pelaksana'                     => SKPD::WHERE('id',$x->jabatan_id)->firstOrFail()->skpd,
                );
          
        }
        
        return $item;  */
        $rencana_aksi = RencanaAksi::
                    WHEREIN('skp_tahunan_rencana_aksi.jabatan_id',$child )
                    ->WHERE('skp_tahunan_rencana_aksi.renja_id',$renja_id )
                    ->WHERE('skp_tahunan_rencana_aksi.waktu_pelaksanaan',$skp_bln->bulan)
                    ->leftjoin('db_pare_2018.skp_bulanan_kegiatan AS kegiatan_bulanan', function($join){
                        $join   ->on('kegiatan_bulanan.rencana_aksi_id','=','skp_tahunan_rencana_aksi.id');
                        //$join   ->WHERE('kegiatan_bulanan.skp_tahunan_id','=', $skp_tahunan_id );
                    })
                    ->leftjoin('db_pare_2018.skp_tahunan_kegiatan AS kegiatan_tahunan', function($join){
                        $join   ->on('kegiatan_tahunan.id','=','skp_tahunan_rencana_aksi.kegiatan_tahunan_id');
                        //$join   ->WHERE('kegiatan_bulanan.skp_tahunan_id','=', $skp_tahunan_id );
                    })
                    ->SELECT(   'skp_tahunan_rencana_aksi.id AS rencana_aksi_id',
                                'skp_tahunan_rencana_aksi.label AS rencana_aksi_label',
                                'skp_tahunan_rencana_aksi.target AS rencana_aksi_target',
                                'skp_tahunan_rencana_aksi.satuan AS rencana_aksi_satuan',
                                'skp_tahunan_rencana_aksi.jabatan_id AS pelaksana_id',
                                'kegiatan_bulanan.label AS kegiatan_bulanan_label',
                                'kegiatan_bulanan.id AS kegiatan_bulanan_id',
                                'kegiatan_bulanan.target AS target_pelaksana',
                                'kegiatan_bulanan.satuan AS satuan_pelaksana'
                            ) 
                    ->GROUPBY('skp_tahunan_rencana_aksi.id')
                    ->get(); 
        
      return $rencana_aksi; 
    }

 
}