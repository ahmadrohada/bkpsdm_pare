<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\SasaranPerjanjianKinerja;
use App\Models\Sasaran;
use App\Models\IndikatorSasaran;
use App\Models\PerjanjianKinerja;
use App\Models\KegiatanSKPTahunan;
use App\Models\CapaianTahunan;
use App\Models\KegiatanSKPTahunanJFT;
use App\Models\KegiatanSKPBulanan;
use App\Models\RealisasiKegiatanBulanan;
use App\Models\RealisasiKegiatanTahunan;
use App\Models\RealisasiKegiatanTahunanJFT;
use App\Models\RealisasiIndikatorKegiatanTahunan;

use App\Models\IndikatorProgram; 
use App\Models\Skpd;
use App\Models\Jabatan;
use App\Models\SKPTahunan;
use App\Models\SKPBulanan;
use App\Models\RencanaAksi;
use App\Models\Kegiatan;
use App\Models\IndikatorKegiatan;

use App\Helpers\Pustaka;
use App\Traits\TraitCapaianTahunan;

use Datatables;
use Validator;
use Gravatar;
use Input;
Use Alert;

class RealisasiKegiatanTahunanAPIController extends Controller {

    use TraitCapaianTahunan;

    protected function hitung_quantity($capaian_id,$kegiatan_tahunan_id,$jm_indikator){
        $data_uing = KegiatanSKPTahunan::
                //LEFT JOIN ke INDIKATOR KEGIATAN
                leftjoin('db_pare_2018.renja_indikator_kegiatan AS renja_indikator_kegiatan', function($join){
                    $join   ->on('renja_indikator_kegiatan.kegiatan_id','=','skp_tahunan_kegiatan.kegiatan_id');
                    
                })
                //LEFT JOIN TERHADAP REALISASI INDIKATOR KEGIATAN
                ->join('db_pare_2018.realisasi_indikator_kegiatan_tahunan AS realisasi_indikator', function($join) use ( $capaian_id ){
                    $join   ->on('realisasi_indikator.indikator_kegiatan_id','=','renja_indikator_kegiatan.id');
                    $join   ->WHERE('realisasi_indikator.capaian_id','=',  $capaian_id );
                    
                })

                ->SELECT('realisasi_indikator.target_quantity AS target',
                        'realisasi_indikator.realisasi_quantity AS realisasi')
                ->WHERE('skp_tahunan_kegiatan.id',$kegiatan_tahunan_id)
                ->get();
               
        //LAkukan perulangan untuk menghitung rata-rata realisasi nya
        $jm_q = 0 ;
        foreach ($data_uing as $x) {
            $cap = ( $x->realisasi / $x->target )*100;
            $jm_q = $jm_q + $cap ;
        }   

        return number_format($jm_q / $jm_indikator ,'2');

    }

    protected function hitung_quality($target,$a,$b,$c,$d){
        //Aspek kualitas
        $persen_capaian_kualitas = ( ($a+$b+$c+$d) / 20 )*100;
            
        $capaian_kualitas = ($persen_capaian_kualitas / $target)*100;
            
        return $capaian_kualitas;

    }

    protected function hitung_waktu($target,$capaian){

        $persen_efisiensi_waktu = 100 - ( ($capaian / $target) * 100);
        if ( $persen_efisiensi_waktu <= 24 ) {
            $capaian_waktu = ((1.76 * $target - $capaian)/ $target )*100;
        }else{
            $capaian_waktu = 76 - (((1.76 * $target - $capaian)/ $target )*100) -100;
        }
    
        return $capaian_waktu;

    }


    protected function hitung_cost($target,$capaian){

        //jika kegiatan tidak ada biaya
        if ( ( $capaian != 0 ) && ( $target != 0 )){
            //Aspek biaya
            $capaian_biaya =  ( $capaian/$target)*100;
            
            return number_format($capaian_biaya,2);
        }else{
            return 0 ;
        }
    }

    



    /* protected function kegiatan_tahunan_kasubid($renja_id,$jabatan_id,$capaian_id,$search){
 
    
    \DB::statement(\DB::raw('set @rownum=0'));
    $kegiatan = Kegiatan::WHERE('renja_kegiatan.renja_id', $renja_id )
                            ->WHERE('renja_kegiatan.jabatan_id','=',  $jabatan_id  )
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

                            ->SELECT(   \DB::raw('@rownum  := @rownum  + 1 AS rownum'),
                                        'renja_kegiatan.id AS kegiatan_id',
                                        'renja_kegiatan.id AS no',
                                        'renja_kegiatan.jabatan_id',
                                        'renja_kegiatan.label AS kegiatan_label',


                                        'renja_indikator_kegiatan.id AS indikator_kegiatan_id',
                                        'renja_indikator_kegiatan.label AS indikator_label',
                                        'renja_indikator_kegiatan.target AS indikator_quantity',
                                        'renja_indikator_kegiatan.satuan AS indikator_satuan',


                                        'kegiatan_tahunan.id AS kegiatan_tahunan_id',
                                        'kegiatan_tahunan.label AS kegiatan_tahunan_label',
                                        'kegiatan_tahunan.quality AS kegiatan_tahunan_quality',
                                        'kegiatan_tahunan.cost AS kegiatan_tahunan_cost',
                                        'kegiatan_tahunan.target_waktu AS kegiatan_tahunan_target_waktu',
                                        'kegiatan_tahunan.angka_kredit AS kegiatan_tahunan_ak',

                                        'realisasi_indikator.id AS realisasi_indikator_id',
                                        'realisasi_indikator.target_quantity AS realisasi_indikator_target_quantity',
                                        'realisasi_indikator.realisasi_quantity AS realisasi_indikator_realisasi_quantity',
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
                
        $datatables = Datatables::of($kegiatan)
       
        ->addColumn('id', function ($x) {
            return $x->kegiatan_tahunan_id;
        })->addColumn('capaian_tahunan_id', function ($x) use ($capaian_id) {
            return $capaian_id;
        })->addColumn('target_quantity', function ($x) {
            return ( $x->realisasi_indikator_id ? $x->realisasi_indikator_target_quantity : $x->indikator_quantity )." ".($x->realisasi_indikator_id ? $x->realisasi_indikator_satuan : $x->indikator_satuan);
        })->addColumn('target_quality', function ($x) {
            return ($x->realisasi_kegiatan_id ? $x->realisasi_kegiatan_target_quality : $x->kegiatan_tahunan_quality )." %";
        })->addColumn('target_waktu', function ($x) {
            return  ($x->realisasi_kegiatan_id ? $x->realisasi_kegiatan_realisasi_waktu : $x->kegiatan_tahunan_target_waktu )." bln";
        })->addColumn('target_cost', function ($x) {
            return "Rp. ". ($x->realisasi_kegiatan_id ? number_format($x->realisasi_kegiatan_target_cost,'0',',','.') : number_format($x->kegiatan_tahunan_cost,'0',',','.') );
        })->addColumn('realisasi_quantity', function ($x) {
            return ( $x->realisasi_indikator_id ? $x->realisasi_indikator_realisasi_quantity." ".$x->realisasi_indikator_satuan : "-" );
        })->addColumn('realisasi_quality', function ($x) {
            return ($x->realisasi_kegiatan_id ? $x->realisasi_kegiatan_realisasi_quality." %" : "-" );
        })->addColumn('realisasi_waktu', function ($x) {
            return  ($x->realisasi_kegiatan_id ? $x->realisasi_kegiatan_realisasi_waktu." bln" : "-" );
        })->addColumn('realisasi_cost', function ($x) {
            return ($x->realisasi_kegiatan_id ? "Rp. ". number_format($x->realisasi_kegiatan_realisasi_cost,'0',',','.') : "-" );
        })->addColumn('jumlah', function ($x) {
            return  ($x->hitung_quantity + $x->hitung_quality + $x->hitung_waktu +$x->hitung_cost );
        })->addColumn('capaian_skp', function ($x) {
            if ( $x->hitung_cost <=0 ){
                return number_format(($x->hitung_quantity + $x->hitung_quality + $x->hitung_waktu +$x->hitung_cost )/3 ,2) ;
            }else{
                return number_format(($x->hitung_quantity + $x->hitung_quality + $x->hitung_waktu +$x->hitung_cost )/4 ,2);
            }
        })->addColumn('hitung_quantity', function ($x) {
            return Pustaka::persen_bulat($x->hitung_quantity);
        })->addColumn('hitung_quality', function ($x) {
            return Pustaka::persen_bulat($x->hitung_quality);
        })->addColumn('hitung_waktu', function ($x) {
            return Pustaka::persen_bulat($x->hitung_waktu);
        })->addColumn('hitung_cost', function ($x) {
            return Pustaka::persen_bulat($x->hitung_cost);
        })->addColumn('realisasi_kegiatan_id', function ($x) {
        
            return $x->realisasi_kegiatan_id;

            
        })->addColumn('penilaian', function ($x) {
            if ( ($x->akurasi + $x->ketelitian + $x->kerapihan + $x->keterampilan ) == 0) {
                return 0;
            }else{
                return 1;
            }

            
        });

        if ($keyword = $search ) {
            $datatables->filterColumn('rownum', 'whereRawx', '@rownum  + 1 like ?', ["%{$keyword}%"]);
        } 

        return $datatables->make(true); 


    } */

   


