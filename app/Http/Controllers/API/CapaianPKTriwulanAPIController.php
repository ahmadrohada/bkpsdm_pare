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
use App\Models\Pegawai;


use App\Helpers\Pustaka;

use Datatables;
use Validator;
use Input;

class CapaianPKTriwulanAPIController extends Controller {

  
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
                                'periode.awal AS awal'
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

}
