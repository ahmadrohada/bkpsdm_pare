<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Periode;
use App\Models\PerjanjianKinerja;
use App\Models\SKPTahunan;
use App\Models\Tujuan;
use App\Models\IndikatorTujuan;
use App\Models\Sasaran;
use App\Models\Skpd;
use App\Models\Renja;
use App\Models\CapaianPKTriwulan;


use App\Helpers\Pustaka;
use App\Traits\RealisasiCapaianTriwulan; 

use Datatables;
use Validator;
use Input;

class CapaianPKTriwulanAPIController extends Controller {

    use RealisasiCapaianTriwulan;

    public function CreateConfirm(Request $request)
	{

        //data yang harus diterima yaitu Renja  ID dan triwulan
        $renja_id     = $request->renja_id;
        $triwulan     = $request->triwulan;

        $cp_status = Renja::WHERE('renja.id',$renja_id)
                            //CAPAIAN TRIWULAN I
                            ->rightjoin('db_pare_2018.capaian_pk_triwulan AS triwulan', function($join)  use($triwulan){
                                $join   ->on('triwulan.renja_id','=','renja.id');
                                $join   ->where('triwulan.triwulan','=',$triwulan);
                            })
                            ->count();

        return $cp_status;
    }

    public function SKPDCapaianPKTriwulanList(Request $request) 
    {
        $skpd_id = $request->skpd_id;
        $dt = Renja::
                    leftjoin('db_pare_2018.periode AS periode', function($join){
                        $join   ->on('renja.periode_id','=','periode.id');
                    }) 
                    //CAPAIAN TRIWULAN I
                    ->leftjoin('db_pare_2018.capaian_pk_triwulan AS triwulan1', function($join){
                        $join   ->on('triwulan1.renja_id','=','renja.id');
                        $join   ->where('triwulan1.triwulan','=','1');
                    })
                     //CAPAIAN TRIWULAN II
                    ->leftjoin('db_pare_2018.capaian_pk_triwulan AS triwulan2', function($join){
                        $join   ->on('triwulan2.renja_id','=','renja.id');
                        $join   ->where('triwulan2.triwulan','=','2');
                    })
                    //CAPAIAN TRIWULAN III
                    ->leftjoin('db_pare_2018.capaian_pk_triwulan AS triwulan3', function($join){
                        $join   ->on('triwulan3.renja_id','=','renja.id');
                        $join   ->where('triwulan3.triwulan','=','3');
                    })
                     //CAPAIAN TRIWULAN IV
                    ->leftjoin('db_pare_2018.capaian_pk_triwulan AS triwulan4', function($join){
                        $join   ->on('triwulan4.renja_id','=','renja.id');
                        $join   ->where('triwulan4.triwulan','=','4');
                    })
                    ->SELECT(   
                                'renja.id AS renja_id',
                                'renja.send_to_kaban',
                                'renja.kepala_skpd_id',
                                'renja.nama_kepala_skpd',
                                'renja.status_approve',
                                'periode.label AS periode_label',
                                'periode.awal AS awal',

                                'triwulan1.id AS capaian_pk_triwulan1_id',
                                'triwulan2.id AS capaian_pk_triwulan2_id',
                                'triwulan3.id AS capaian_pk_triwulan3_id',
                                'triwulan4.id AS capaian_pk_triwulan4_id',
                                'triwulan1.status AS capaian_pk_triwulan1_status',
                                'triwulan2.status AS capaian_pk_triwulan2_status',
                                'triwulan3.status AS capaian_pk_triwulan3_status',
                                'triwulan4.status AS capaian_pk_triwulan4_status'
                            )
                    ->WHERE('renja.skpd_id',$skpd_id)
                    ->ORDERBY('renja_id','DESC')
                    ->get();
        //return $dt;

        
        $datatables = Datatables::of($dt)
        
        ->addColumn('periode', function ($x) {
            return $x->periode_label;
        })
        ->addColumn('nama_kepala_skpd', function ($x) {
            return $x->nama_kepala_skpd;
        })
        ->addColumn('remaining_time_triwulan1', function ($x){
            $tahun = Pustaka::tahun($x->awal);
            $tgl_selesai = strtotime($tahun."-04-01");
            $now         = time();
            return floor(($tgl_selesai - $now)/ (60*60*24)) * -1;
        })
        ->addColumn('remaining_time_triwulan2', function ($x){
            $tahun = Pustaka::tahun($x->awal);
            $tgl_selesai = strtotime($tahun."-07-01");
            $now         = time();
            return floor(($tgl_selesai - $now)/ (60*60*24)) * -1;
        })
        ->addColumn('remaining_time_triwulan3', function ($x){
            $tahun = Pustaka::tahun($x->awal);
            $tgl_selesai = strtotime($tahun."-10-01");
            $now         = time();
            return floor(($tgl_selesai - $now)/ (60*60*24)) * -1;
        })
        ->addColumn('remaining_time_triwulan4', function ($x){
            $tahun = Pustaka::tahun($x->awal);
            $tgl_selesai = strtotime(($tahun+1)."-01-01");
            $now         = time();
            return floor(($tgl_selesai - $now)/ (60*60*24)) * -1;
        });

        if ($keyword = $request->get('search')['value']) {
            $datatables->filterColumn('rownum', 'whereRawx', '@rownum  + 1 like ?', ["%{$keyword}%"]);
        } 
        

    return $datatables->make(true);
    }