        public function RealisasiKegiatanTahunan2(Request $request){ 

            $kegiatan = $this->Kegiatan($request->capaian_id);

            $no = 0 ;
            foreach ( $kegiatan as $dbValue) {
                $temp = [];
                if(!isset($arrayForTable[$dbValue['kegiatan_tahunan_label']])){
                    $arrayForTable[$dbValue['kegiatan_tahunan_label']] = [];
                    $no += 1 ;
                }
                $temp['no']         = $no;
                $arrayForTable[$dbValue['kegiatan_tahunan_label']] = $temp;
            }

           
            $datatables = Datatables::of(collect($kegiatan));

            if ($keyword = $request->get('search')['value']) {
                $datatables->filterColumn('rownum', 'whereRawx', '@rownum  + 1 like ?', ["%{$keyword}%"]);
            }      
            return $datatables->make(true);
        }

        public function RealisasiKegiatanTahunan3(Request $request){ 
            

            $kegiatan = $this->Kegiatan($request->capaian_id);

            $no = 0 ;
            foreach ( $kegiatan as $dbValue) {
                $temp = [];
                if(!isset($arrayForTable[$dbValue['kegiatan_tahunan_label']])){
                    $arrayForTable[$dbValue['kegiatan_tahunan_label']] = [];
                    $no += 1 ;
                }
                $temp['no']         = $no;
                $arrayForTable[$dbValue['kegiatan_tahunan_label']] = $temp;
            }

           
            $datatables = Datatables::of(collect($kegiatan));

            if ($keyword = $request->get('search')['value']) {
                $datatables->filterColumn('rownum', 'whereRawx', '@rownum  + 1 like ?', ["%{$keyword}%"]);
            }      
            return $datatables->make(true);

            
        }


        public function RealisasiKegiatanTahunan4(Request $request){ 
            
            $kegiatan = $this->Kegiatan($request->capaian_id); 
            
            //JFU tidak memiliki kegiatan tahunan, kegiatan tahunan nya adalah milik atasan nya yg eselon 4
            //jadi
            $capaian_id = $request->capaian_id;
            $jabatan_id = $request->jabatan_id;

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
                            ->WHERE('skp_tahunan_rencana_aksi.renja_id',$request->renja_id)
                            ->GET();

            $no = 0 ;
            foreach ($rencana_aksi as $dbValue) {
                $temp = [];
                if(!isset($arrayForTable[$dbValue['kegiatan_tahunan_label']])){
                    $arrayForTable[$dbValue['kegiatan_tahunan_label']] = [];
                    $no += 1 ;
                }
                $temp['no']   = $no;
                $arrayForTable[$dbValue['kegiatan_tahunan_label']] = $temp;
            }
                
            $datatables = Datatables::of($rencana_aksi)
                            ->addColumn('no', function ($x) use($arrayForTable){
                                return $arrayForTable[$x->kegiatan_tahunan_label]['no'];
                            })
                            ->addColumn('id', function ($x) {
                                return $x->kegiatan_tahunan_id;
                            })->addColumn('capaian_tahunan_id', function ($x) use ($capaian_id) {
                                return $capaian_id;
                            })->addColumn('target_ak', function ($x) {
                                return ( $x->realisasi_kegiatan_id ? $x->realisasi_kegiatan_target_ak : $x->kegiatan_tahunan_ak );
                            })->addColumn('target_quantity', function ($x) {
                                return ( $x->realisasi_indikator_id ? $x->realisasi_indikator_target_quantity : $x->indikator_kegiatan_target )." ".($x->realisasi_indikator_id ? $x->realisasi_indikator_satuan : $x->indikator_kegiatan_satuan);
                            })->addColumn('target_quality', function ($x) {
                                return ($x->realisasi_kegiatan_id ? $x->realisasi_kegiatan_target_quality : $x->kegiatan_tahunan_quality )." %";
                            })->addColumn('target_waktu', function ($x) {
                                return  ($x->realisasi_kegiatan_id ? $x->realisasi_kegiatan_target_waktu : $x->kegiatan_tahunan_target_waktu )." bln";
                            })->addColumn('target_cost', function ($x) {
                                return "Rp. ". ($x->realisasi_kegiatan_id ? number_format($x->realisasi_kegiatan_target_cost,'0',',','.') : number_format($x->kegiatan_tahunan_cost,'0',',','.') );
                            })->addColumn('realisasi_ak', function ($x) {
                                return ( $x->realisasi_kegiatan_id ? $x->realisasi_kegiatan_realisasi_ak : "-" );
                            })->addColumn('realisasi_quantity', function ($x) {
                                return ( $x->realisasi_indikator_id ? $x->realisasi_indikator_realisasi." ".$x->realisasi_indikator_satuan : "-" );
                            })->addColumn('realisasi_quality', function ($x) {
                                return ($x->realisasi_kegiatan_id ? $x->realisasi_kegiatan_realisasi_quality." %" : "-" );
                            })->addColumn('realisasi_waktu', function ($x) {
                                return  ($x->realisasi_kegiatan_id ? $x->realisasi_kegiatan_realisasi_waktu." bln" : "-" );
                            })->addColumn('realisasi_cost', function ($x) {
                                return ($x->realisasi_kegiatan_id ? "Rp. ". number_format($x->realisasi_kegiatan_realisasi_cost,'0',',','.') : "-" );
                            
                            })->addColumn('hitung_quantity', function ($x) {
                                return Pustaka::persen_bulat($x->hitung_quantity);
                            })->addColumn('hitung_quality', function ($x) {
                                return Pustaka::persen_bulat($x->hitung_quality);
                            })->addColumn('hitung_waktu', function ($x) {
                                return Pustaka::persen_bulat($x->hitung_waktu);
                            })->addColumn('hitung_cost', function ($x) {
                                return Pustaka::persen_bulat($x->hitung_cost);
                            })->addColumn('total_hitung', function ($x) {
                                return $x->hitung_quantity+$x->hitung_quality+$x->hitung_waktu;
                            })->addColumn('capaian_skp', function ($x) {
                                if ( $x->hitung_cost <=0 ){
                                    return Pustaka::persen_bulat(number_format(($x->hitung_quantity + $x->hitung_quality + $x->hitung_waktu +$x->hitung_cost )/3 ,2) ) ;
                                }else{
                                    return Pustaka::persen_bulat(number_format(($x->hitung_quantity + $x->hitung_quality + $x->hitung_waktu +$x->hitung_cost )/4 ,2) );
                                }
                            })->addColumn('realisasi_kegiatan_id', function ($x) {
                                return $x->realisasi_kegiatan_id;
                            })->addColumn('penilaian', function ($x) {
                                if ( ($x->akurasi + $x->ketelitian + $x->kerapihan + $x->keterampilan ) == 0) {
                                    return 0;
                                }else{
                                    return 1;
                                }
                    
                                
                            });
                    
                            if ($keyword = $request->get('search')['value']) {
                                $datatables->filterColumn('rownum', 'whereRawx', '@rownum  + 1 like ?', ["%{$keyword}%"]);
                            } 
                    
                            return $datatables->make(true); 
            
        
        }

