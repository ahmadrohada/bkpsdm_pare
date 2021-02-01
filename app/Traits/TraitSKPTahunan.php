<?php

namespace App\Traits;

use App\Models\CapaianBulanan;
use App\Models\CapaianTahunan;
use App\Models\Jabatan;
use App\Models\RencanaAksi;
use App\Models\RealisasiRencanaAksiKaban;
use App\Models\SubKegiatan;
use App\Models\KegiatanSKPBulanan;
use App\Models\KegiatanSKPTahunan;
use App\Models\KegiatanSKPTahunanJFT;
use App\Models\KegiatanSKPBulananJFT;
use App\Models\UraianTugasTambahan;
use App\Models\RealisasiKegiatanTahunan;
use App\Models\RealisasiKegiatanTahunanJFT;
use App\Models\TugasTambahan;
use App\Models\RealisasiTugasTambahan;
use App\Models\UnsurPenunjangTugasTambahan;
use App\Models\UnsurPenunjangKreativitas;
use App\Models\PerilakuKerja;

use App\Traits\HitungUnsurPenunjang; 

use App\Models\SKPTahunan;

use App\Helpers\Pustaka;

trait TraitSKPTahunan
{
    use PJabatan;

    /* protected function Sumary($skp_tahunan_id){

        $capaian_tahunan = CapaianTahunan::
                            leftjoin('db_pare_2018.realisasi_kegiatan_tahunan AS rkt', function($join){
                                $join   ->on('rkt.skp_tahunan_id','=','capaian_tahunan.id');
                            })
                            ->leftjoin('db_pare_2018.penilaian_perilaku_kerja AS pke', function($join){
                                $join   ->on('pke.capaian_tahunan_id','=','capaian_tahunan.id');
                            })
                            
                            ->SELECT(
                                'capaian_tahunan.id AS capaian_tahunan_id',
                                'capaian_tahunan.skp_tahunan_id AS skp_tahunan_id',
                                'capaian_tahunan.created_at',
                                'capaian_tahunan.tgl_mulai',
                                'capaian_tahunan.tgl_selesai',
                                'capaian_tahunan.status_approve',
                                'capaian_tahunan.send_to_atasan',
                                'capaian_tahunan.alasan_penolakan',
                                'capaian_tahunan.p_jabatan_id',
                                'capaian_tahunan.u_jabatan_id',
                                'pke.id AS penilaian_perilaku_kerja'
                            )
                            ->where('capaian_tahunan.id','=', $skp_tahunan_id )->first();
    
        $x = PerilakuKerja::
                            SELECT( '*') 
                            ->WHERE('penilaian_perilaku_kerja.capaian_tahunan_id', $skp_tahunan_id)
                            ->first();

		if ( $x != null ){
            $pelayanan = ($x->pelayanan_01+$x->pelayanan_02+$x->pelayanan_03)/15 * 100;
            $integritas = ($x->integritas_01+$x->integritas_02+$x->integritas_03+$x->integritas_04)/20*100;
            $komitmen = ($x->komitmen_03+$x->komitmen_03+$x->komitmen_03)/15*100;
            $disiplin = ($x->disiplin_01+$x->disiplin_02+$x->disiplin_03+$x->disiplin_04)/20*100;
            $kerjasama = ($x->kerjasama_01+$x->kerjasama_02+$x->kerjasama_03+$x->kerjasama_04+$x->kerjasama_05)/25*100;
            $kepemimpinan = ($x->kepemimpinan_01+$x->kepemimpinan_02+$x->kepemimpinan_03+$x->kepemimpinan_04+$x->kepemimpinan_05+$x->kepemimpinan_06)/30*100;

            if ( $x->CapaianTahunan->PegawaiYangDinilai->Jabatan->Eselon->id_jenis_jabatan < 4 ){
                $jumlah = $pelayanan+$integritas+$komitmen+$disiplin+$kerjasama+$kepemimpinan;
                $ave    = $jumlah / 6 ;
            }else{
                $jumlah = $pelayanan+$integritas+$komitmen+$disiplin+$kerjasama;
                $ave    = $jumlah / 5 ; 
            }
        }else{
            $ave    = 0 ; 
        }



      
        $p_detail   = $capaian_tahunan->PejabatPenilai;
        $u_detail   = $capaian_tahunan->PegawaiYangDinilai;
        //STATUS APPROVE
        if ( ($capaian_tahunan->send_to_atasan) == 1 ){
            if ( ($capaian_tahunan->status_approve) == 0 ){
                $persetujuan_atasan = 'Menunggu Persetujuan';
                $alasan_penolakan   = "";
            }else if ( ($capaian_tahunan->status_approve) == 1 ){
                $persetujuan_atasan = 'disetujui';
                $alasan_penolakan   = "";
            }else if ( ($capaian_tahunan->status_approve) == 2 ){
                $persetujuan_atasan = 'ditolak';
                $alasan_penolakan   = $capaian_tahunan->alasan_penolakan;
            }else{
                $persetujuan_atasan = '';
                $alasan_penolakan   = "";
            }
        }else{
            $persetujuan_atasan = '';
            $alasan_penolakan   = "";
        }
        

        //KInerja
        $data_kinerja               = $this->hitung_capaian_tahunan($skp_tahunan_id); 
        //return $data_kinerja;

        //kegiatan tahunan
        $jm_capaian_kegiatan_tahunan        = $data_kinerja['jm_capaian_kegiatan_tahunan'];
        $jm_kegiatan_tahunan                = $data_kinerja['jm_kegiatan_tahunan'];
        $ave_capaian_kegiatan_tahunan       = $data_kinerja['ave_capaian_kegiatan_tahunan'];
        //tugas tambahan
        $jm_tugas_tambahan                  = $data_kinerja['jm_tugas_tambahan'];
        $jm_capaian_tugas_tambahan          = $data_kinerja['jm_capaian_tugas_tambahan'];
        $ave_capaian_tugas_tambahan         = $data_kinerja['ave_capaian_tugas_tambahan'];
        //unsur penunjang
        $nilai_unsur_penunjang_tugas_tambahan   = $data_kinerja['nilai_unsur_penunjang_tugas_tambahan'];
        $nilai_unsur_penunjang_kreativitas      = $data_kinerja['nilai_unsur_penunjang_kreativitas'];
        $nilai_unsur_penunjang              = $nilai_unsur_penunjang_tugas_tambahan + $nilai_unsur_penunjang_kreativitas;

        $jm_kegiatan_skp                    = $jm_kegiatan_tahunan + $jm_tugas_tambahan;
        $jm_capaian_kegiatan_skp            = $jm_capaian_kegiatan_tahunan + $jm_capaian_tugas_tambahan;

        //unseu

        $capaian_kinerja_tahunan  = Pustaka::ave($jm_capaian_kegiatan_skp,$jm_kegiatan_skp);
        $capaian_skp              = $capaian_kinerja_tahunan +  $nilai_unsur_penunjang ;

        $nilai_prestasi_kerja = number_format( ($capaian_skp * 60 / 100)+( $ave * 40 / 100 ) , 2 );
        //return $data_kinerja;
        $response = array(
                
                'jm_kegiatan_tahunan'           => $jm_kegiatan_tahunan,  //A
                'jm_tugas_tambahan'             => $jm_tugas_tambahan, //B
                'jm_kegiatan_skp'               => $jm_kegiatan_skp, //A+B

                'jm_capaian_kegiatan_tahunan'   => number_format($jm_capaian_kegiatan_tahunan,2),  //A
                'jm_capaian_tugas_tambahan'     => $jm_capaian_tugas_tambahan, //B
                'jm_capaian_kegiatan_skp'       => $jm_capaian_kegiatan_skp, //A+B

                'nilai_unsur_penunjang'         => $nilai_unsur_penunjang,

               
                'capaian_kinerja_tahunan'       => $capaian_kinerja_tahunan,
                'capaian_skp'                   => $capaian_skp,
                'penilaian_perilaku_kerja'      => Pustaka::persen_bulat($ave),

                'nilai_prestasi_kerja'          => Pustaka::persen_bulat($nilai_prestasi_kerja),


                
                //'capaian_skp_tahunan'         => $capaian_skp_tahunan,
                
                'status_approve'                => $persetujuan_atasan,
                'send_to_atasan'                => $capaian_tahunan->send_to_atasan,
                'alasan_penolakan'              => $alasan_penolakan,
                'skp_tahunan_id'                => $capaian_tahunan->skp_tahunan_id,
                'tgl_dibuat'                    => Pustaka::balik2($capaian_tahunan->created_at),
                'p_nama'                        => Pustaka::nama_pegawai($p_detail->Pegawai->gelardpn , $p_detail->Pegawai->nama , $p_detail->Pegawai->gelarblk),
                'u_nama'                        => Pustaka::nama_pegawai($u_detail->Pegawai->gelardpn , $u_detail->Pegawai->nama , $u_detail->Pegawai->gelarblk),
                
                
                'masa_penilaian'                => Pustaka::balik2($capaian_tahunan->tgl_mulai) .' s.d '.Pustaka::balik2($capaian_tahunan->tgl_selesai) ,


        );
       
        return $response; 
    } */