    public function AdministratorCapaianPKTriwulanList(Request $request)  
    {
    
        $dt = Renja::
                    leftjoin('db_pare_2018.periode AS periode', function($join){
                        $join   ->on('renja.periode_id','=','periode.id');
                    }) 
                    ->leftjoin('demo_asn.m_skpd AS skpd', function($join) { 
                        $join   ->on('renja.skpd_id','=','skpd.id');
                        
                    })  
                    //CAPAIAN TRIWULAN I
                    ->leftjoin('db_pare_2018.capaian_pk_triwulan AS triwulan1', function($join){
                        $join   ->on('triwulan1.renja_id','=','renja.id');
                        $join   ->where('triwulan1.triwulan','=','1');
                    })
                     //CAPAIAN TRIWULAN II
                    ->leftjoin('db_pare_2018.capaian_pk_triwulan AS triwulan2', function($join){
                        $join   ->on('triwulan2.renja_id','=','renja.id');
                        $join   ->where('triwulan2.triwulan','=','2');
                    })
                    //CAPAIAN TRIWULAN III
                    ->leftjoin('db_pare_2018.capaian_pk_triwulan AS triwulan3', function($join){
                        $join   ->on('triwulan3.renja_id','=','renja.id');
                        $join   ->where('triwulan3.triwulan','=','3');
                    })
                     //CAPAIAN TRIWULAN IV
                    ->leftjoin('db_pare_2018.capaian_pk_triwulan AS triwulan4', function($join){
                        $join   ->on('triwulan4.renja_id','=','renja.id');
                        $join   ->where('triwulan4.triwulan','=','4');
                    })
                    ->SELECT(   
                                'renja.id AS renja_id',
                                'renja.send_to_kaban',
                                'renja.kepala_skpd_id',
                                'renja.nama_kepala_skpd',
                                'renja.status_approve',
                                'periode.label AS periode_label',
                                'periode.awal AS awal',
                                'skpd.skpd AS nama_skpd',

                                'triwulan1.id AS capaian_pk_triwulan1_id',
                                'triwulan2.id AS capaian_pk_triwulan2_id',
                                'triwulan3.id AS capaian_pk_triwulan3_id',
                                'triwulan4.id AS capaian_pk_triwulan4_id',
                                'triwulan1.status AS capaian_pk_triwulan1_status',
                                'triwulan2.status AS capaian_pk_triwulan2_status',
                                'triwulan3.status AS capaian_pk_triwulan3_status',
                                'triwulan4.status AS capaian_pk_triwulan4_status'
                            )
                    //->WHERE('renja.skpd_id',$skpd_id)
                    ->ORDERBY('renja_id','DESC')
                    ->get();
        //return $dt;

        
        $datatables = Datatables::of($dt)
        
        ->addColumn('periode', function ($x) {
            return $x->periode_label;
        })->addColumn('nama_skpd', function ($x) {
            return Pustaka::capital_string($x->nama_skpd);
        })->addColumn('nama_kepala_skpd', function ($x) {
            return $x->nama_kepala_skpd;
        })
        ->addColumn('capaian_triwulan1', function ($x){
           /*  $tahun = Pustaka::tahun($x->awal);
            $tgl_selesai = strtotime($tahun."-04-01");
            $now         = time();
            return floor(($tgl_selesai - $now)/ (60*60*24)) * -1; */
            $renja = Tujuan::
                            leftjoin('db_pare_2018.renja_sasaran AS sasaran', function($join) {  $join   ->on('sasaran.tujuan_id','=','renja_tujuan.id');}) 
                            ->leftjoin('db_pare_2018.renja_indikator_sasaran AS indikator_sasaran', function($join) { $join   ->on('indikator_sasaran.sasaran_id','=','sasaran.id');})                
                            ->SELECT('sasaran.id AS sasarann_id', 'indikator_sasaran.id AS indikator_sasaran_id','indikator_sasaran.target AS indikator_sasaran_target')
                            ->WHERE('renja_tujuan.renja_id','=',$x->renja_id)
                            ->get();
             
                    $no = 0 ;
                    $percentage = 0 ;
                    foreach ($renja as $xt) {
                        $no++;    
                        $percentage += $this->hitung_percentage_realisasi_indikator_sasaran_triwulan($x->renja_id,1,$xt->indikator_sasaran_id,$xt->indikator_sasaran_target);                    	
                    }	

                    if ($no > 0 ){
                        return Pustaka::persen2($percentage,$no);
                    }else{
                        return '';
                    }
                    
                
                  
                
        })
        ->addColumn('capaian_triwulan2', function ($x){
            /* $tahun = Pustaka::tahun($x->awal);
            $tgl_selesai = strtotime($tahun."-07-01");
            $now         = time();
            return floor(($tgl_selesai - $now)/ (60*60*24)) * -1; */
            $renja = Tujuan::
                            leftjoin('db_pare_2018.renja_sasaran AS sasaran', function($join) {  $join   ->on('sasaran.tujuan_id','=','renja_tujuan.id');}) 
                            ->leftjoin('db_pare_2018.renja_indikator_sasaran AS indikator_sasaran', function($join) { $join   ->on('indikator_sasaran.sasaran_id','=','sasaran.id');})                
                            ->SELECT('sasaran.id AS sasarann_id', 'indikator_sasaran.id AS indikator_sasaran_id','indikator_sasaran.target AS indikator_sasaran_target')
                            ->WHERE('renja_tujuan.renja_id','=',$x->renja_id)
                            ->get();
             
                    $no = 0 ;
                    $percentage = 0 ;
                    foreach ($renja as $xt) {
                        $no++;    
                        $percentage += $this->hitung_percentage_realisasi_indikator_sasaran_triwulan($x->renja_id,2,$xt->indikator_sasaran_id,$xt->indikator_sasaran_target);                    	
                    }	

                    if ($no > 0 ){
                        return Pustaka::persen2($percentage,$no);
                    }else{
                        return '';
                    }
        })
        ->addColumn('capaian_triwulan3', function ($x){
            /* $tahun = Pustaka::tahun($x->awal);
            $tgl_selesai = strtotime($tahun."-10-01");
            $now         = time();
            return floor(($tgl_selesai - $now)/ (60*60*24)) * -1; */
            $renja = Tujuan::
                            leftjoin('db_pare_2018.renja_sasaran AS sasaran', function($join) {  $join   ->on('sasaran.tujuan_id','=','renja_tujuan.id');}) 
                            ->leftjoin('db_pare_2018.renja_indikator_sasaran AS indikator_sasaran', function($join) { $join   ->on('indikator_sasaran.sasaran_id','=','sasaran.id');})                
                            ->SELECT('sasaran.id AS sasarann_id', 'indikator_sasaran.id AS indikator_sasaran_id','indikator_sasaran.target AS indikator_sasaran_target')
                            ->WHERE('renja_tujuan.renja_id','=',$x->renja_id)
                            ->get();
             
                    $no = 0 ;
                    $percentage = 0 ;
                    foreach ($renja as $xt) {
                        $no++;    
                        $percentage += $this->hitung_percentage_realisasi_indikator_sasaran_triwulan($x->renja_id,3,$xt->indikator_sasaran_id,$xt->indikator_sasaran_target);                    	
                    }	

                    if ($no > 0 ){
                        return Pustaka::persen2($percentage,$no);
                    }else{
                        return '';
                    }
        })
        ->addColumn('capaian_triwulan4', function ($x){
           /*  $tahun = Pustaka::tahun($x->awal);
            $tgl_selesai = strtotime(($tahun+1)."-01-01");
            $now         = time();
            return floor(($tgl_selesai - $now)/ (60*60*24)) * -1; */
            $renja = Tujuan::
                            leftjoin('db_pare_2018.renja_sasaran AS sasaran', function($join) {  $join   ->on('sasaran.tujuan_id','=','renja_tujuan.id');}) 
                            ->leftjoin('db_pare_2018.renja_indikator_sasaran AS indikator_sasaran', function($join) { $join   ->on('indikator_sasaran.sasaran_id','=','sasaran.id');})                
                            ->SELECT('sasaran.id AS sasarann_id', 'indikator_sasaran.id AS indikator_sasaran_id','indikator_sasaran.target AS indikator_sasaran_target')
                            ->WHERE('renja_tujuan.renja_id','=',$x->renja_id)
                            ->get();
             
                    $no = 0 ;
                    $percentage = 0 ;
                    foreach ($renja as $xt) {
                        $no++;    
                        $percentage += $this->hitung_percentage_realisasi_indikator_sasaran_triwulan($x->renja_id,4,$xt->indikator_sasaran_id,$xt->indikator_sasaran_target);                    	
                    }	

                    if ($no > 0 ){
                        return Pustaka::persen2($percentage,$no);
                    }else{
                        return '';
                    }
        });

        if ($keyword = $request->get('search')['value']) {
            $datatables->filterColumn('rownum', 'whereRawx', '@rownum  + 1 like ?', ["%{$keyword}%"]);
        } 
        

    return $datatables->make(true);
    }