    public function RealisasiKegiatanTahunan5(Request $request){

        $kegiatan = $this->Kegiatan($request->capaian_id);

        $no = 0 ;
        foreach ( $kegiatan as $dbValue) {
            $temp = [];
            if(!isset($arrayForTable[$dbValue['kegiatan_tahunan_label']])){
                $arrayForTable[$dbValue['kegiatan_tahunan_label']] = [];
                $no += 1 ;
            }
            $temp['no']         = $no;
            $arrayForTable[$dbValue['kegiatan_tahunan_label']] = $temp;
        }

       
        $datatables = Datatables::of(collect($kegiatan));

        if ($keyword = $request->get('search')['value']) {
            $datatables->filterColumn('rownum', 'whereRawx', '@rownum  + 1 like ?', ["%{$keyword}%"]);
        }      
        return $datatables->make(true); 

        
        
    }
   
    //KABID
    /* public function RealisasiKegiatanTriwulan2(Request $request) 
    {
            
        $child = Jabatan::SELECT('id')->WHERE('parent_id', $request->jabatan_id )->get()->toArray(); 

        $capaian_triwulan_id = $request->capaian_triwulan_id;

       //KEGIATAN KABID
        $skp_tahunan_id = $request->skp_tahunan_id;
        $kegiatan = Kegiatan::WHERE('renja_kegiatan.renja_id', $request->renja_id )
                            ->WHEREIN('renja_kegiatan.jabatan_id',$child )

                            //LEFT JOIN ke Kegiatan SKP TAHUNAN
                            ->leftjoin('db_pare_2018.skp_tahunan_kegiatan AS kegiatan_tahunan', function($join){
                                $join   ->on('kegiatan_tahunan.kegiatan_id','=','renja_kegiatan.id');
                                
                            })
                            //LEFT JOIN TERHADAP REALISASI TRIWULAN NYA
                            ->leftjoin('db_pare_2018.realisasi_triwulan_kegiatan_tahunan AS realisasi_triwulan', function($join) use ( $capaian_triwulan_id ){
                                $join   ->on('realisasi_triwulan.kegiatan_tahunan_id','=','kegiatan_tahunan.id');
                                //$join   ->WHERE('realisasi_triwulan.capaian_id','=',  $capaian_triwulan_id);
                                
                            })

                            ->SELECT(   
                                        'kegiatan_tahunan.label AS kegiatan_tahunan_label',
                                        'kegiatan_tahunan.id AS kegiatan_tahunan_id',
                                        'renja_kegiatan.jabatan_id',
                                        'kegiatan_tahunan.target AS qty_target',
                                        'kegiatan_tahunan.cost AS cost_target',
                                        'kegiatan_tahunan.satuan',
                                        'realisasi_triwulan.id AS realisasi_kegiatan_id',
                                        'realisasi_triwulan.quantity AS qty_realisasi',
                                        'realisasi_triwulan.cost AS cost_realisasi'
                                    ) 
                            ->get();

                
        $datatables = Datatables::of($kegiatan)
        ->addColumn('id', function ($x) {
            return $x->kegiatan_tahunan_id;
        })->addColumn('label', function ($x) {
            return $x->kegiatan_tahunan_label;
        })->addColumn('penanggung_jawab', function ($x) {
            return Pustaka::capital_string($x->PenanggungJawab->jabatan);
        })->addColumn('qty_target', function ($x) {
            return $x->qty_target.' '.$x->satuan;
        })->addColumn('cost_target', function ($x) {
            return "Rp. ".number_format($x->cost_target,'0',',','.');
        })->addColumn('qty_realisasi', function ($x) {
            return $x->qty_realisasi.' '.$x->satuan;
        })->addColumn('cost_realisasi', function ($x) {
            return "Rp. ".number_format($x->cost_realisasi,'0',',','.');
        });

        if ($keyword = $request->get('search')['value']) {
            $datatables->filterColumn('rownum', 'whereRawx', '@rownum  + 1 like ?', ["%{$keyword}%"]);
        } 

        return $datatables->make(true); 
        
    }  */

   
    /* public function RealisasiKegiatanTahunan(Request $request) 
    {
        $jenis_jabatan          = $request->jenis_jabatan;
        $jabatan_id             = $request->jabatan_id;
        $renja_id               = $request->renja_id;
        $capaian_id             = $request->capaian_id;
        $search                 = $request->get('search')['value'];
       

        switch($jenis_jabatan)
					{
				case 1 : "";
						break;
				case 2 : "";
						break;
				case 3 : return $this->kegiatan_tahunan_kasubid($renja_id,$jabatan_id,$capaian_id,$search);
						break;
				case 4 : "";
						break;
				case 5 : return $this->kegiatan_tahunan_jft($renja_id,$jabatan_id,$capaian_id,$search);
						break;
					}

     
    } */ 