    //========================= PEJABAT ==========================================//
    protected function Pejabat($skp_tahunan_id){
        $skp_tahunan            = SKPTahunan::WHERE('id',$skp_tahunan_id)->first();
        if ( $skp_tahunan ){
            $u_detail   = $skp_tahunan->PegawaiYangDinilai;
            $p_detail   = $skp_tahunan->PejabatPenilai;  //penilai
            $ap_detail   = $skp_tahunan->AtasanPejabatPenilai;  //atasan pejabat

            //GOLONGAN
            $p_golongan   = $skp_tahunan->GolonganPenilai;
            $ap_golongan  = $skp_tahunan->GolonganAtasanPenilai;
            $u_golongan   = $skp_tahunan->GolonganYangDinilai;

            $h = null ;
        

            $h['u_jabatan_id']	    = $u_detail->id;
            $h['u_nip']	            = $u_detail->nip;
            $h['u_nama']		    = $skp_tahunan->u_nama;
            $h['u_pangkat']	   	    = ($u_golongan ? $u_golongan->Golongan->pangkat : '') .' / '. ($u_golongan ? $u_golongan->Golongan->golongan : '') ;
            $h['u_eselon']	   	    = $u_detail->Eselon ? $u_detail->Eselon->eselon : '';
            $h['u_jabatan']	   	    = Pustaka::capital_string($u_detail->Jabatan ? $u_detail->Jabatan->skpd : '');
            $h['u_unit_kerja']	   	= Pustaka::capital_string($u_detail->UnitKerja ? $u_detail->UnitKerja->unit_kerja : '');
            $h['u_skpd']	   	    = Pustaka::capital_string($u_detail->Skpd ? $u_detail->Skpd->skpd : '');

            //JIKA PENILAI TIDAK NULL
            if ( $p_detail != null ){
                $h['p_jabatan_id']	    = $p_detail->id;
                $h['p_nip']	            = $p_detail->nip;
                $h['p_nama']		    = $skp_tahunan->p_nama;
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
                $h['ap_nama']		    = $skp_tahunan->ap_nama;
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

    /* protected function UnsurPenunjangTugasTambahan($skp_tahunan_id){
        $dt = UnsurPenunjangTugasTambahan::where('capaian_tahunan_id', '=' ,$skp_tahunan_id)
                                            ->select([   
                                                'id AS tugas_tambahan_id',
                                                'label AS tugas_tambahan_label',
                                                'approvement'
                                            ]);

        $data                       =  $dt->get();       
        $count                       =  $dt->WHERE('approvement', '=' , '1' )->count();

        if ( $count < 1){
            $n_nilai = 0;
        }else if ( $count <= 3 ){
            $n_nilai = 1;
        }else if ( $count <= 6 ){
            $n_nilai = 2;
        }else if ( $count >= 7 ){
            $n_nilai = 3;
        }

        $item = array();
        foreach( $data AS $x ){

            $item[] = array(
                'tugas_tambahan_id'         => $x->tugas_tambahan_id,
                'tugas_tambahan_label'      => $x->tugas_tambahan_label,
                'approvement'	            => $x->approvement,
                'tugas_tambahan_nilai'	    => $n_nilai,

					
			);
        }
        
        return $item;
    }

    protected function UnsurPenunjangKreativitas($skp_tahunan_id){
        $data = UnsurPenunjangKreativitas::where('capaian_tahunan_id', '=' ,$skp_tahunan_id )
                                        ->select([   
                                            'id AS kreativitas_id',
                                            'label AS kreativitas_label',
                                            'nilai AS kreativitas_nilai',
                                            'manfaat_id',
                                            'approvement'
                                        ])
                                        ->get();
        $item = array();
        foreach( $data AS $x ){
            switch ($x->manfaat_id) {
                case "3":
                    $manfaat = "Untuk Unit Kerja";
                    break;
                case "6":
                    $manfaat =  "Untuk Organisasi";
                    break;
                case "12":
                    $manfaat =  "Untuk Pemerintah";
                    break;
                default:
                    $manfaat =  "Undefine";
            }

            $item[] = array(
                    'kreativitas_id'            => $x->kreativitas_id,
                    'kreativitas_label'         => $x->kreativitas_label,
                    'approvement'	            => $x->approvement,
                    'manfaat_id'	            => $x->manfaat_id,
                    'kreativitas_nilai'	        => $x->kreativitas_nilai,
                    'action'                    => $x->kreativitas_id,
                    'kreativitas_manfaat'	    => $manfaat,
                                
             );
        }
        return $item;
    }

    protected function TugasTambahan($skp_tahunan_id){


        $dt = TugasTambahan::
                               
                                leftjoin('db_pare_2018.realisasi_tugas_tambahan AS realisasi', function($join){
                                    $join   ->on('realisasi.tugas_tambahan_id','=','skp_tahunan_tugas_tambahan.id');
                                })
                                ->select([   
                                    'skp_tahunan_tugas_tambahan.id AS tugas_tambahan_id',
                                    'skp_tahunan_tugas_tambahan.label AS tugas_tambahan_label',
                                    'skp_tahunan_tugas_tambahan.target AS tugas_tambahan_target',
                                    'skp_tahunan_tugas_tambahan.satuan AS tugas_tambahan_satuan',
                                    'skp_tahunan_tugas_tambahan.label AS tugas_tambahan_label',
                                    'realisasi.id AS realisasi_tugas_tambahan_id',
                                    'realisasi.realisasi',
                                    'realisasi.satuan AS realisasi_satuan'
                                ])
                                ->ORDERBY('skp_tahunan_tugas_tambahan.id','ASC')
                                ->where('skp_tahunan_tugas_tambahan.skp_tahunan_id', '=' ,$skp_tahunan_id)
                                ->get(); 

        $item = array();
        foreach( $dt AS $x ){
                $item[] = array(
                        'tugas_tambahan_id'             => $x->tugas_tambahan_id,
                        'realisasi_tugas_tambahan_id'   => $x->realisasi_tugas_tambahan_id,
                        'tugas_tambahan_label'          => $x->tugas_tambahan_label,
                        'target'                        => $x->tugas_tambahan_target.' '.$x->tugas_tambahan_satuan,
                        'realisasi'                     => $x->realisasi.' '.$x->realisasi_satuan,
                        'persen'                        => Pustaka::persen($x->realisasi,$x->tugas_tambahan_target),


                );
        }
        return $item;
        
    }

    public function NilaiPerilakuKerja($skp_tahunan_id){ 

            $x = PerilakuKerja::WHERE('penilaian_perilaku_kerja.capaian_tahunan_id', $skp_tahunan_id)->first();
    
            if ( $x != null ){
                $pelayanan = ($x->pelayanan_01+$x->pelayanan_02+$x->pelayanan_03)/15 * 100;
                $integritas = ($x->integritas_01+$x->integritas_02+$x->integritas_03+$x->integritas_04)/20*100;
                $komitmen = ($x->komitmen_03+$x->komitmen_03+$x->komitmen_03)/15*100;
                $disiplin = ($x->disiplin_01+$x->disiplin_02+$x->disiplin_03+$x->disiplin_04)/20*100;
                $kerjasama = ($x->kerjasama_01+$x->kerjasama_02+$x->kerjasama_03+$x->kerjasama_04+$x->kerjasama_05)/25*100;
                $kepemimpinan = ($x->kepemimpinan_01+$x->kepemimpinan_02+$x->kepemimpinan_03+$x->kepemimpinan_04+$x->kepemimpinan_05+$x->kepemimpinan_06)/30*100;
    
                if ( $x->CapaianTahunan->PegawaiYangDinilai->Jabatan->Eselon->id_jenis_jabatan < 4 ){
                    $jumlah = $pelayanan+$integritas+$komitmen+$disiplin+$kerjasama+$kepemimpinan;
                    $ave    = $jumlah / 6 ;
                }else{
                    $jumlah = $pelayanan+$integritas+$komitmen+$disiplin+$kerjasama;
                    $ave    = $jumlah / 5 ; 
                }
    
                $pk = array(
                     
                        'pelayanan'         => Pustaka::persen_bulat($pelayanan),
                        'integritas'        => Pustaka::persen_bulat($integritas),
                        'komitmen'          => Pustaka::persen_bulat($komitmen),
                        'disiplin'          => Pustaka::persen_bulat($disiplin),
                        'kerjasama'         => Pustaka::persen_bulat($kerjasama),
                        'kepemimpinan'      => Pustaka::persen_bulat($kepemimpinan), 
    
                        'ket_pelayanan'     => Pustaka::perilaku($pelayanan),
                        'ket_integritas'    => Pustaka::perilaku($integritas),
                        'ket_komitmen'      => Pustaka::perilaku($komitmen),
                        'ket_disiplin'      => Pustaka::perilaku($disiplin),
                        'ket_kerjasama'     => Pustaka::perilaku($kerjasama),
                        'ket_kepemimpinan'  => Pustaka::perilaku($kepemimpinan), 
    
    
                        'jumlah'            => Pustaka::persen_bulat($jumlah), 
                        'rata_rata'         => Pustaka::persen_bulat($ave), 
    
                        'ket_rata_rata'     => Pustaka::perilaku($ave), 
                );
                return $pk;
            }else{
                $pk = array(
    
    
    
    
                        'pelayanan'         => "-",
                        'integritas'        => "-",
                        'komitmen'          => "-",
                        'disiplin'          => "-",
                        'kerjasama'         => "-",
                        'kepemimpinan'      => "-", 
                        'ket_pelayanan'     => "-",
                        'ket_integritas'    => "-",
                        'ket_komitmen'      => "-",
                        'ket_disiplin'      => "-",
                        'ket_kerjasama'     => "-",
                        'ket_kepemimpinan'  => "-",
                        'jumlah'            => "-",
                        'rata_rata'         => "-",
                        'ket_rata_rata'     => "-",
            );
            return $pk;
            }
    
        
    } */

    //========================= KEGIATAN ==========================================//
    protected function Kegiatan($skp_tahunan_id){

        $skp_tahunan            = SKPTahunan::WHERE('id',$skp_tahunan_id)->first();
        $jenis_jabatan          = $skp_tahunan->PegawaiYangDinilai->Eselon->id_jenis_jabatan;

        $jabatan_sekda          = $this->jenis_PJabatan('sekda');
        $jabatan_irban          = $this->jenis_PJabatan('irban');
        $jabatan_lurah          = $this->jenis_PJabatan('lurah');
        $jabatan_staf_ahli      = $this->jenis_PJabatan('staf_ahli');


        //jenis_jeni kegiatan tahunan
        switch($jenis_jabatan)
		{
            case 1 : 
                    $kegiatan_list = $this->Eselon2($skp_tahunan_id);
                    if (in_array( $skp_tahunan->PegawaiYangDinilai->id_jabatan,  json_decode($jabatan_staf_ahli))){ //JIKA STAF AHLI
                        $kegiatan_list = $this->JFT($skp_tahunan_id);
                    }else if (in_array( $skp_tahunan->PegawaiYangDinilai->id_jabatan,  json_decode($jabatan_sekda))){ //JIKA SEKDA
                        $kegiatan_list = "";
                    }else{ //normal kondisi JPT
                        $kegiatan_list = $this->Eselon2($skp_tahunan_id);
                    }
			break;
            case 2 : 
                    if (in_array( $skp_tahunan->PegawaiYangDinilai->id_jabatan, json_decode($jabatan_irban) )){ //JIKA IRBAN
                        $kegiatan_list = $this->Eselon4($skp_tahunan_id);
                    }else{
                        $kegiatan_list = $this->Eselon3($skp_tahunan_id);
                    }
			break;
            case 3 : 
                    if (in_array( $skp_tahunan->PegawaiYangDinilai->id_jabatan,  json_decode($jabatan_lurah))){ //JIKA LURAH
                        $kegiatan_list = $this->Eselon3($skp_tahunan_id);
                    }else{
                        $kegiatan_list = $this->Eselon4($skp_tahunan_id);
                    }
			break;
            case 4 : 
                    $kegiatan_list = $this->JFU($skp_tahunan_id);
            break;
            case 5 :
                    $kegiatan_list = $this->JFT($skp_tahunan_id);
            break;
						
		} 


        return $kegiatan_list; 
       
    }


    
    public function SKPTahunan($skp_tahunan_id){

        $capaian            = SKPTahunan::WHERE('id',$skp_tahunan_id)->first();
   
        $data_final = array(
                    "sumary"                        => $this->Sumary($skp_tahunan_id),
                    "pejabat"                       => $this->Pejabat($skp_tahunan_id),
                    "kegiatan"                      => $this->Kegiatan($skp_tahunan_id),
                    "unsur_penujang_tugas_tambahan" => $this->UnsurPenunjangTugasTambahan($skp_tahunan_id),
                    "unsur_penunjang_kreativitas"   => $this->UnsurPenunjangKreativitas($skp_tahunan_id),
                    "tugas_tambahan"                => $this->TugasTambahan($capaian->skp_tahunan_id),
                    "penilaian_perilaku_kerja"      => $this->NilaiPerilakuKerja($skp_tahunan_id),
           
        );

        return $data_final;

   }







    
   
    public function JFU($skp_tahunan_id){
        
        //Kegiatan tahunan Pelaksana ( JFU ) adalah rencana aksi Eselon 4
        
        $skp_tahunan            = SKPTahunan::WHERE('id',$skp_tahunan_id)->first();
        $jabatan_id             = $skp_tahunan->PegawaiYangDinilai->id_jabatan;
        $renja_id               = $skp_tahunan->Renja->id;


        //KEGIATAN pelaksana
        $kegiatan = RencanaAksi::
                            
                            leftjoin('db_pare_2018.skp_tahunan_indikator_kegiatan AS indikator', function($join){
                                $join   ->on('skp_tahunan_rencana_aksi.indikator_kegiatan_tahunan_id','=','indikator.id') ;
                            })
                            ->leftjoin('db_pare_2018.skp_tahunan_kegiatan AS kegiatan_tahunan', function($join){
                                $join  ->on('indikator.kegiatan_id','=','kegiatan_tahunan.id');
                            })
                            ->WHERE('skp_tahunan_rencana_aksi.jabatan_id',$jabatan_id)
                            ->WHERE('skp_tahunan_rencana_aksi.renja_id',$renja_id)
                            ->SELECT(   'skp_tahunan_rencana_aksi.id AS rencana_aksi_id',
                                        'skp_tahunan_rencana_aksi.label AS kegiatan_skp_tahunan_label',

                                        'kegiatan_tahunan.label AS kegiatan_skp_tahunan_label',
                                        'kegiatan_tahunan.id AS kegiatan_skp_tahunan_id',
                                        'kegiatan_tahunan.angka_kredit',
                                        'kegiatan_tahunan.quality',
                                        'kegiatan_tahunan.cost AS cost',
                                        'kegiatan_tahunan.target_waktu',
                                        'indikator.id AS indikator_kegiatan_skp_tahunan_id',
                                        'indikator.label AS indikator_kegiatan_skp_tahunan_label',
                                        'indikator.target',
                                        'indikator.satuan'

                                    ) 
                            ->groupBy('kegiatan_tahunan.id')
                            /*->orderBY('skp_tahunan_rencana_aksi.label')*/
                            ->distinct() 
                            ->get(); 
        $item = array(); 
        $no = 0 ;
        foreach( $kegiatan AS $x ){
                                         
            //penomoran
            $temp = [];
            if(!isset($arrayForTable[$x['kegiatan_skp_tahunan_id']])){
                $arrayForTable[$x['kegiatan_skp_tahunan_id']] = [];
                $no += 1 ;
            }
        $temp['no']         = $no;
                                                             
            $item[] = array(
                        'no'                                    => $no,
                        'skp_tahunan_id'                        => $skp_tahunan_id,
                        'kegiatan_skp_tahunan_id'	            => $x->kegiatan_skp_tahunan_id,
                        'indikator_kegiatan_skp_tahunan_id'	    => $x->indikator_kegiatan_skp_tahunan_id,
                        'kegiatan_skp_tahunan_label'	        => $x->kegiatan_skp_tahunan_label,
                        'indikator_kegiatan_skp_tahunan_label'	=> $x->indikator_kegiatan_skp_tahunan_label,
                    
                        'penanggung_jawab'	                    => $x->penanggung_jawab,
                                                                             
                        'target_ak'                 => $x->angka_kredit,
                        'target_quality'            => $x->quality." %",
                        'target_quantity'           => $x->target.' '.$x->satuan,
                        'target_waktu'              => $x->target_waktu ." bln",
                        'target_cost'               => "Rp. ". number_format($x->cost,'0',',','.'),
                    );
        }
        return $item; 
             
                
    }

    public function Eselon2($skp_tahunan_id){

        $skp_tahunan            = SKPTahunan::WHERE('id',$skp_tahunan_id)->first();
        $jabatan_id             = $skp_tahunan->PegawaiYangDinilai->id_jabatan;
        $renja_id               = $skp_tahunan->Renja->id;
        $jenis_jabatan          = $skp_tahunan->PegawaiYangDinilai->Eselon->id_jenis_jabatan;

        $child = Jabatan::  
                        leftjoin('demo_asn.m_skpd AS kasubid', function($join){
                            $join   ->on('kasubid.parent_id','=','m_skpd.id');
                        })
                        ->SELECT('kasubid.id')
                        ->WHERE('m_skpd.parent_id', $jabatan_id )
                        ->get()
                        ->toArray(); 

        //return $child;

        //KEGIATAN KABAN

        $kegiatan = SubKegiatan::SELECT('id','label')
                                ->WHERE('renja_subkegiatan.renja_id', $renja_id )
                                ->WHEREIN('renja_subkegiatan.jabatan_id',$child )
                                ->join('db_pare_2018.skp_tahunan_kegiatan AS kegiatan_tahunan', function($join) use ( $skp_tahunan_id ){
                                    $join   ->on('kegiatan_tahunan.subkegiatan_id','=','renja_subkegiatan.id');
                                })
                                ->leftjoin('db_pare_2018.skp_tahunan_indikator_kegiatan AS indikator', function($join){
                                   $join   ->on('indikator.kegiatan_id','=','kegiatan_tahunan.id') ;
                                   $join   ->whereNull('indikator.deleted_at');
                                })
                                ->join('demo_asn.m_skpd AS penanggung_jawab', function($join) use ( $skp_tahunan_id ){
                                    $join   ->on('penanggung_jawab.id','=','renja_subkegiatan.jabatan_id');
                                })
                                ->SELECT(   
                                            'kegiatan_tahunan.label AS kegiatan_skp_tahunan_label',
                                            'kegiatan_tahunan.id AS kegiatan_skp_tahunan_id',
                                            //'kegiatan_tahunan.target',
                                            //'kegiatan_tahunan.satuan',
                                            'kegiatan_tahunan.angka_kredit',
                                            'kegiatan_tahunan.quality',
                                            'kegiatan_tahunan.cost AS cost',
                                            'kegiatan_tahunan.target_waktu',
                                            'indikator.id AS indikator_kegiatan_skp_tahunan_id',
                                            'indikator.label AS indikator_kegiatan_skp_tahunan_label',
                                            'indikator.target',
                                            'indikator.satuan',
                                            'penanggung_jawab.skpd AS penanggung_jawab'
                                        ) 
                                ->get();


        $item = array(); 
        $no = 0 ;
        foreach( $kegiatan AS $x ){
            //penomoran
            $temp = [];
            if(!isset($arrayForTable[$x['kegiatan_skp_tahunan_id']])){
                $arrayForTable[$x['kegiatan_skp_tahunan_id']] = [];
                $no += 1 ;
            }
            $temp['no']         = $no;
                                                                 
            $item[] = array(
                        'no'                                    => $no,
                        'skp_tahunan_id'                        => $skp_tahunan_id,
                        'kegiatan_skp_tahunan_id'	            => $x->kegiatan_skp_tahunan_id,
                        'indikator_kegiatan_skp_tahunan_id'	    => $x->indikator_kegiatan_skp_tahunan_id,
                        'kegiatan_skp_tahunan_label'	        => $x->kegiatan_skp_tahunan_label,
                        'indikator_kegiatan_skp_tahunan_label'	=> $x->indikator_kegiatan_skp_tahunan_label,
                        
                        'penanggung_jawab'	                    => $x->penanggung_jawab,
                                                                                 
                        'target_ak'                 => $x->angka_kredit,
                        'target_quality'            => $x->quality." %",
                        'target_quantity'           => $x->target.' '.$x->satuan,
                        'target_waktu'              => $x->target_waktu ." bln",
                        'target_cost'               => "Rp. ". number_format($x->cost,'0',',','.'),
            );
        }
        return $item; 
    }

    public function Eselon3($skp_tahunan_id){

        $skp_tahunan            = SKPTahunan::WHERE('id',$skp_tahunan_id)->first();
        $jabatan_id             = $skp_tahunan->PegawaiYangDinilai->id_jabatan;
        $renja_id               = $skp_tahunan->Renja->id;
        $jenis_jabatan          = $skp_tahunan->PegawaiYangDinilai->Eselon->id_jenis_jabatan;

        $child = Jabatan::SELECT('id')->WHERE('parent_id', $jabatan_id )->get()->toArray(); 

        //KEGIATAN KABID
        $kegiatan = SubKegiatan::SELECT('id','label')
                            ->WHERE('renja_subkegiatan.renja_id', $renja_id )
                            ->WHEREIN('renja_subkegiatan.jabatan_id',$child )
                            ->join('db_pare_2018.skp_tahunan_kegiatan AS kegiatan_tahunan', function($join) use ( $skp_tahunan_id ){
                                 $join   ->on('kegiatan_tahunan.subkegiatan_id','=','renja_subkegiatan.id');
                            })
                            ->leftjoin('db_pare_2018.skp_tahunan_indikator_kegiatan AS indikator', function($join){
                                $join   ->on('indikator.kegiatan_id','=','kegiatan_tahunan.id') ;
                                $join   ->whereNull('indikator.deleted_at');
                            })
                             ->join('demo_asn.m_skpd AS penanggung_jawab', function($join) use ( $skp_tahunan_id ){
                                 $join   ->on('penanggung_jawab.id','=','renja_subkegiatan.jabatan_id');
                             })
                             ->SELECT(   
                                         'kegiatan_tahunan.label AS kegiatan_skp_tahunan_label',
                                         'kegiatan_tahunan.id AS kegiatan_skp_tahunan_id',
                                         //'kegiatan_tahunan.target',
                                         //'kegiatan_tahunan.satuan',
                                         'kegiatan_tahunan.angka_kredit',
                                         'kegiatan_tahunan.quality',
                                         'kegiatan_tahunan.cost AS cost',
                                         'kegiatan_tahunan.target_waktu',
                                         'indikator.id AS indikator_kegiatan_skp_tahunan_id',
                                         'indikator.label AS indikator_kegiatan_skp_tahunan_label',
                                         'indikator.target',
                                         'indikator.satuan',
                                         'penanggung_jawab.skpd AS penanggung_jawab'
                                     ) 
                             ->get();
                             
        $item = array(); 
        $no = 0 ;
        foreach( $kegiatan AS $x ){
                     
            //penomoran
            $temp = [];
            if(!isset($arrayForTable[$x['kegiatan_skp_tahunan_id']])){
                $arrayForTable[$x['kegiatan_skp_tahunan_id']] = [];
                $no += 1 ;
            }
            $temp['no']         = $no;
                                         
            $item[] = array(
                    'no'                                    => $no,
                    'skp_tahunan_id'                        => $skp_tahunan_id,
                    'kegiatan_skp_tahunan_id'	            => $x->kegiatan_skp_tahunan_id,
                    'indikator_kegiatan_skp_tahunan_id'	    => $x->indikator_kegiatan_skp_tahunan_id,
                    'kegiatan_skp_tahunan_label'	        => $x->kegiatan_skp_tahunan_label,
                    'indikator_kegiatan_skp_tahunan_label'	=> $x->indikator_kegiatan_skp_tahunan_label,

                    'penanggung_jawab'	                    => $x->penanggung_jawab,
                                                         
                    'target_ak'                 => $x->angka_kredit,
                    'target_quality'            => $x->quality." %",
                    'target_quantity'           => $x->target.' '.$x->satuan,
                    'target_waktu'              => $x->target_waktu ." bln",
                    'target_cost'               => "Rp. ". number_format($x->cost,'0',',','.'),
            );
        }
        return $item; 
                 
    
    }


    public function Eselon4($skp_tahunan_id){
        //KEGIATAN KASUBID
        $kegiatan = KegiatanSKPTahunan::
                            leftjoin('db_pare_2018.skp_tahunan_indikator_kegiatan AS indikator', function($join){
                                $join   ->on('indikator.kegiatan_id','=','skp_tahunan_kegiatan.id') ;
                                $join   ->whereNull('indikator.deleted_at');
                            })
                            ->SELECT(   'skp_tahunan_kegiatan.id AS kegiatan_skp_tahunan_id',
                                        'skp_tahunan_kegiatan.subkegiatan_id',
                                        'skp_tahunan_kegiatan.label AS kegiatan_skp_tahunan_label',
                                        'skp_tahunan_kegiatan.angka_kredit',
                                        'skp_tahunan_kegiatan.quality',
                                        'skp_tahunan_kegiatan.cost',
                                        'skp_tahunan_kegiatan.target_waktu',

                                        'indikator.id AS indikator_kegiatan_skp_tahunan_id',
                                        'indikator.label AS indikator_kegiatan_skp_tahunan_label',
                                        'indikator.target',
                                        'indikator.satuan'
                                    ) 
                            ->WHERE('skp_tahunan_kegiatan.skp_tahunan_id',$skp_tahunan_id)
                            ->ORDERBY('skp_tahunan_kegiatan.id','ASC')
                            ->get();

                 
                
      
        $item = array(); 
        $no = 0 ;
        foreach( $kegiatan AS $x ){

            //penomoran
            $temp = [];
            if(!isset($arrayForTable[$x['kegiatan_skp_tahunan_id']])){
                $arrayForTable[$x['kegiatan_skp_tahunan_id']] = [];
                $no += 1 ;
            }
            $temp['no']         = $no;
                    
            $item[] = array(
                        'no'                                    => $no,
                        'skp_tahunan_id'                        => $skp_tahunan_id,
                        'subkegiatan_id'                        => $x->subkegiatan_id,
                        'kegiatan_skp_tahunan_id'	            => $x->kegiatan_skp_tahunan_id,
                        'indikator_kegiatan_skp_tahunan_id'	    => $x->indikator_kegiatan_skp_tahunan_id,
                        'kegiatan_skp_tahunan_label'	        => $x->kegiatan_skp_tahunan_label,
                        'indikator_kegiatan_skp_tahunan_label'	=> $x->indikator_kegiatan_skp_tahunan_label,
                                    
                    
                        'target_ak'                 => $x->angka_kredit,
                        'target_quality'            => $x->quality." %",
                        'target_quantity'           => $x->target.' '.$x->satuan,
                        'target_waktu'              => $x->target_waktu ." bln",
                        'target_cost'               => "Rp. ". number_format($x->cost,'0',',','.'),
                                                      
                    );
        }
        return $item;
    }


    public function JFT($skp_tahunan_id){}
 
}