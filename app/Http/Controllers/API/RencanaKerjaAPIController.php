<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\PeriodeTahunan;
use App\Models\PerjanjianKinerja;
use App\Models\SasaranPerjanjianKinerja;
use App\Models\IndikatorSasaran;
use App\Models\Program;
use App\Models\IndikatorProgram;
use App\Models\Kegiatan;
use App\Models\IndikatorKegiatan;
use App\Helpers\Pustaka;

use Datatables;
use Validator;
use Gravatar;
use Input;
Use Alert;

class RencanaKerjaAPIController extends Controller {


    public function skpd_rencana_kerja_list(Request $request)
    {
       
        
        $dt = \DB::table('db_pare_2018.rencana_kerja AS rkpd')
                //PERIODE
                ->join('db_pare_2018.periode_rkpd AS periode', function($join){
                    $join   ->on('periode.id','=','rkpd.periode_rkpd_id');
                    
                })

                //ID KEPALA SKPD
                ->leftjoin('demo_asn.tb_history_jabatan AS id_ka_skpd', function($join){
                    $join   ->on('id_ka_skpd.id','=','rkpd.history_jabatan_id');
                })
                //NAMA KEPALA SKPD
                ->leftjoin('demo_asn.tb_pegawai AS kepala_skpd', function($join){
                    $join   ->on('kepala_skpd.id','=','id_ka_skpd.id_pegawai');
                })
                
                ->select([  'rkpd.id AS rkpd_id',
                            'periode.label AS periode',
                            'kepala_skpd.nama',
                            'kepala_skpd.gelardpn',
                            'kepala_skpd.gelarblk',
                            'rkpd.status'
                                
                        ])
                ->where('rkpd.skpd_id','=', $request->skpd_id);
                
        



        $datatables = Datatables::of($dt)
        ->addColumn('status', function ($x) {

            return $x->status;

        })->addColumn('periode', function ($x) {
            
            return $x->periode;
        
        })->addColumn('kepala_skpd', function ($x) {
            
            return Pustaka::nama_pegawai($x->gelardpn , $x->nama , $x->gelarblk);
        
        })->addColumn('skpd', function ($x) {
            
            //return Pustaka::capital_string($x->skpd);
        
        });

        
        if ($keyword = $request->get('search')['value']) {
            $datatables->filterColumn('rownum', 'whereRaw', '@rownum  + 1 like ?', ["%{$keyword}%"]);
        } 

        return $datatables->make(true);
        
    }

   
}