    public function PenilaianKualitasKerja(Request $request)
    {
        $realisasi_kegiatan_id = $request->realisasi_kegiatan_id;
        $x = RealisasiKegiatanTahunan::WHERE('id',$realisasi_kegiatan_id)
                                        ->SELECT(   'id',
                                                    'akurasi',
                                                    'ketelitian',
                                                    'kerapihan',
                                                    'keterampilan'
                                        
                                                )
                                        ->first();



        //return  $rencana_aksi;
        $realisasi_kegiatan_tahunan = array(
            'realisasi_kegiatan_tahunan_id' => $x->id,
            'akurasi'                       => $x->akurasi,
            'ketelitian'                    => $x->ketelitian,
            'kerapihan'                     => $x->kerapihan,
            'keterampilan'                  => $x->keterampilan,
           
 
        );
        return $realisasi_kegiatan_tahunan;



    }
    
    
    public function AddRealisasiKegiatanTahunan(Request $request)
    {
       
        $capaian_id = $request->capaian_id;
        $indikator_kegiatan_id = $request->indikator_kegiatan_id;

        $x = IndikatorKegiatan::
                            leftjoin('db_pare_2018.renja_kegiatan AS renja_kegiatan', function($join) {
                                $join   ->on('renja_indikator_kegiatan.kegiatan_id','=','renja_kegiatan.id');
                            })
                            ->leftjoin('db_pare_2018.skp_tahunan_kegiatan AS kegiatan_tahunan', function($join) {
                                $join   ->on('kegiatan_tahunan.kegiatan_id','=','renja_kegiatan.id');
                            })
                            //REALISASINYA
                            ->leftjoin('db_pare_2018.realisasi_indikator_kegiatan_tahunan AS realisasi_indikator', function($join) use($capaian_id) {
                                $join   ->on('realisasi_indikator.indikator_kegiatan_id','=','renja_indikator_kegiatan.id');
                                $join   ->WHERE('realisasi_indikator.capaian_id','=', $capaian_id );
                            })
                            ->leftjoin('db_pare_2018.realisasi_kegiatan_tahunan AS realisasi_kegiatan', function($join) use($capaian_id) {
                                $join   ->on('realisasi_kegiatan.kegiatan_tahunan_id','=','kegiatan_tahunan.id');
                                $join   ->WHERE('realisasi_kegiatan.capaian_id','=', $capaian_id );
                            })
                
                            ->SELECT(       'renja_kegiatan.id AS kegiatan_id',
                                            'renja_indikator_kegiatan.id AS ind_kegiatan_id',
                                            'renja_indikator_kegiatan.label AS indikator_label',
                                            'renja_indikator_kegiatan.target AS indikator_quantity',
                                            'renja_indikator_kegiatan.satuan AS indikator_satuan',

                                            'kegiatan_tahunan.id AS kegiatan_tahunan_id',
                                            'kegiatan_tahunan.label AS kegiatan_tahunan_label',
                                            'kegiatan_tahunan.quality AS kegiatan_tahunan_quality',
                                            'kegiatan_tahunan.cost AS kegiatan_tahunan_cost',
                                            'kegiatan_tahunan.target_waktu AS kegiatan_tahunan_target_waktu',
                                            'kegiatan_tahunan.angka_kredit AS kegiatan_tahunan_ak',

                                            'realisasi_indikator.id AS realisasi_indikator_id',
                                            'realisasi_indikator.target_quantity AS realisasi_indikator_target_quantity',
                                            'realisasi_indikator.realisasi_quantity AS realisasi_indikator_realisasi_quantity',
                                            'realisasi_indikator.satuan AS realisasi_indikator_satuan',


                                            'realisasi_kegiatan.id AS realisasi_kegiatan_id',
                                            'realisasi_kegiatan.target_angka_kredit AS realisasi_kegiatan_target_ak',
                                            'realisasi_kegiatan.target_quality AS realisasi_kegiatan_target_quality',
                                            'realisasi_kegiatan.target_cost AS realisasi_kegiatan_target_cost',
                                            'realisasi_kegiatan.target_waktu AS realisasi_kegiatan_target_waktu',
                                            'realisasi_kegiatan.realisasi_angka_kredit AS realisasi_kegiatan_realisasi_ak',
                                            'realisasi_kegiatan.realisasi_quality AS realisasi_kegiatan_realisasi_quality',
                                            'realisasi_kegiatan.realisasi_cost AS realisasi_kegiatan_realisasi_cost',
                                            'realisasi_kegiatan.realisasi_waktu AS realisasi_kegiatan_realisasi_waktu'
                                        



                                            
                                    ) 
                            ->WHERE('renja_indikator_kegiatan.id', $indikator_kegiatan_id)
                            ->first();

       
        $jm_indikator = IndikatorKegiatan::WHERE('kegiatan_id',$x->kegiatan_id)->count();


        $ind_kegiatan = array(
            'ind_kegiatan_id'           => $x->ind_kegiatan_id,
            'indikator_label'           => $x->indikator_label,
            'kegiatan_tahunan_id'       => $x->kegiatan_tahunan_id,
            'kegiatan_tahunan_label'    => $x->kegiatan_tahunan_label,

           
			'realisasi_indikator_id'    => $x->realisasi_indikator_id,
			'realisasi_kegiatan_id'     => $x->realisasi_kegiatan_id,

            'jumlah_indikator'          => $jm_indikator,

            
            
            'target_quantity'           => $x->realisasi_indikator_id ? $x->realisasi_indikator_target_quantity : $x->indikator_quantity,
            'satuan'                    => $x->realisasi_indikator_id ? $x->realisasi_indikator_satuan : $x->indikator_satuan,
            'target_quality'            => $x->realisasi_kegiatan_id ? $x->realisasi_kegiatan_target_quality : $x->kegiatan_tahunan_quality,
            'target_waktu'              => $x->realisasi_kegiatan_id ? $x->realisasi_kegiatan_target_waktu : $x->kegiatan_tahunan_target_waktu,
            'target_cost'               => $x->realisasi_kegiatan_id ? number_format($x->realisasi_kegiatan_target_cost,'0',',','.') : number_format($x->kegiatan_tahunan_cost,'0',',','.'),
            'target_ak'                 => $x->realisasi_kegiatan_id ? $x->realisasi_kegiatan_target_ak : $x->kegiatan_tahunan_ak,

            'realisasi_ak'              => $x->realisasi_kegiatan_realisasi_ak,
            'realisasi_quantity'        => $x->realisasi_indikator_realisasi_quantity,
            'realisasi_quality'         => $x->realisasi_kegiatan_realisasi_quality,
            'realisasi_waktu'           => $x->realisasi_kegiatan_realisasi_waktu,
            'realisasi_cost'            => number_format($x->realisasi_kegiatan_realisasi_cost,'0',',','.'),



        ); 
        return $ind_kegiatan;
    }


