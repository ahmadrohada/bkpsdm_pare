<?php

namespace App\Traits;

use App\Models\CapaianBulanan;
use App\Models\CapaianTahunan;
use App\Models\Jabatan;
use App\Models\RencanaAksi;
use App\Models\RealisasiRencanaAksiKaban;
use App\Models\Kegiatan;
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

use App\Helpers\Pustaka;

trait TraitCapaianTahunan
{


    //========================= PEJABAT ==========================================//
    protected function Pejabat($capaian_id){
        $capaian            = CapaianTahunan::WHERE('id',$capaian_id)->first();
        if ( $capaian ){
            $u_detail   = $capaian->PegawaiYangDinilai;
            $p_detail   = $capaian->PejabatPenilai;  //penilai
            $ap_detail   = $capaian->AtasanPejabatPenilai;  //atasan pejabat

            //GOLONGAN
            $p_golongan   = $capaian->GolonganPenilai;
            $ap_golongan  = $capaian->GolonganAtasanPenilai;
            $u_golongan   = $capaian->GolonganYangDinilai;

            $h = null ;
        

            $h['u_jabatan_id']	    = $u_detail->id;
            $h['u_nip']	            = $u_detail->nip;
            $h['u_nama']		    = $capaian->u_nama;
            $h['u_pangkat']	   	    = ($u_golongan ? $u_golongan->Golongan->pangkat : '') .' / '. ($u_golongan ? $u_golongan->Golongan->golongan : '') ;
            $h['u_eselon']	   	    = $u_detail->Eselon ? $u_detail->Eselon->eselon : '';
            $h['u_jabatan']	   	    = Pustaka::capital_string($u_detail->Jabatan ? $u_detail->Jabatan->skpd : '');
            $h['u_unit_kerja']	   	= Pustaka::capital_string($u_detail->UnitKerja ? $u_detail->UnitKerja->unit_kerja : '');
            $h['u_skpd']	   	    = Pustaka::capital_string($u_detail->Skpd ? $u_detail->Skpd->skpd : '');

            //JIKA PENILAI TIDAK NULL
            if ( $p_detail != null ){
                $h['p_jabatan_id']	    = $p_detail->id;
                $h['p_nip']	            = $p_detail->nip;
                $h['p_nama']		    = $capaian->p_nama;
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
                $h['ap_nama']		    = $capaian->ap_nama;
                $h['ap_pangkat']	   	= ($ap_golongan ? $ap_golongan->Golongan->pangkat : '') .' / '. ($ap_golongan ? $ap_golongan->Golongan->golongan : '') ;
                $h['ap_eselon']	   	    = $ap_detail->Eselon ? $ap_detail->Eselon->eselon : '';
                $h['ap_jabatan']	   	= Pustaka::capital_string($ap_detail->Jabatan ? $ap_detail->Jabatan->skpd : '');
                $h['ap_unit_kerja']	   	= Pustaka::capital_string($ap_detail->unitKerja ? $ap_detail->unitKerja->unit_kerja : '');
                $h['ap_skpd']	   	    = Pustaka::capital_string($ap_detail->Skpd ? $ap_detail->Skpd->skpd : '');
            }
            

            return $h;
        }else{
            return null;
        }
    }

    protected function UnsurPenunjangTugasTambahan($capaian_id){
        $dt = UnsurPenunjangTugasTambahan::where('capaian_tahunan_id', '=' ,$capaian_id)
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

    protected function UnsurPenunjangKreativitas($capaian_id){
        $data = UnsurPenunjangKreativitas::where('capaian_tahunan_id', '=' ,$capaian_id )
                                        ->select([   
                                            'id AS kreativitas_id',
                                            'label AS kreativitas_label',
                                            'nilai AS kreativitas_nilai',
                                            'manfaat_id',
                                            'approvement'
                                        ])
                                        ->get();
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

    protected function TugasTambahan($capaian_id){
        
    }

    public function NilaiPerilakuKerja($capaian_id){ 

            $x = PerilakuKerja::WHERE('penilaian_perilaku_kerja.capaian_tahunan_id', $capaian_id)->first();
    
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
    
    
    
    
                        'pelayanan'     => "-",
                        'integritas'    => "-",
                        'komitmen'      => "-",
                        'disiplin'      => "-",
                        'kerjasama'     => "-",
                        'kepemimpinan'  => "-", 
                        'jumlah'        => "-",
                        'rata_rata'     => "-",
            );
            return $pk;
            }
    
        
    }

