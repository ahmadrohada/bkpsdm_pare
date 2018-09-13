<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\SasaranPerjanjianKinerja;
use App\Models\Sasaran;
use App\Models\IndikatorSasaran;
use App\Models\PerjanjianKinerja;
use App\Models\Kegiatan;
use App\Models\IndikatorProgram;
use App\Models\SKPD;
use App\Models\SKPTahunan;

use App\Helpers\Pustaka;

use Datatables;
use Validator;
use Gravatar;
use Input;
Use Alert;

class KegiatanSKPTahunanAPIController extends Controller {


   

    public function kegiatan_tugas_jabatan_list(Request $request)
    {
            
        $child_jabatan = SKPTahunan::where('id', $request->get('skp_tahunan_id'))->first()->pejabat_yang_dinilai->child_jabatan;
        $bawahan_list = [];
        foreach  ( $child_jabatan as $x){
            $bawahan_list[] =$x->id;
        } 
        
        
        \DB::statement(\DB::raw('set @rownum=0'));
        $dt = Kegiatan:: 
                whereHas('indikator_program' , function ($q) {
                   $q->whereHas('program',function($q2){
                       $q2->whereHas('indikator_sasaran',function($q3){
                            $q3->whereHas('sasaran_perjanjian_kinerja',function($q4){
                                $q4->where('perjanjian_kinerja_id', '40')->where('jabatan_id', '900');
                            });

                       });
                   });


                })
                ->leftjoin('kegiatan_skp_tahunan as keg', function($join)
                {
                    $join->on('keg.kegiatan_perjanjian_kinerja_id','=','kegiatan.id');
                    $join->Where('keg.skp_tahunan_id','=','11');
                })
               
                ->select([   
                    
                    \DB::raw('@rownum  := @rownum  + 1 AS rownum'), 
                    'kegiatan.id AS kegiatan_perjanjian_kinerja_id',
                    'kegiatan.label',
                    'kegiatan.indikator_program_id',
                    'kegiatan.jabatan_id',
                    'keg.label AS label_skp'
                    
                    ])
                ->whereIn('jabatan_id', $bawahan_list)
                
                ->orderBy('kegiatan.id', 'DESC')
                ->get();

                
                
        

        $datatables = Datatables::of($dt)
        ->addColumn('label', function ($x) {
            
            if ( $x->label_skp == null ){
                return $x->label;
            }else{
                return $x->label_skp;
            }
            

           
        
        })->addColumn('ak', function ($x) {

            
           
                return '-';
          
        
        })->addColumn('output', function ($x) {
            
                return '-';
           

        })->addColumn('mutu', function ($x) {
           
                return '-';
            

        })->addColumn('waktu', function ($x) {
           
                return '-';
           

        })->addColumn('biaya', function ($x) {
          
                return '-';
           
        })->addColumn('status', function ($x) {

           
                return '-';
           

        });


       
        
        if ($keyword = $request->get('search')['value']) {
            $datatables->filterColumn('rownum', 'whereRawx', '@rownum  + 1 like ?', ["%{$keyword}%"]);
        } 

        return $datatables->make(true); 
        
    }



}
