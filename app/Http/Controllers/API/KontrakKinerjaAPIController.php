<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use App\Models\Renja;
use App\Models\Kegiatan;
use App\Models\Tujuan;
use App\Models\Sasaran;
use App\Models\Program;
use App\Models\IndikatorProgram;
use App\Models\IndikatorSasaran;
use App\Models\Pegawai;
use App\Models\Jabatan;
use App\Models\SKPTahunan;
use App\Models\RencanaAksi;

use App\Helpers\Pustaka;


use Datatables;
use Validator;
use Gravatar;
use Input;
Use PDF;

class KontrakKinerjaAPIController extends Controller {

   //SASARAN KOntrak kinerja JFU
   public function SasaranStrategisJFU(Request $request)
   {
       $jabatan_id     = $request->get('jabatan_id');
       $renja_id       = $request->get('renja_id');
       $skp_tahunan_id = $request->get('skp_tahunan_id');
      
        //KEGIATAN pelaksana
        $rencana_aksi = RencanaAksi::WHERE('jabatan_id',$jabatan_id)
                                    ->WHERE('renja_id',$renja_id)
                                    ->leftjoin('db_pare_2018.skp_tahunan_kegiatan AS kegiatan_tahunan', function($join){
                                        $join  ->on('skp_tahunan_rencana_aksi.kegiatan_tahunan_id','=','kegiatan_tahunan.id');
                                    })
                                    /* ->leftjoin('db_pare_2018.renja_indikator_kegiatan AS indikator_kegiatan', function($join){
                                        $join  ->on('skp_tahunan_rencana_aksi._indikator_kegiatan_id','=','indikator_kegiatan.id');
                                    }) */
                                    ->SELECT(   'skp_tahunan_rencana_aksi.id AS rencana_aksi_id',
                                                'skp_tahunan_rencana_aksi.label AS rencana_aksi_label',
                                                'kegiatan_tahunan.label AS kegiatan_label',
                                                'kegiatan_tahunan.id AS kegiatan_tahunan_id',
                                                'skp_tahunan_rencana_aksi.target',
                                                'skp_tahunan_rencana_aksi.satuan',
                                                'kegiatan_tahunan.angka_kredit',
                                                'kegiatan_tahunan.quality',
                                                'kegiatan_tahunan.cost',
                                                'kegiatan_tahunan.target_waktu'

                                            ) 
                                    ->groupBy('kegiatan_tahunan.label')
                                    ->groupBy('skp_tahunan_rencana_aksi.label')
                                    //->WHERE('kegiatan_tahunan.skp_tahunan_id','=',$skp_tahunan_id)
                                    ->distinct()
                                    ->get(); 

       $datatables = Datatables::of($rencana_aksi)
                           ->addColumn('id', function ($x) {
                               return $x->kegiatan_tahunan_id;
                           })
                           ->addColumn('kegiatan', function ($x) {
                               return Pustaka::capital_string($x->kegiatan_label);
                           })
                           ->addColumn('indikator', function ($x) {
                               return Pustaka::capital_string($x->rencana_aksi_label);
                           })
                           ->addColumn('kk_status', function ($x) {
                               return 1 ;
                           })
                           ->addColumn('target', function ($x) {
                               return $x->target." ".$x->satuan;
                           });
                           
       
                           if ($keyword = $request->get('search')['value']) {
                               $datatables->filterColumn('rownum', 'whereRawx', '@rownum  + 1 like ?', ["%{$keyword}%"]);
                           } 
       return $datatables->make(true);


   }