    //========================= KEGIATAN ==========================================//
    protected function Kegiatan($capaian_id){

        $capaian            = CapaianTahunan::WHERE('id',$capaian_id)->first();
        $jenis_jabatan      = $capaian->PegawaiYangDinilai->Eselon->id_jenis_jabatan;


        switch($jenis_jabatan)
		{
            case 1 : 
                    $kegiatan_list = $this->Eselon2($capaian_id);
			break;
            case 2 : 
                    $kegiatan_list = $this->Eselon3($capaian_id);
			break;
            case 3 : 
                    $kegiatan_list = $this->Eselon4($capaian_id);
			break;
            case 4 : 
                    $kegiatan_list = $this->JFU($capaian_id);
			break;
						
		} 


        return $kegiatan_list;
       
    }




    public function CapaianTahunan($capaian_id){

   
        $data_final = array(
                    "sumary"                        => null,
                    "pejabat"                       => $this->Pejabat($capaian_id),
                    "kegiatan"                      => $this->Kegiatan($capaian_id),
                    "unsur_penujang_tugas_tambahan" => $this->UnsurPenunjangTugasTambahan($capaian_id),
                    "unsur_penunjang_kreativitas"   => $this->UnsurPenunjangKreativitas($capaian_id),
                    "tugas_tambahan"                => $this->TugasTambahan($capaian_id),
                    "penilaian_perilaku_kerja"      => $this->NilaiPerilakuKerja($capaian_id),
           
        );

        return $data_final;

   }
















    
   