    public function AddRealisasiKegiatanTahunan5(Request $request)
    {
       
        $capaian_id = $request->capaian_id;
        $kegiatan_id = $request->kegiatan_id;

        $x = KegiatanSKPTahunanJFT::
                           
                            //REALISASINYA
                            leftjoin('db_pare_2018.realisasi_kegiatan_tahunan_jft AS realisasi_kegiatan', function($join) use($capaian_id) {
                                $join   ->on('realisasi_kegiatan.kegiatan_tahunan_id','=','skp_tahunan_kegiatan_jft.id');
                                $join   ->WHERE('realisasi_kegiatan.capaian_id','=', $capaian_id );
                            })
                
                            ->SELECT(       
                                            'skp_tahunan_kegiatan_jft.id AS kegiatan_tahunan_id',
                                            'skp_tahunan_kegiatan_jft.label AS kegiatan_tahunan_label',
                                            'skp_tahunan_kegiatan_jft.angka_kredit AS kegiatan_tahunan_angka_kredit',
                                            'skp_tahunan_kegiatan_jft.quality AS kegiatan_tahunan_quality',
                                            'skp_tahunan_kegiatan_jft.target AS kegiatan_tahunan_quantity',
                                            'skp_tahunan_kegiatan_jft.satuan AS kegiatan_tahunan_satuan',
                                            'skp_tahunan_kegiatan_jft.cost AS kegiatan_tahunan_cost',
                                            'skp_tahunan_kegiatan_jft.target_waktu AS kegiatan_tahunan_target_waktu',

                                            'realisasi_kegiatan.id AS realisasi_kegiatan_id',
                                            'realisasi_kegiatan.target_angka_kredit AS realisasi_kegiatan_target_angka_kredit',
                                            'realisasi_kegiatan.target_quality AS realisasi_kegiatan_target_quality',
                                            'realisasi_kegiatan.target_quantity AS realisasi_kegiatan_target_quantity',
                                            'realisasi_kegiatan.target_cost AS realisasi_kegiatan_target_cost',
                                            'realisasi_kegiatan.target_waktu AS realisasi_kegiatan_target_waktu',
                                            'realisasi_kegiatan.realisasi_angka_kredit AS realisasi_kegiatan_realisasi_angka_kredit',
                                            'realisasi_kegiatan.realisasi_quantity AS realisasi_kegiatan_realisasi_quantity',
                                            'realisasi_kegiatan.realisasi_quality AS realisasi_kegiatan_realisasi_quality',
                                            'realisasi_kegiatan.realisasi_cost AS realisasi_kegiatan_realisasi_cost',
                                            'realisasi_kegiatan.realisasi_waktu AS realisasi_kegiatan_realisasi_waktu'
                                        



                                            
                                    ) 
                            ->WHERE('skp_tahunan_kegiatan_jft.id', $kegiatan_id)
                            ->first();

       
        $jm_indikator = IndikatorKegiatan::WHERE('kegiatan_id',$x->kegiatan_id)->count();


        $ind_kegiatan = array(
            'ind_kegiatan_id'           => $x->ind_kegiatan_id,
            'indikator_label'           => $x->indikator_label,
            'kegiatan_tahunan_id'       => $x->kegiatan_tahunan_id,
            'kegiatan_tahunan_label'    => $x->kegiatan_tahunan_label,

           
			'realisasi_indikator_id'    => $x->realisasi_indikator_id,
			'realisasi_kegiatan_id'     => $x->realisasi_kegiatan_id,

            'jumlah_indikator'          => $jm_indikator,

            
            'target_quantity'           => $x->realisasi_kegiatan_id ? $x->realisasi_kegiatan_target_quantity : $x->kegiatan_tahunan_quantity,
            'target_angka_kredit'       => $x->realisasi_kegiatan_id ? $x->realisasi_kegiatan_target_angka_kredit : $x->kegiatan_tahunan_angka_kredit,
            'target_quality'            => $x->realisasi_kegiatan_id ? $x->realisasi_kegiatan_target_quality : $x->kegiatan_tahunan_quality,
            'target_waktu'              => $x->realisasi_kegiatan_id ? $x->realisasi_kegiatan_target_waktu : $x->kegiatan_tahunan_target_waktu,
            'target_cost'               => $x->realisasi_kegiatan_id ? number_format($x->realisasi_kegiatan_target_cost,'0',',','.') : number_format($x->kegiatan_tahunan_cost,'0',',','.'),
            'satuan'                    => $x->realisasi_indikator_id ? $x->realisasi_indikator_satuan : $x->kegiatan_tahunan_satuan,

            'realisasi_quantity'        => $x->realisasi_kegiatan_realisasi_quantity,
            'realisasi_angka_kredit'    => $x->realisasi_kegiatan_realisasi_angka_kredit,
            'realisasi_quality'         => $x->realisasi_kegiatan_id ? $x->realisasi_kegiatan_realisasi_quality : 100 ,
            'realisasi_waktu'           => $x->realisasi_kegiatan_realisasi_waktu,
            'realisasi_cost'            => number_format($x->realisasi_kegiatan_realisasi_cost,'0',',','.'),



        ); 
        return $ind_kegiatan;
    }

    
    




    public function UpdateKualitasKerja(Request $request)
    {

            $messages = [
                'realisasi_kegiatan_tahunan_id.required'=> 'Harus diisi',
                'akurasi.required'                      => 'Harus diisi',
                'ketelitian.required'                   => 'Harus diisi',
                'kerapihan.required'                    => 'Harus diisi',
                'keterampilan.required'                 => 'Harus diisi',
        ];

        $validator = Validator::make(
                        Input::all(),
                        array(
                            'realisasi_kegiatan_tahunan_id' => 'required',
                            'akurasi'                       => 'required|numeric|min:0|max:5',
                            'ketelitian'                    => 'required|numeric|min:0|max:5',
                            'kerapihan'                     => 'required|numeric|min:0|max:5',
                            'keterampilan'                  => 'required|numeric|min:0|max:5',


                        ),
                        $messages
        );

        if ( $validator->fails() ){
            //$messages = $validator->messages();
            return response()->json(['errors'=>$validator->messages()],422);
            
        }


        $st_update                      = RealisasiKegiatanTahunan::find(Input::get('realisasi_kegiatan_tahunan_id'));



        //hitung QUALITY
        $hitung_quality = $this->hitung_quality($st_update->target_quality,
                                                Input::get('akurasi'),
                                                Input::get('ketelitian'),
                                                Input::get('kerapihan'),
                                                Input::get('keterampilan'));

        $realisasi_quality = ( ( Input::get('akurasi') + Input::get('ketelitian') + Input::get('kerapihan') + Input::get('keterampilan') ) / 20 )*100;

        $st_update->realisasi_quality = $realisasi_quality;
        $st_update->hitung_quality =  $realisasi_quality;

        $st_update->akurasi         = Input::get('akurasi');
        $st_update->ketelitian      = Input::get('ketelitian');
        $st_update->kerapihan       = Input::get('kerapihan');
        $st_update->keterampilan    = Input::get('keterampilan');
    
    

        if ( $st_update->save()){

            return \Response::make('sukses'+$st_update->target_quality, 200);
        }else{
            return \Response::make('error', 500);
        } 
    } 

    public function UpdateKualitasKerja5(Request $request)
    {

            $messages = [
                'realisasi_kegiatan_tahunan_id.required'=> 'Harus diisi',
                'akurasi.required'                      => 'Harus diisi',
                'ketelitian.required'                   => 'Harus diisi',
                'kerapihan.required'                    => 'Harus diisi',
                'keterampilan.required'                 => 'Harus diisi',
        ];

        $validator = Validator::make(
                        Input::all(),
                        array(
                            'realisasi_kegiatan_tahunan_id' => 'required',
                            'akurasi'                       => 'required|numeric|min:0|max:5',
                            'ketelitian'                    => 'required|numeric|min:0|max:5',
                            'kerapihan'                     => 'required|numeric|min:0|max:5',
                            'keterampilan'                  => 'required|numeric|min:0|max:5',


                        ),
                        $messages
        );

        if ( $validator->fails() ){
            //$messages = $validator->messages();
            return response()->json(['errors'=>$validator->messages()],422);
            
        }


        $st_update                      = RealisasiKegiatanTahunanJFT::find(Input::get('realisasi_kegiatan_tahunan_id'));



        //hitung QUALITY
        $hitung_quality = $this->hitung_quality($st_update->target_quality,
                                                Input::get('akurasi'),
                                                Input::get('ketelitian'),
                                                Input::get('kerapihan'),
                                                Input::get('keterampilan'));

        $realisasi_quality = ( ( Input::get('akurasi') + Input::get('ketelitian') + Input::get('kerapihan') + Input::get('keterampilan') ) / 20 )*100;

        $st_update->realisasi_quality = $realisasi_quality;
        $st_update->hitung_quality =  $realisasi_quality;

        $st_update->akurasi         = Input::get('akurasi');
        $st_update->ketelitian      = Input::get('ketelitian');
        $st_update->kerapihan       = Input::get('kerapihan');
        $st_update->keterampilan    = Input::get('keterampilan');
    
    

        if ( $st_update->save()){

            return \Response::make('sukses'+$st_update->target_quality, 200);
        }else{
            return \Response::make('error', 500);
        } 
    } 