   //aNGGARAN KOntrak kinerja JFU
   public function AnggaranKegiatanJFU(Request $request)
   {
       $jabatan_id     = $request->get('jabatan_id');
       $renja_id       = $request->get('renja_id');
       $skp_tahunan_id = $request->get('skp_tahunan_id');
      
        //KEGIATAN pelaksana
        $rencana_aksi = RencanaAksi::WHERE('jabatan_id',$jabatan_id)
                                    ->WHERE('renja_id',$renja_id)
                                    ->leftjoin('db_pare_2018.skp_tahunan_kegiatan AS kegiatan_tahunan', function($join){
                                        $join  ->on('skp_tahunan_rencana_aksi.kegiatan_tahunan_id','=','kegiatan_tahunan.id');
                                    })
                                    /* ->leftjoin('db_pare_2018.renja_indikator_kegiatan AS indikator_kegiatan', function($join){
                                        $join  ->on('skp_tahunan_rencana_aksi._indikator_kegiatan_id','=','indikator_kegiatan.id');
                                    }) */
                                    ->SELECT(   'skp_tahunan_rencana_aksi.id AS rencana_aksi_id',
                                                'skp_tahunan_rencana_aksi.label AS rencana_aksi_label',
                                                'kegiatan_tahunan.label AS kegiatan_label',
                                                'kegiatan_tahunan.id AS kegiatan_tahunan_id',
                                                'skp_tahunan_rencana_aksi.target',
                                                'skp_tahunan_rencana_aksi.satuan',
                                                'kegiatan_tahunan.angka_kredit',
                                                'kegiatan_tahunan.quality',
                                                'kegiatan_tahunan.cost as anggaran',
                                                'kegiatan_tahunan.target_waktu'

                                            ) 
                                    ->groupBy('kegiatan_tahunan.id')
                                    //->orderBY('skp_tahunan_rencana_aksi.label')
                                    ->distinct()
                                    ->get(); 

       $datatables = Datatables::of($rencana_aksi)
                            ->addColumn('kegiatan_id', function ($x) {
                               return $x->kegiatan_tahunan_id;
                            })
                            ->addColumn('kegiatan_label', function ($x) {
                               return Pustaka::capital_string($x->kegiatan_label);
                            })
                            ->addColumn('kk_status', function ($x) {
                                return 1 ;
                            })
                            ->addColumn('anggaran', function ($x) {
                                return "Rp.   " . number_format( $x->anggaran, '0', ',', '.');
                            });
                          
                           
       
                           if ($keyword = $request->get('search')['value']) {
                               $datatables->filterColumn('rownum', 'whereRawx', '@rownum  + 1 like ?', ["%{$keyword}%"]);
                           } 
       return $datatables->make(true);


   }

   public function TotalAnggaranKegiatanJFU(Request $request)
   {
    $jabatan_id     = $request->get('jabatan_id');
    $renja_id       = $request->get('renja_id');
    $skp_tahunan_id = $request->get('skp_tahunan_id');
   
     //KEGIATAN pelaksana
     $dt = RencanaAksi::WHERE('jabatan_id',$jabatan_id)
                                 ->WHERE('renja_id',$renja_id)
                                 ->leftjoin('db_pare_2018.skp_tahunan_kegiatan AS kegiatan_tahunan', function($join){
                                     $join  ->on('skp_tahunan_rencana_aksi.kegiatan_tahunan_id','=','kegiatan_tahunan.id');
                                 })
                                 /* ->leftjoin('db_pare_2018.renja_indikator_kegiatan AS indikator_kegiatan', function($join){
                                     $join  ->on('skp_tahunan_rencana_aksi._indikator_kegiatan_id','=','indikator_kegiatan.id');
                                 }) */
                                 ->SELECT(   
                                             'kegiatan_tahunan.cost as anggaran'

                                         ) 
                                 ->groupBy('kegiatan_tahunan.id')
                                 //->orderBY('skp_tahunan_rencana_aksi.label')
                                 ->distinct()
                                 ->get(); 

       $total_anggaran = 0 ;
       foreach ($dt as $x) {
           $total_anggaran = $total_anggaran + $x->anggaran;
       }

       $ta = array(
               'total_anggaran'    => "Rp.   " . number_format( $total_anggaran, '0', ',', '.'),
               );
       return $ta;
   }


}