    public function JFU($capaian_id){


        $data       = CapaianTahunan::WHERE('id',$capaian_id)->first();
        $renja_id   = $data->SKPTahunan->renja_id;    
        $jabatan_id = $data->PegawaiYangDinilai->id_jabatan;

        $rencana_aksi = RencanaAksi::WHERE('skp_tahunan_rencana_aksi.jabatan_id',$jabatan_id)
                            ->LEFTJOIN('db_pare_2018.skp_tahunan_kegiatan AS kegiatan_tahunan', function($join){
                                $join  ->ON('skp_tahunan_rencana_aksi.kegiatan_tahunan_id','=','kegiatan_tahunan.id');
                            })
                            //LEFT JOIN ke KEGIATAN RENJA
                            ->leftjoin('db_pare_2018.renja_kegiatan AS renja_kegiatan', function($join){
                                $join   ->on('renja_kegiatan.id','=','kegiatan_tahunan.kegiatan_id');
                                
                            })
                            //LEFT JOIN ke INDIKATOR KEGIATAN
                            ->LEFTJOIN('db_pare_2018.renja_indikator_kegiatan AS indikator_kegiatan', function($join){
                                $join   ->on('indikator_kegiatan.kegiatan_id','=','kegiatan_tahunan.kegiatan_id');
                                
                            })
                            //LEFT JOIN TERHADAP REALISASI INDIKATOR KEGIATAN
                            ->leftjoin('db_pare_2018.realisasi_indikator_kegiatan_tahunan AS realisasi_indikator', function($join) use ( $capaian_id ){
                                $join   ->on('realisasi_indikator.indikator_kegiatan_id','=','indikator_kegiatan.id');
                                $join   ->WHERE('realisasi_indikator.capaian_id','=',  $capaian_id );
                                
                            })
                            //LEFT JOIN TERHADAP REALISASI TAHUNAN tahunan
                            ->leftjoin('db_pare_2018.realisasi_kegiatan_tahunan AS realisasi_kegiatan', function($join) use ( $capaian_id ){
                                $join   ->on('realisasi_kegiatan.kegiatan_tahunan_id','=','kegiatan_tahunan.id');
                                $join   ->WHERE('realisasi_kegiatan.capaian_id','=',  $capaian_id );
                                
                            })
                            //LEFT JOIN KE CAPAIAN TAHUNAN
                            ->leftjoin('db_pare_2018.capaian_tahunan AS capaian_tahunan', function($join){
                                $join   ->on('capaian_tahunan.id','=','realisasi_kegiatan.capaian_id');
                            })
                            ->SELECT(   'renja_kegiatan.id AS kegiatan_id',
                                        'kegiatan_tahunan.label AS kegiatan_tahunan_label',
                                        'kegiatan_tahunan.id AS kegiatan_tahunan_id',
                                        'kegiatan_tahunan.target AS kegiatan_tahunan_target',
                                        'kegiatan_tahunan.satuan AS kegiatan_tahunan_satuan',
                                        'kegiatan_tahunan.angka_kredit AS kegiatan_tahunan_ak',
                                        'kegiatan_tahunan.quality AS kegiatan_tahunan_quality',
                                        'kegiatan_tahunan.cost AS kegiatan_tahunan_cost',
                                        'kegiatan_tahunan.target_waktu AS kegiatan_tahunan_target_waktu',

                                        'indikator_kegiatan.id AS indikator_kegiatan_id',
                                        'indikator_kegiatan.label AS indikator_kegiatan_label',
                                        'indikator_kegiatan.target AS indikator_kegiatan_target',
                                        'indikator_kegiatan.satuan AS indikator_kegiatan_satuan',

                                        'realisasi_indikator.id AS realisasi_indikator_id',
                                        'realisasi_indikator.target_quantity AS realisasi_indikator_target_quantity',
                                        'realisasi_indikator.realisasi_quantity AS realisasi_indikator_realisasi',
                                        'realisasi_indikator.satuan AS realisasi_indikator_satuan',

                                        'realisasi_kegiatan.id AS realisasi_kegiatan_id',
                                        'realisasi_kegiatan.target_angka_kredit AS realisasi_kegiatan_target_ak',
                                        'realisasi_kegiatan.target_quality AS realisasi_kegiatan_target_quality',
                                        'realisasi_kegiatan.target_cost AS realisasi_kegiatan_target_cost',
                                        'realisasi_kegiatan.target_waktu AS realisasi_kegiatan_target_waktu',
                                        'realisasi_kegiatan.realisasi_angka_kredit AS realisasi_kegiatan_realisasi_ak',
                                        'realisasi_kegiatan.realisasi_quality AS realisasi_kegiatan_realisasi_quality',
                                        'realisasi_kegiatan.realisasi_cost AS realisasi_kegiatan_realisasi_cost',
                                        'realisasi_kegiatan.realisasi_waktu AS realisasi_kegiatan_realisasi_waktu',

                                        'realisasi_kegiatan.hitung_quantity',
                                        'realisasi_kegiatan.hitung_quality',
                                        'realisasi_kegiatan.hitung_waktu',
                                        'realisasi_kegiatan.hitung_cost',

                                        'realisasi_kegiatan.akurasi',
                                        'realisasi_kegiatan.ketelitian',
                                        'realisasi_kegiatan.kerapihan',
                                        'realisasi_kegiatan.keterampilan',


                                        'capaian_tahunan.status'


                                    ) 
                            //->groupBy('kegiatan_tahunan.id')
                            ->DISTINCT('kegiatan_tahunan.id')
                            ->WHERE('skp_tahunan_rencana_aksi.renja_id',$renja_id)
                            ->GET();


        return $rencana_aksi;
    }