    public function Store(Request $request)
    {

        $messages = [
                'capaian_id.required'           => 'Harus diisi',
                'kegiatan_tahunan_id.required'  => 'Harus diisi',
                'ind_kegiatan_id.required'      => 'Harus diisi',
                'jumlah_indikator.required'     => 'Harus diisi',

                'target_quantity.required'      => 'Harus diisi',
                'target_quality.required'       => 'Harus diisi',
                'target_waktu.required'         => 'Harus diisi',
                'target_cost.required'          => 'Harus diisi',
                'satuan.required'               => 'Harus diisi',

                'realisasi_quantity.required'   => 'Harus diisi',
                //'realisasi_quality.required'    => 'Harus diisi',
                'realisasi_waktu.required'      => 'Harus diisi',
                'realisasi_cost.required'       => 'Harus diisi',
        

        ];

        $validator = Validator::make(
                        Input::all(),
                        array(
                            'capaian_id'            => 'required',
                            'kegiatan_tahunan_id'   => 'required',
                            'ind_kegiatan_id'       => 'required',
                            'jumlah_indikator'      => 'required|numeric|min:1',

                            'target_quantity'       => 'required',
                            'target_quality'        => 'required|numeric|min:1|max:100',
                            'target_waktu'          => 'required|numeric|min:1|max:12',
                            'target_cost'           => 'required',

                            //'realisasi_quantity'    => 'required|numeric|min:0|max:'.$request->target_quantity,
                            'realisasi_quantity'    => 'required',
                            //'realisasi_quality'     => 'required|numeric|min:1|max:100',
                            'realisasi_waktu'       => 'required|numeric|min:1|max:12',
                            'realisasi_cost'        => 'required',
                            'satuan'                => 'required',


                        ),
                        $messages
        );

        if ( $validator->fails() ){
            //$messages = $validator->messages();
            return response()->json(['errors'=>$validator->messages()],422);
            
        }

        
       
        $st_kt    = new RealisasiIndikatorKegiatanTahunan;

        $st_kt->indikator_kegiatan_id   = Input::get('ind_kegiatan_id');
        $st_kt->capaian_id              = Input::get('capaian_id');
        $st_kt->target_quantity         = Input::get('target_quantity');
        $st_kt->realisasi_quantity      = Input::get('realisasi_quantity');
        $st_kt->satuan                  = Input::get('satuan');
       

        if ( $st_kt->save()){

            //CARI REALISASI KEGIATAN NYA
            $rkt    = RealisasiKegiatanTahunan::WHERE('capaian_id','=',Input::get('capaian_id'))
                                                ->WHERE('kegiatan_tahunan_id','=',Input::get('kegiatan_tahunan_id'))
                                                ->count();

            //HITUNG CAPAIAN QUANTITAS
            $hitung_quantity = $this->hitung_quantity(Input::get('capaian_id'),Input::get('kegiatan_tahunan_id'),Input::get('jumlah_indikator'));
            //HITUNG CAPAIAN WAKTU
            $hitung_waktu = $this->hitung_waktu(Input::get('target_waktu'),Input::get('realisasi_waktu'));
            //HITUNG CAPAIAN COST
            $hitung_cost = $this->hitung_cost(Input::get('target_cost'),Input::get('realisasi_cost'));

            //jikia belum ada add new
            if ( $rkt == 0 ) {

                $rkt_save    = new RealisasiKegiatanTahunan;
                $rkt_save->capaian_id               = Input::get('capaian_id');
                $rkt_save->kegiatan_tahunan_id      = Input::get('kegiatan_tahunan_id');
                $rkt_save->jumlah_indikator         = Input::get('jumlah_indikator');

                $rkt_save->target_angka_kredit      = Input::get('target_angka_kredit');
                $rkt_save->target_quality           = Input::get('target_quality');
                $rkt_save->target_cost              = preg_replace('/[^0-9]/', '', Input::get('target_cost'));
                $rkt_save->target_waktu             = Input::get('target_waktu');

                $rkt_save->realisasi_angka_kredit   = Input::get('realisasi_angka_kredit');
                //$rkt_save->realisasi_quality        = Input::get('realisasi_quality');
                $rkt_save->realisasi_cost           = preg_replace('/[^0-9]/', '', Input::get('realisasi_cost'));
                $rkt_save->realisasi_waktu          = Input::get('realisasi_waktu');

                //HITUNG
                $rkt_save->hitung_quantity          = $hitung_quantity;
                $rkt_save->hitung_waktu             = $hitung_waktu;
                $rkt_save->hitung_cost              = $hitung_cost;


        
                $rkt_save->save();

            //jika sudah ada update saja
            }else{

                $rkt_update                           = RealisasiKegiatanTahunan::find(Input::get('realisasi_kegiatan_tahunan_id'));
                $rkt_update->jumlah_indikator         = Input::get('jumlah_indikator');
                //$rkt_update->realisasi_quality        = Input::get('realisasi_quality');
                $rkt_update->realisasi_cost           = preg_replace('/[^0-9]/', '', Input::get('realisasi_cost'));
                $rkt_update->realisasi_waktu          = Input::get('realisasi_waktu');

                //HITUNG
                $rkt_update->hitung_quantity          = $hitung_quantity;
                $rkt_update->hitung_waktu             = $hitung_waktu;
                $rkt_update->hitung_cost              = $hitung_cost;

                $rkt_update->save();
            }

            return \Response::make('sukses'+$rkt, 200);
        }else{
            return \Response::make('error', 500);
        }  
            
            
    
    }

