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

use App\Traits\HitungUnsurPenunjang; 

use App\Helpers\Pustaka;

trait RealisasiKegiatan
{
   
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

    }

}