    public function Eselon3($capaian_id){

         //kegiatan eselon 3
         $data       = CapaianTahunan::WHERE('id',$capaian_id)->first();
         $renja_id   = $data->SKPTahunan->renja_id;    
         $jabatan_id = $data->PegawaiYangDinilai->id_jabatan;

         $bawahan = Jabatan::SELECT('id')->WHERE('parent_id', $jabatan_id )->get()->toArray();


         $kegiatan = Kegiatan::WHERE('renja_kegiatan.renja_id', $renja_id )
                         ->WHEREIN('renja_kegiatan.jabatan_id', $bawahan  )
                         //LEFT JOIN ke Kegiatan SKP TAHUNAN
                         ->JOIN('db_pare_2018.skp_tahunan_kegiatan AS kegiatan_tahunan', function($join){
                             $join   ->on('kegiatan_tahunan.kegiatan_id','=','renja_kegiatan.id');
                             
                         })
                         //LEFT JOIN ke INDIKATOR KEGIATAN
                         ->leftjoin('db_pare_2018.renja_indikator_kegiatan AS renja_indikator_kegiatan', function($join){
                             $join   ->on('renja_indikator_kegiatan.kegiatan_id','=','renja_kegiatan.id');
                             
                         })
                          //LEFT JOIN TERHADAP REALISASI INDIKATOR KEGIATAN
                          ->leftjoin('db_pare_2018.realisasi_indikator_kegiatan_tahunan AS realisasi_indikator', function($join) use ( $capaian_id ){
                             $join   ->on('realisasi_indikator.indikator_kegiatan_id','=','renja_indikator_kegiatan.id');
                             $join   ->WHERE('realisasi_indikator.capaian_id','=',  $capaian_id );
                             
                         })
                         //LEFT JOIN TERHADAP REALISASI TAHUNAN tahunan
                         ->leftjoin('db_pare_2018.realisasi_kegiatan_tahunan AS realisasi_kegiatan', function($join) use ( $capaian_id ){
                             $join   ->on('realisasi_kegiatan.kegiatan_tahunan_id','=','kegiatan_tahunan.id');
                             $join   ->WHERE('realisasi_kegiatan.capaian_id','=',  $capaian_id );
                             
                         })
                         //LEFT JOIN KE CAPAIAN TAHUNAN
                         ->leftjoin('db_pare_2018.capaian_tahunan AS capaian_tahunan', function($join){
                             $join   ->on('capaian_tahunan.id','=','realisasi_kegiatan.capaian_id');
                         })

                         ->SELECT(   'renja_kegiatan.id AS kegiatan_id',
                                     'renja_kegiatan.id AS no',
                                     'renja_kegiatan.jabatan_id',
                                     'renja_kegiatan.label AS kegiatan_label',

                                     'renja_indikator_kegiatan.id AS indikator_kegiatan_id',
                                     'renja_indikator_kegiatan.label AS indikator_kegiatan_label',
                                     'renja_indikator_kegiatan.target AS indikator_kegiatan_target',
                                     'renja_indikator_kegiatan.satuan AS indikator_kegiatan_satuan',

                                     'kegiatan_tahunan.id AS kegiatan_tahunan_id',
                                     'kegiatan_tahunan.label AS kegiatan_tahunan_label',
                                     'kegiatan_tahunan.quality AS kegiatan_tahunan_quality',
                                     'kegiatan_tahunan.cost AS kegiatan_tahunan_cost',
                                     'kegiatan_tahunan.target_waktu AS kegiatan_tahunan_target_waktu',
                                     'kegiatan_tahunan.angka_kredit AS kegiatan_tahunan_ak',

                                     'realisasi_indikator.id AS realisasi_indikator_id',
                                     'realisasi_indikator.target_quantity AS realisasi_indikator_target_quantity',
                                     'realisasi_indikator.realisasi_quantity AS realisasi_indikator_realisasi',
                                     'realisasi_indikator.satuan AS realisasi_indikator_satuan',

                                     'realisasi_kegiatan.id AS realisasi_kegiatan_id',
                                     'realisasi_kegiatan.target_angka_kredit AS realisasi_kegiatan_target_ak',
                                     'realisasi_kegiatan.target_quality AS realisasi_kegiatan_target_quality',
                                     'realisasi_kegiatan.target_cost AS realisasi_kegiatan_target_cost',
                                     'realisasi_kegiatan.target_waktu AS realisasi_kegiatan_target_waktu',
                                     'realisasi_kegiatan.realisasi_angka_kredit AS realisasi_kegiatan_realisasi_ak',
                                     'realisasi_kegiatan.realisasi_quality AS realisasi_kegiatan_realisasi_quality',
                                     'realisasi_kegiatan.realisasi_cost AS realisasi_kegiatan_realisasi_cost',
                                     'realisasi_kegiatan.realisasi_waktu AS realisasi_kegiatan_realisasi_waktu',

                                     'realisasi_kegiatan.hitung_quantity',
                                     'realisasi_kegiatan.hitung_quality',
                                     'realisasi_kegiatan.hitung_waktu',
                                     'realisasi_kegiatan.hitung_cost',
                                     'realisasi_kegiatan.akurasi',
                                     'realisasi_kegiatan.ketelitian',
                                     'realisasi_kegiatan.kerapihan',
                                     'realisasi_kegiatan.keterampilan',

                                     'capaian_tahunan.status'
                                    
                                 ) 
                         
                         ->get();


        $no = 0 ;
        foreach( $kegiatan AS $x ){

            if ( $x->hitung_cost <=0 ){
                $capaian_skp =   Pustaka::persen_bulat(number_format(($x->hitung_quantity + $x->hitung_quality + $x->hitung_waktu +$x->hitung_cost )/3 ,2) ) ;
            }else{
                $capaian_skp = Pustaka::persen_bulat(number_format(($x->hitung_quantity + $x->hitung_quality + $x->hitung_waktu +$x->hitung_cost )/4 ,2) );
            }

            if ( ($x->akurasi + $x->ketelitian + $x->kerapihan + $x->keterampilan ) == 0) {
                $penilaian = 0;
            }else{
                $penilaian = 1;
            }

            //penomoran
            $temp = [];
            if(!isset($arrayForTable[$x['kegiatan_tahunan_label']])){
                $arrayForTable[$x['kegiatan_tahunan_label']] = [];
                $no += 1 ;
                }
            $temp['no']         = $no;

            $item[] = array(
                'no'                        => $no,
                'capaian_tahunan_id'        => $x->capaian_id,
                'kegiatan_tahunan_id'	    => $x->kegiatan_tahunan_id,
                'realisasi_kegiatan_id'	    => $x->realisasi_kegiatan_id,
                'kegiatan_tahunan_label'	=> $x->kegiatan_tahunan_label,
                'indikator_kegiatan_label'	=> $x->indikator_kegiatan_label,

                'target_ak'                 => ( $x->realisasi_kegiatan_id ? $x->realisasi_kegiatan_target_ak : $x->kegiatan_tahunan_ak ),
                'target_quantity'           => ( $x->realisasi_indikator_id ? $x->realisasi_indikator_target_quantity : $x->indikator_kegiatan_target )." ".($x->realisasi_indikator_id ? $x->realisasi_indikator_satuan : $x->indikator_kegiatan_satuan),
                'target_quality'            => ($x->realisasi_kegiatan_id ? $x->realisasi_kegiatan_target_quality : $x->kegiatan_tahunan_quality )." %",
                'target_waktu'              => ($x->realisasi_kegiatan_id ? $x->realisasi_kegiatan_target_waktu : $x->kegiatan_tahunan_target_waktu )." bln",
                'target_cost'               => "Rp. ". ($x->realisasi_kegiatan_id ? number_format($x->realisasi_kegiatan_target_cost,'0',',','.') : number_format($x->kegiatan_tahunan_cost,'0',',','.') ),
                
                'realisasi_ak'              => ( $x->realisasi_kegiatan_id ? $x->realisasi_kegiatan_realisasi_ak : "-" ),
                'realisasi_quantity'        => ( $x->realisasi_indikator_id ? $x->realisasi_indikator_realisasi." ".$x->realisasi_indikator_satuan : "-" ),
                'realisasi_quality'         => ($x->realisasi_kegiatan_id ? $x->realisasi_kegiatan_realisasi_quality." %" : "-" ),
                'realisasi_waktu'           => ($x->realisasi_kegiatan_id ? $x->realisasi_kegiatan_realisasi_waktu." bln" : "-" ),
                'realisasi_cost'            => $x->realisasi_kegiatan_realisasi_cost,

                'hitung_quantity'           => Pustaka::persen_bulat($x->hitung_quantity),
                'hitung_quality'            => Pustaka::persen_bulat($x->hitung_quality),
                'hitung_waktu'              => Pustaka::persen_bulat($x->hitung_waktu),
                'hitung_cost'               => Pustaka::persen_bulat($x->hitung_cost),
                'total_hitung'              => $x->hitung_quantity+$x->hitung_quality+$x->hitung_waktu,
                'capaian_skp'               => $capaian_skp,
                'penilaian'                 => $penilaian,

					
			);
        }
        return $item;
    }

}