    public function Store5(Request $request)
    {

        $messages = [
                'capaian_id.required'           => 'Harus diisi',
                'kegiatan_tahunan_id.required'  => 'Harus diisi',

                'target_quantity.required'      => 'Harus diisi',
                'target_quality.required'       => 'Harus diisi',
                'target_waktu.required'         => 'Harus diisi',
                'target_cost.required'          => 'Harus diisi',
                'satuan.required'               => 'Harus diisi',

                'realisasi_quantity.required'   => 'Harus diisi',
                'realisasi_waktu.required'      => 'Harus diisi',
                'realisasi_cost.required'       => 'Harus diisi',
        

        ];

        $validator = Validator::make(
                        Input::all(),
                        array(
                            'capaian_id'            => 'required',
                            'kegiatan_tahunan_id'   => 'required',
                            
                            'target_quantity'       => 'required',
                            'target_quality'        => 'required|numeric|min:1|max:100',
                            'target_waktu'          => 'required|numeric|min:1|max:12',
                            'target_cost'           => 'required',

                            //'realisasi_quantity'    => 'required|numeric|min:1|max:'.$request->target_quantity,
                            'realisasi_quantity'    => 'required',
                            'realisasi_waktu'       => 'required|numeric|min:1|max:12',
                            'realisasi_cost'        => 'required',
                            'satuan'                => 'required',


                        ),
                        $messages
        );

        if ( $validator->fails() ){
            //$messages = $validator->messages();
            return response()->json(['errors'=>$validator->messages()],422);
            
        }

        //HITUNG CAPAIAN QUANTITAS
        $hitung_quantity = ( Input::get('realisasi_quantity') / Input::get('target_quantity') ) * 100 ;
        //HITUNG CAPAIAN WAKTU
        $hitung_waktu = $this->hitung_waktu(Input::get('target_waktu'),Input::get('realisasi_waktu'));
        //HITUNG CAPAIAN COST
        $hitung_cost = $this->hitung_cost(Input::get('target_cost'),Input::get('realisasi_cost'));
       
        $rkt_save    = new RealisasiKegiatanTahunanJFT;
        $rkt_save->capaian_id               = Input::get('capaian_id');
        $rkt_save->kegiatan_tahunan_id      = Input::get('kegiatan_tahunan_id');

        $rkt_save->target_angka_kredit      = Input::get('target_angka_kredit');
        $rkt_save->target_quality           = Input::get('target_quality');
        $rkt_save->target_quantity          = trim(Input::get('target_quantity'));
        $rkt_save->target_cost              = preg_replace('/[^0-9]/', '', Input::get('target_cost'));
        $rkt_save->target_waktu             = Input::get('target_waktu');

        $rkt_save->realisasi_angka_kredit   = Input::get('realisasi_angka_kredit');
        $rkt_save->realisasi_quality        = Input::get('realisasi_quality');
        $rkt_save->realisasi_quantity       = trim(Input::get('realisasi_quantity'));
        $rkt_save->realisasi_cost           = preg_replace('/[^0-9]/', '', Input::get('realisasi_cost'));
        $rkt_save->realisasi_waktu          = Input::get('realisasi_waktu');
        $rkt_save->satuan                   = Input::get('satuan');

        //HITUNG
        $rkt_save->hitung_quantity          = $hitung_quantity;
        $rkt_save->hitung_waktu             = $hitung_waktu;
        $rkt_save->hitung_cost              = $hitung_cost;

        if ( $rkt_save->save()){
            return \Response::make('sukses', 200);
        }else{
            return \Response::make('error', 500);
        }  
           
    }






    public function Update(Request $request)
    {

            $messages = [
                'realisasi_indikator_kegiatan_tahunan_id.required'=> 'Harus diisi',
                'capaian_id.required'           => 'Harus diisi',
                'kegiatan_tahunan_id.required'  => 'Harus diisi',
                'ind_kegiatan_id.required'      => 'Harus diisi',
                'jumlah_indikator.required'     => 'Harus diisi',

                'target_quantity.required'      => 'Harus diisi',
                'target_quality.required'       => 'Harus diisi',
                'target_waktu.required'         => 'Harus diisi',
                'target_cost.required'          => 'Harus diisi',
                'satuan.required'               => 'Harus diisi',

                'realisasi_quantity.required'   => 'Harus diisi',
                //'realisasi_quality.required'    => 'Harus diisi',
                'realisasi_waktu.required'      => 'Harus diisi',
                'realisasi_cost.required'       => 'Harus diisi',
        

        ];

        $validator = Validator::make(
                        Input::all(),
                        array(
                            'realisasi_indikator_kegiatan_tahunan_id' => 'required',
                            'capaian_id'            => 'required',
                            'kegiatan_tahunan_id'   => 'required',
                            'ind_kegiatan_id'       => 'required',
                            'jumlah_indikator'      => 'required|numeric|min:1',

                            'target_quantity'       => 'required|numeric|min:0',
                            'target_quality'        => 'required|numeric|min:1|max:100',
                            'target_waktu'          => 'required|numeric|min:1|max:12',
                            'target_cost'           => 'required',

                            //'realisasi_quantity'    => 'required|numeric|min:1|max:'.$request->target_quantity,
                            'realisasi_quantity'    => 'required',
                            //'realisasi_quality'     => 'required|numeric|min:1|max:100',
                            'realisasi_waktu'       => 'required|numeric|min:1|max:12',
                            'realisasi_cost'        => 'required',
                            'satuan'                => 'required',


                        ),
                        $messages
        );

        if ( $validator->fails() ){
            //$messages = $validator->messages();
            return response()->json(['errors'=>$validator->messages()],422);
            
        }


        $st_update                      = RealisasiIndikatorKegiatanTahunan::find(Input::get('realisasi_indikator_kegiatan_tahunan_id'));

        $st_update->target_quantity         = Input::get('target_quantity');
        $st_update->realisasi_quantity      = Input::get('realisasi_quantity');
        $st_update->satuan                  = Input::get('satuan');
    

        if ( $st_update->save()){

            //CARI REALISASI KEGIATAN NYA
            $rkt    = RealisasiKegiatanTahunan::WHERE('capaian_id','=',Input::get('capaian_id'))
                                                ->WHERE('kegiatan_tahunan_id','=',Input::get('kegiatan_tahunan_id'))
                                                ->count();

            //HITUNG CAPAIAN QUANTITAS
            $hitung_quantity = $this->hitung_quantity(Input::get('capaian_id'),Input::get('kegiatan_tahunan_id'),Input::get('jumlah_indikator'));
            //HITUNG CAPAIAN WAKTU
            $hitung_waktu = $this->hitung_waktu(Input::get('target_waktu'),Input::get('realisasi_waktu'));
            //HITUNG CAPAIAN COST
            $hitung_cost = $this->hitung_cost(Input::get('target_cost'),Input::get('realisasi_cost'));

            //jikia belum ada add new
            if ( $rkt == 0 ) {
                $rkt_save    = new RealisasiKegiatanTahunan;
                $rkt_save->capaian_id               = Input::get('capaian_id');
                $rkt_save->kegiatan_tahunan_id      = Input::get('kegiatan_tahunan_id');
                $rkt_save->jumlah_indikator         = Input::get('jumlah_indikator');

                $rkt_save->target_angka_kredit    = Input::get('target_angka_kredit');
                $rkt_save->target_quality           = Input::get('target_quality');
                $rkt_save->target_cost              = preg_replace('/[^0-9]/', '', Input::get('target_cost'));
                $rkt_save->target_waktu             = Input::get('target_waktu');

                $rkt_save->realisasi_angka_kredit   = Input::get('realisasi_angka_kredit');
                $rkt_save->jumlah_indikator        = Input::get('jumlah_indikator');
                //$rkt_save->realisasi_quality        = Input::get('realisasi_quality');
                $rkt_save->realisasi_cost           = preg_replace('/[^0-9]/', '', Input::get('realisasi_cost'));
                $rkt_save->realisasi_waktu          = Input::get('realisasi_waktu');

                //HITUNG
                $rkt_save->hitung_quantity          = $hitung_quantity;
                $rkt_save->hitung_waktu             = $hitung_waktu;
                $rkt_save->hitung_cost              = $hitung_cost;
        
                $rkt_save->save();

            //jika sudah ada update saja
            }else{

                $rkt_update                           = RealisasiKegiatanTahunan::find(Input::get('realisasi_kegiatan_tahunan_id'));
                $rkt_update->jumlah_indikator         = Input::get('jumlah_indikator');
                //$rkt_update->realisasi_quality        = Input::get('realisasi_quality');
                $rkt_update->realisasi_angka_kredit   = Input::get('realisasi_angka_kredit');
                $rkt_update->realisasi_cost           = preg_replace('/[^0-9]/', '', Input::get('realisasi_cost'));
                $rkt_update->realisasi_waktu          = Input::get('realisasi_waktu');

                //HITUNG
                $rkt_update->hitung_quantity          = $hitung_quantity;
                $rkt_update->hitung_waktu             = $hitung_waktu;
                $rkt_update->hitung_cost              = $hitung_cost;

                $rkt_update->save();
            }

            return \Response::make('sukses'+$hitung_cost, 200);
        }else{
            return \Response::make('error', 500);
        } 
    } 