    public function UnAuthAdministratorCapaianPKTriwulanList(Request $request)  
    {
    
        $dt = Renja::
                    leftjoin('db_pare_2018.periode AS periode', function($join){
                        $join   ->on('renja.periode_id','=','periode.id');
                    }) 
                    ->leftjoin('demo_asn.m_skpd AS skpd', function($join) { 
                        $join   ->on('renja.skpd_id','=','skpd.id');
                        
                    })  
                    //CAPAIAN TRIWULAN I
                    ->leftjoin('db_pare_2018.capaian_pk_triwulan AS triwulan1', function($join){
                        $join   ->on('triwulan1.renja_id','=','renja.id');
                        $join   ->where('triwulan1.triwulan','=','1');
                    })
                     //CAPAIAN TRIWULAN II
                    ->leftjoin('db_pare_2018.capaian_pk_triwulan AS triwulan2', function($join){
                        $join   ->on('triwulan2.renja_id','=','renja.id');
                        $join   ->where('triwulan2.triwulan','=','2');
                    })
                    //CAPAIAN TRIWULAN III
                    ->leftjoin('db_pare_2018.capaian_pk_triwulan AS triwulan3', function($join){
                        $join   ->on('triwulan3.renja_id','=','renja.id');
                        $join   ->where('triwulan3.triwulan','=','3');
                    })
                     //CAPAIAN TRIWULAN IV
                    ->leftjoin('db_pare_2018.capaian_pk_triwulan AS triwulan4', function($join){
                        $join   ->on('triwulan4.renja_id','=','renja.id');
                        $join   ->where('triwulan4.triwulan','=','4');
                    })
                    ->SELECT(   
                                'renja.id AS renja_id',
                                'renja.send_to_kaban',
                                'renja.kepala_skpd_id',
                                'renja.nama_kepala_skpd',
                                'renja.status_approve',
                                'periode.label AS periode_label',
                                'periode.awal AS awal',
                                'skpd.skpd AS nama_skpd',

                                'triwulan1.id AS capaian_pk_triwulan1_id',
                                'triwulan2.id AS capaian_pk_triwulan2_id',
                                'triwulan3.id AS capaian_pk_triwulan3_id',
                                'triwulan4.id AS capaian_pk_triwulan4_id',
                                'triwulan1.status AS capaian_pk_triwulan1_status',
                                'triwulan2.status AS capaian_pk_triwulan2_status',
                                'triwulan3.status AS capaian_pk_triwulan3_status',
                                'triwulan4.status AS capaian_pk_triwulan4_status'
                            )
                    ->WHERE('periode.id', 6 )
                    ->ORDERBY('skpd.id','ASC')
                    ->get();
        //return $dt;

        
        $datatables = Datatables::of($dt)
        
        ->addColumn('periode', function ($x) {
            return $x->periode_label;
        })->addColumn('nama_skpd', function ($x) {
            return Pustaka::capital_string($x->nama_skpd);
        })->addColumn('nama_kepala_skpd', function ($x) {
            return $x->nama_kepala_skpd;
        })
        ->addColumn('capaian_triwulan1', function ($x){
           /*  $tahun = Pustaka::tahun($x->awal);
            $tgl_selesai = strtotime($tahun."-04-01");
            $now         = time();
            return floor(($tgl_selesai - $now)/ (60*60*24)) * -1; */
            $renja = Tujuan::
                            leftjoin('db_pare_2018.renja_sasaran AS sasaran', function($join) {  $join   ->on('sasaran.tujuan_id','=','renja_tujuan.id');}) 
                            ->leftjoin('db_pare_2018.renja_indikator_sasaran AS indikator_sasaran', function($join) { $join   ->on('indikator_sasaran.sasaran_id','=','sasaran.id');})                
                            ->SELECT('sasaran.id AS sasarann_id', 'indikator_sasaran.id AS indikator_sasaran_id','indikator_sasaran.target AS indikator_sasaran_target')
                            ->WHERE('renja_tujuan.renja_id','=',$x->renja_id)
                            ->get();
             
                    $no = 0 ;
                    $percentage = 0 ;
                    foreach ($renja as $xt) {
                        $no++;    
                        $percentage += $this->hitung_percentage_realisasi_indikator_sasaran_triwulan($x->renja_id,1,$xt->indikator_sasaran_id,$xt->indikator_sasaran_target);                    	
                    }	

                    if ($no > 0 ){
                        return Pustaka::persen2($percentage,$no);
                    }else{
                        return '';
                    }
                    
                
                  
                
        })
        ->addColumn('capaian_triwulan2', function ($x){
            /* $tahun = Pustaka::tahun($x->awal);
            $tgl_selesai = strtotime($tahun."-07-01");
            $now         = time();
            return floor(($tgl_selesai - $now)/ (60*60*24)) * -1; */
            $renja = Tujuan::
                            leftjoin('db_pare_2018.renja_sasaran AS sasaran', function($join) {  $join   ->on('sasaran.tujuan_id','=','renja_tujuan.id');}) 
                            ->leftjoin('db_pare_2018.renja_indikator_sasaran AS indikator_sasaran', function($join) { $join   ->on('indikator_sasaran.sasaran_id','=','sasaran.id');})                
                            ->SELECT('sasaran.id AS sasarann_id', 'indikator_sasaran.id AS indikator_sasaran_id','indikator_sasaran.target AS indikator_sasaran_target')
                            ->WHERE('renja_tujuan.renja_id','=',$x->renja_id)
                            ->get();
             
                    $no = 0 ;
                    $percentage = 0 ;
                    foreach ($renja as $xt) {
                        $no++;    
                        $percentage += $this->hitung_percentage_realisasi_indikator_sasaran_triwulan($x->renja_id,2,$xt->indikator_sasaran_id,$xt->indikator_sasaran_target);                    	
                    }	

                    if ($no > 0 ){
                        return Pustaka::persen2($percentage,$no);
                    }else{
                        return '';
                    }
        })
        ->addColumn('capaian_triwulan3', function ($x){
            /* $tahun = Pustaka::tahun($x->awal);
            $tgl_selesai = strtotime($tahun."-10-01");
            $now         = time();
            return floor(($tgl_selesai - $now)/ (60*60*24)) * -1; */
            $renja = Tujuan::
                            leftjoin('db_pare_2018.renja_sasaran AS sasaran', function($join) {  $join   ->on('sasaran.tujuan_id','=','renja_tujuan.id');}) 
                            ->leftjoin('db_pare_2018.renja_indikator_sasaran AS indikator_sasaran', function($join) { $join   ->on('indikator_sasaran.sasaran_id','=','sasaran.id');})                
                            ->SELECT('sasaran.id AS sasarann_id', 'indikator_sasaran.id AS indikator_sasaran_id','indikator_sasaran.target AS indikator_sasaran_target')
                            ->WHERE('renja_tujuan.renja_id','=',$x->renja_id)
                            ->get();
             
                    $no = 0 ;
                    $percentage = 0 ;
                    foreach ($renja as $xt) {
                        $no++;    
                        $percentage += $this->hitung_percentage_realisasi_indikator_sasaran_triwulan($x->renja_id,3,$xt->indikator_sasaran_id,$xt->indikator_sasaran_target);                    	
                    }	

                    if ($no > 0 ){
                        return Pustaka::persen2($percentage,$no);
                    }else{
                        return '';
                    }
        })
        ->addColumn('capaian_triwulan4', function ($x){
           /*  $tahun = Pustaka::tahun($x->awal);
            $tgl_selesai = strtotime(($tahun+1)."-01-01");
            $now         = time();
            return floor(($tgl_selesai - $now)/ (60*60*24)) * -1; */
            $renja = Tujuan::
                            leftjoin('db_pare_2018.renja_sasaran AS sasaran', function($join) {  $join   ->on('sasaran.tujuan_id','=','renja_tujuan.id');}) 
                            ->leftjoin('db_pare_2018.renja_indikator_sasaran AS indikator_sasaran', function($join) { $join   ->on('indikator_sasaran.sasaran_id','=','sasaran.id');})                
                            ->SELECT('sasaran.id AS sasarann_id', 'indikator_sasaran.id AS indikator_sasaran_id','indikator_sasaran.target AS indikator_sasaran_target')
                            ->WHERE('renja_tujuan.renja_id','=',$x->renja_id)
                            ->get();
             
                    $no = 0 ;
                    $percentage = 0 ;
                    foreach ($renja as $xt) {
                        $no++;    
                        $percentage += $this->hitung_percentage_realisasi_indikator_sasaran_triwulan($x->renja_id,4,$xt->indikator_sasaran_id,$xt->indikator_sasaran_target);                    	
                    }	

                    if ($no > 0 ){
                        return Pustaka::persen2($percentage,$no);
                    }else{
                        return '';
                    }
        });

        if ($keyword = $request->get('search')['value']) {
            $datatables->filterColumn('rownum', 'whereRawx', '@rownum  + 1 like ?', ["%{$keyword}%"]);
        } 
        

    return $datatables->make(true);
    }


    public function Store(Request $request)
	{
        $messages = [
                 'renja_id.required'                   => 'Harus diisi',
                 'triwulan.required'                   => 'Harus diisi',
        ];

        $validator = Validator::make(
                        Input::all(),
                        array(
                            'renja_id'            => 'required',
                            'triwulan'            => 'required',
                        ),
                        $messages
        );
    
        if ( $validator->fails() ){
            return response()->json(['errors'=>$validator->messages()],422);
        }

            $capaian_pk_triwulan                         = new CapaianPKTriwulan;
            $capaian_pk_triwulan->renja_id               = Input::get('renja_id');
            $capaian_pk_triwulan->triwulan               = Input::get('triwulan');
            
    
            if ( $capaian_pk_triwulan->save()){
                return \Response::make($capaian_pk_triwulan->id, 200);
            }else{
                return \Response::make('error', 500);
            } 
    } 

}
