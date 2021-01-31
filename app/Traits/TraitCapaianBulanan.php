<?php

namespace App\Traits;

use App\Models\CapaianBulanan;
use App\Models\KodeEtik;

use App\Helpers\Pustaka;

trait TraitCapaianBulanan
{
    use PJabatan;

    

    //========================= PEJABAT ==========================================//
    protected function Pejabat($capaian_bulanan_id){
        $capaian_bulanan            = CapaianBulanan::WHERE('id',$capaian_bulanan_id)->first();
        if ( $capaian_bulanan ){
            $u_detail   = $capaian_bulanan->PegawaiYangDinilai;
            $p_detail   = $capaian_bulanan->PejabatPenilai;  //penilai
            $ap_detail  = $capaian_bulanan->AtasanPejabatPenilai;  //atasan pejabat

            //GOLONGAN
            $p_golongan   = $capaian_bulanan->GolonganPenilai;
            $ap_golongan  = $capaian_bulanan->GolonganAtasanPenilai;
            $u_golongan   = $capaian_bulanan->GolonganYangDinilai;

            $h = null ;
        

            $h['u_jabatan_id']	    = $u_detail->id;
            $h['u_nip']	            = $u_detail->nip;
            $h['u_nama']		    = $capaian_bulanan->u_nama;
            $h['u_pangkat']	   	    = ($u_golongan ? $u_golongan->Golongan->pangkat : '') .' / '. ($u_golongan ? $u_golongan->Golongan->golongan : '') ;
            $h['u_eselon']	   	    = $u_detail->Eselon ? $u_detail->Eselon->eselon : '';
            $h['u_jabatan']	   	    = Pustaka::capital_string($u_detail->Jabatan ? $u_detail->Jabatan->skpd : '');
            $h['u_unit_kerja']	   	= Pustaka::capital_string($u_detail->UnitKerja ? $u_detail->UnitKerja->unit_kerja : '');
            $h['u_skpd']	   	    = Pustaka::capital_string($u_detail->Skpd ? $u_detail->Skpd->skpd : '');

            //JIKA PENILAI TIDAK NULL
            if ( $p_detail != null ){
                $h['p_jabatan_id']	    = $p_detail->id;
                $h['p_nip']	            = $p_detail->nip;
                $h['p_nama']		    = $capaian_bulanan->p_nama;
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
                $h['ap_nama']		    = $capaian_bulanan->ap_nama;
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


    public function NilaiKodeEtik($capaian_id){ 

        
        $x = KodeEtik::WHERE('capaian_bulanan_id', $capaian_id)->first();
       
        if ( $x != null ){
            $kode_etik = array(
                'penilaian_kode_etik_id'    => $x->id,
                'santun'                    => ($x->santun*20).' %',
                'amanah'                    => ($x->amanah*20).' %',
                'harmonis'                  => ($x->harmonis*20).' %',
                'adaptif'                   => ($x->adaptif*20).' %',
                'terbuka'                   => ($x->terbuka*20).' %',
                'efektif'                   => ($x->efektif*20).' %',
            );

        }else{
            $kode_etik = array(
                'penilaian_kode_etik_id'    => null,
                'santun'                    => "-",
                'amanah'                    => "-",
                'harmonis'                  => "-",
                'adaptif'                   => "-",
                'terbuka'                   => "-",
                'efektif'                   => "-",
        );

        }
        return $kode_etik; 
    
    }
 
}