    public function Update5(Request $request)
    {

            $messages = [
                'realisasi_kegiatan_tahunan_id.required'=> 'Harus diisi',
                'capaian_id.required'           => 'Harus diisi',

              
                'capaian_id.required'           => 'Harus diisi',
                'kegiatan_tahunan_id.required'  => 'Harus diisi',

                'target_quantity.required'      => 'Harus diisi',
                'target_quality.required'       => 'Harus diisi',
                'target_waktu.required'         => 'Harus diisi',
                'target_cost.required'          => 'Harus diisi',
                'satuan.required'               => 'Harus diisi',

                'realisasi_quantity.required'   => 'Harus diisi',
                'realisasi_waktu.required'      => 'Harus diisi',
                'realisasi_cost.required'       => 'Harus diisi',
        

        ];

        $validator = Validator::make(
                        Input::all(),
                        array(
                            'realisasi_kegiatan_tahunan_id' => 'required',
                            'capaian_id'            => 'required',
                            

                            'target_quantity'       => 'required|numeric|min:0',
                            'target_quality'        => 'required|numeric|min:1|max:100',
                            'target_waktu'          => 'required|numeric|min:1|max:12',
                            'target_cost'           => 'required',
                            'satuan'                => 'required',

                            //'realisasi_quantity'    => 'required|numeric|min:1|max:'.$request->target_quantity,
                            'realisasi_quantity'    => 'required',
                            'realisasi_quality'     => 'required|numeric|min:1|max:100',
                            'realisasi_waktu'       => 'required|numeric|min:1|max:12',
                            'realisasi_cost'        => 'required',


                        ),
                        $messages
        );

        if ( $validator->fails() ){
            //$messages = $validator->messages();
            return response()->json(['errors'=>$validator->messages()],422);
            
        }

        //HITUNG CAPAIAN QUANTITAS
        $hitung_quantity = ( Input::get('realisasi_quantity') / Input::get('target_quantity') ) * 100 ;
        //HITUNG CAPAIAN WAKTU
        $hitung_waktu = $this->hitung_waktu(Input::get('target_waktu'),Input::get('realisasi_waktu'));
        //HITUNG CAPAIAN COST
        $hitung_cost = $this->hitung_cost(Input::get('target_cost'),Input::get('realisasi_cost'));

        $rkt_update    = RealisasiKegiatanTahunanJFT::find(Input::get('realisasi_kegiatan_tahunan_id'));
               
        $rkt_update->target_angka_kredit      = Input::get('target_angka_kredit');
        $rkt_update->target_quality           = Input::get('target_quality');
        $rkt_update->target_quantity          = Input::get('target_quantity');
        $rkt_update->target_cost              = preg_replace('/[^0-9]/', '', Input::get('target_cost'));
        $rkt_update->target_waktu             = Input::get('target_waktu');

        $rkt_update->realisasi_angka_kredit   = Input::get('realisasi_angka_kredit');
        $rkt_update->realisasi_quality        = Input::get('realisasi_quality');
        $rkt_update->realisasi_quantity       = Input::get('realisasi_quantity');
        $rkt_update->realisasi_cost           = preg_replace('/[^0-9]/', '', Input::get('realisasi_cost'));
        $rkt_update->realisasi_waktu          = Input::get('realisasi_waktu');
        $rkt_update->satuan                   = Input::get('satuan');
        //HITUNG
        $rkt_update->hitung_quantity          = $hitung_quantity;
        $rkt_update->hitung_waktu             = $hitung_waktu;
        $rkt_update->hitung_cost              = $hitung_cost;

                
            
        if ( $rkt_update->save()){
            return \Response::make('sukses'+$hitung_cost, 200);
        }else{
            return \Response::make('error', 500);
        } 
    } 


    public function Destroy(Request $request)
    {

        $messages = [
                //'realisasi_kegiatan_id.required'                => 'Harus diisi',
                'realisasi_indikator_kegiatan_id.required'      => 'Harus diisi',
        ];

        $validator = Validator::make(
                        Input::all(),
                        array(
                            //'realisasi_kegiatan_id'             => 'required',
                            'realisasi_indikator_kegiatan_id'   => 'required',
                        ),
                        $messages
        );

        if ( $validator->fails() ){
            //$messages = $validator->messages();
            return response()->json(['errors'=>$validator->messages()],422);
            
        }

        
        $st_kt    = RealisasiIndikatorKegiatanTahunan::find(Input::get('realisasi_indikator_kegiatan_id'));
        if (is_null($st_kt)) {
            return $this->sendError('Realisasi Indikator Kegiatan tidak ditemukan.');
        }


        if ( $st_kt->delete()){
            //Saata indikator kegiatan di hapus.,cek dulu jumlah indikator 
            $capaian_id = $st_kt->capaian_id ;
            $data_uing = IndikatorKegiatan::WHERE('kegiatan_id',Input::get('kegiatan_id'))
                                            //LEFT JOIN TERHADAP REALISASI INDIKATOR KEGIATAN
                                            ->join('db_pare_2018.realisasi_indikator_kegiatan_tahunan AS realisasi_indikator', function($join) use($capaian_id) {
                                                $join   ->on('realisasi_indikator.indikator_kegiatan_id','=','renja_indikator_kegiatan.id');
                                                $join   ->WHERE('realisasi_indikator.capaian_id','=',  $capaian_id );
                                                
                                            })
                                            ->count();

            if ( $data_uing === 0 ){
                $del_ah    = RealisasiKegiatanTahunan::find(Input::get('realisasi_kegiatan_id'));
                $del_ah->delete();
            }


            return \Response::make('sukses'. $data_uing  , 200);
        }else{
            return \Response::make('error', 500);
        } 
            
            
    
    } 

    public function Destroy5(Request $request)
    {

        $messages = [
                'realisasi_kegiatan_id.required'                => 'Harus diisi',
        ];

        $validator = Validator::make(
                        Input::all(),
                        array(
                            'realisasi_kegiatan_id'             => 'required',
                        ),
                        $messages
        );

        if ( $validator->fails() ){
            //$messages = $validator->messages();
            return response()->json(['errors'=>$validator->messages()],422);
            
        }

        $del_ah    = RealisasiKegiatanTahunanJFT::find(Input::get('realisasi_kegiatan_id'));
       
        
        if ( $del_ah->delete()){
            return \Response::make('sukses', 200);
        }else{
            return \Response::make('error', 500);
        } 
            
            
    
    } 

}
