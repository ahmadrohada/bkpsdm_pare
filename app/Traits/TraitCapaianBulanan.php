<?php

namespace App\Traits;

use App\Models\CapaianBulanan;
use App\Models\SKPTahunan;
use App\Models\SKPBulanan;
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
 

    public function CapaianBulananDetail($pegawai_id,$periode_id,$bulan){

       
        
        $data = SKPTahunan::WITH(['Renja'])
                            ->WhereHas('Renja', function($s) use($periode_id){
                                    $s->WHERE('periode_id',$periode_id);
                            })
                            ->join('db_pare_2018.skp_bulanan AS skp_bulanan', function ($join) use($bulan){
                                $join   ->on('skp_bulanan.skp_tahunan_id', '=', 'skp_tahunan.id') 
                                        ->where('skp_bulanan.bulan', '=', $bulan) ;
                            })
                            ->join('db_pare_2018.capaian_bulanan AS capaian_bulanan', function ($join) {
                                $join   ->on('capaian_bulanan.skp_bulanan_id', '=', 'skp_bulanan.id')
                                        ->where('capaian_bulanan.status_approve', '=', 1   );
                            })
                            ->join('db_pare_2018.penilaian_kode_etik AS pke', function($join){
                                $join   ->on('pke.capaian_bulanan_id','=','capaian_bulanan.id');
                            })
                            ->where('skp_tahunan.pegawai_id',$pegawai_id)
                            ->SELECT(   'skp_bulanan.id AS skp_bulanan_id',
                                        'capaian_bulanan.id AS capaian_bulanan_id',
                                        'pke.id AS penilaian_kode_etik_id',
                                        'pke.santun',
                                        'pke.amanah',
                                        'pke.harmonis',
                                        'pke.adaptif',
                                        'pke.terbuka',
                                        'pke.efektif'
                            
                        )
                        ->first();
        
        if( $data ) {
            //$data = $data->first();

            //HITUNG CAPAIAN KINERJA
            $data_kinerja               = $this->hitung_capaian($data->capaian_bulanan_id); 
            $jm_capaian                 = $data_kinerja['jm_capaian'];
            $jm_kegiatan_bulanan        = $data_kinerja['jm_kegiatan_bulanan'];

            $capaian_kinerja_bulanan  = Pustaka::persen2($jm_capaian,$jm_kegiatan_bulanan);


            //HITUNG PENILAIAN KODE ETIK
            if ( ($data->penilaian_kode_etik_id) >= 1 ){
                $jm = ($data->santun + $data->amanah + $data->harmonis+$data->adaptif+$data->terbuka+$data->efektif);
   
                $penilaian_kode_etik = Pustaka::persen($jm,30) ;
                $cap_skp = number_format( ($capaian_kinerja_bulanan * 70 / 100)+( $penilaian_kode_etik * 30 / 100 ) , 2 );
            }else{
                $penilaian_kode_etik = 0 ;
                $cap_skp = 0 ;
            } 

            if ( $cap_skp >= 85 ){
                $skor_cap = 100 ;
            }else if ( $cap_skp < 50 ){
                $skor_cap = 0 ;
            }else{
                $skor_cap	= number_format( (50 + (1.43*($cap_skp-50))),2 );
            }
                $capaian_bulanan_id = $data->capaian_bulanan_id;

        }else{
            $cap_skp  = 0 ;
            $skor_cap = 0 ;
            $capaian_bulanan_id = null ;
        }

        $data = array(
            'cap_skp'           => $cap_skp,
            'skor_cap'          => $skor_cap,
            'capaian_bulanan_id'=> $capaian_bulanan_id,
        ); 
        return $data;


    }
}