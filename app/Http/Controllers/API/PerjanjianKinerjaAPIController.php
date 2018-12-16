<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Periode;
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

class PerjanjianKinerjaAPIController extends Controller {


   

    public function SKPDPeriodePerjanjianKinerja(Request $request)
    {
            
        \DB::statement(\DB::raw('set @rownum='.$request->get('start')));
       
       
        $dt = PeriodeTahunan::leftjoin('perjanjian_kinerja','periode_tahunan.id','=','perjanjian_kinerja.periode_tahunan_id')
           
             ->select([   
                           
            \DB::raw('@rownum  := @rownum  + 1 AS rownum'), 
            'periode_tahunan.id AS periode_tahunan_id',
            'periode_tahunan.label',
            'periode_tahunan.status',
            'periode_tahunan.awal',
            'periode_tahunan.akhir',
            'perjanjian_kinerja.id AS perjanjian_kinerja_id',
            'perjanjian_kinerja.publish AS perjanjian_kinerja_status'
            
            ])
            ->orderBy('periode_tahunan.id', 'ASC')
            ->get();

       
            $datatables = Datatables::of($dt)
           ->addColumn('periode_tahunan', function ($x) {
                return $x->label;
            }) 
            ->addColumn('masa_periode', function ($x) {
                $masa_periode = Pustaka::balik2($x->awal). ' s.d ' . Pustaka::balik2($x->akhir);
                return  $masa_periode ;
            }) 
            ->editColumn('action', function ($x){

               
                if ( $x->perjanjian_kinerja_id != null )
                {
                    
                    if ( $x->perjanjian_kinerja_status == '0'){
                        return 	'<a href="edit-perjanjian-kinerja/'.$x->perjanjian_kinerja_id.'/sasaran-perjanjian-kinerja" class="btn btn-xs btn-info" style="margin:2px;width:90px;"><i class="fa fa-pencil"></i> Edit</a>';
                    }else{
                        return 	'<a href="perjanjian-kinerja/'.$x->perjanjian_kinerja_id.'" class="btn btn-xs btn-primary" style="margin:2px;width:90px;"><i class="fa fa-eye"></i> Lihat</a>';
                    }
                    
                }else{
                    //--- show create button
                    return 	'<a href="#" data-toggle="modal" data-target=".create-perjanjian_kinerja_confirm" data-url="simpan-perjanjian-kinerja" data-id="'.$x->periode_tahunan_id.'" data-label="'.$x->label.'"  class="btn btn-xs btn-success create" style="margin:2px;width:90px;"><i class="fa fa-plus"></i> Create </a>';
                }   
            });
    
            if ($keyword = $request->get('search')['value']) {
                $datatables->filterColumn('rownum', 'whereRawx', '@rownum  + 1 like ?', ["%{$keyword}%"]);
            } 
            
    
        return $datatables->make(true);
        //return $this->sendResponse($datatables->make(true),'sukses');
        
    }


    public function SKPDPerjanjianKinerjaBreadcrumb(Request $request)
    {
        
        $perjanjian_kinerja	= PerjanjianKinerja::where('id', '=', Request('perjanjian_kinerja_id') )->firstOrFail();

        $data            = SasaranPerjanjianKinerja::where('perjanjian_kinerja_id',$perjanjian_kinerja->id);
        $sasaran         = $data->count();


        
        $jm_indikator_sasaran   = 0;
        $jm_program             = 0 ;
        $jm_indikator_program   = 0 ;
        $jm_kegiatan            = 0 ;
        $jm_indikator_kegiatan  = 0 ;
        $publish_status         = 1 ;

        if ( $sasaran == 0){
            $publish_status =  $publish_status * 0;
        }

        //JUMLAH INDIKATOR SASARAN
        foreach ( $data->get() as $dt) {
            $ind_sasaran = IndikatorSasaran::where('sasaran_perjanjian_kinerja_id',$dt->id);

            //JUMLAH PROGRAM
            foreach( $ind_sasaran->get() as  $x ) {
                $program = Program::where('indikator_sasaran_id',$x->id);

                //JUMLAH INDIKATOR PROGRAM
                foreach( $program->get() as  $y ) {
                    $indikator_program = IndikatorProgram::where('program_id',$y->id);

                    //JUMLAH KEGIATAN
                    foreach( $indikator_program->get() as  $z ) {
                        $kegiatan = Kegiatan::where('indikator_program_id',$z->id);

                        //JUMLAH INDIKATOR KEGIATAN
                        foreach( $kegiatan->get() as  $a ) {
                            $indikator_kegiatan = IndikatorKegiatan::where('kegiatan_id',$a->id);
                            $jm_indikator_kegiatan = $jm_indikator_kegiatan+$indikator_kegiatan->count();
                            if ( $indikator_kegiatan->count() == 0 ){
                                $publish_status =  $publish_status * 0;
                            }
                        }  
                        $jm_kegiatan = $jm_kegiatan+$kegiatan->count();
                        if ( $kegiatan->count() == 0 ){
                            $publish_status =  $publish_status * 0;
                        }
                    }  
                    $jm_indikator_program = $jm_indikator_program+$indikator_program->count();
                    if ( $indikator_program->count() == 0 ){
                        $publish_status =  $publish_status * 0;
                    }
                }  
                $jm_program = $jm_program+$program->count();
                if ( $program->count() == 0 ){
                    $publish_status =  $publish_status * 0;
                }
            } 

            $jm_indikator_sasaran = $jm_indikator_sasaran+$ind_sasaran->count();
            if ( $ind_sasaran->count() == 0 ){
                $publish_status =  $publish_status * 0;
            }
            
        }

        

        return ( [
            //'perjanjian_kinerja_id'=> $perjanjian_kinerja,
            'data'                 => $data->select('id')->get(),
            'sasaran'              => $sasaran,
            'indikator_sasaran'    => $jm_indikator_sasaran,
            'program'              => $jm_program,
            'indikator_program'    => $jm_indikator_program,
            'kegiatan'             => $jm_kegiatan,
            'indikator_kegiatan'   => $jm_indikator_kegiatan,
            'publish_status'       => $publish_status,
            
              ]);
        
    }



    public function Store()
    {

        $pk = new PerjanjianKinerja;
        $pk->skpd_id                 = Input::get('skpd_id');
        $pk->periode_tahunan_id      = Input::get('periode_tahunan_id');
        $pk->active                  = '0';

        

        if ( $pk->save()){
            return \Response::make('sukses', 200);
        }else{
            return \Response::make('error', 500);
        }
        
       
    }






}
