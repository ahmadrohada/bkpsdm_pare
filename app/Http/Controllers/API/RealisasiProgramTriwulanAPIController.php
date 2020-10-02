<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller; 
use Illuminate\Http\Request;

use App\Models\Tujuan;
use App\Models\Program;
use App\Models\IndikatorProgram;


use App\Models\RealisasiProgramTriwulan;
use App\Models\RealisasiIndikatorProgramTriwulan;

use App\Helpers\Pustaka;

use Datatables;
use Validator;
use Input;

class RealisasiProgramTriwulanAPIController extends Controller {


    public function RealisasiProgramTriwulan(Request $request) 
    {

        $capaian_id     = $request->capaian_pk_triwulan_id;
        $renja_id       = $request->renja_id;

        $dt = Tujuan:: 
                        leftjoin('db_pare_2018.renja_sasaran AS sasaran', function($join){
                            $join   ->on('sasaran.tujuan_id','=','renja_tujuan.id');
                        })
                        ->leftjoin('db_pare_2018.renja_program AS program', function($join){
                            $join   ->on('program.sasaran_id','=','sasaran.id');
                        })
                        ->leftjoin('db_pare_2018.renja_indikator_program AS indikator_program', function($join){
                            $join   ->on('indikator_program.program_id','=','program.id');
                        })

                        //LEFT JOIN TERHADAP REALISASI PROGRAM
                        ->leftjoin('db_pare_2018.realisasi_program_triwulan AS realisasi_program', function($join) use ( $capaian_id ){
                            $join   ->on('realisasi_program.program_id','=','program.id');
                            $join   ->WHERE('realisasi_program.capaian_id','=',  $capaian_id );
                        })
                        //LEFT JOIN TERHADAP REALISASI INDIKATOR PROGRAM
                        ->leftjoin('db_pare_2018.realisasi_indikator_program_triwulan AS realisasi_indikator', function($join) use ( $capaian_id ){
                            $join   ->on('realisasi_indikator.indikator_program_id','=','indikator_program.id');
                            $join   ->WHERE('realisasi_indikator.capaian_id','=',  $capaian_id );
                            
                        })

                       
                        ->select([   
                            'program.id AS program_id',
                            'program.label AS program_label',
                            'indikator_program.id AS indikator_program_id',
                            'indikator_program.label AS indikator_program_label',
                            'indikator_program.target AS target',
                            'indikator_program.satuan AS satuan',

                            //realisasi
                            'realisasi_indikator.id AS realisasi_indikator_id',
                            'realisasi_indikator.target_quantity AS realisasi_indikator_target_quantity',
                            'realisasi_indikator.realisasi_quantity AS realisasi_indikator_realisasi_quantity',
                            'realisasi_indikator.satuan AS realisasi_indikator_satuan',
    
                            'realisasi_program.id AS realisasi_program_id',
                            'realisasi_program.jumlah_indikator'



                            ])
                            ->WHERE('renja_tujuan.renja_id',$renja_id)
                            ->get();

        $datatables = Datatables::of($dt)
                        ->addColumn('target', function ($x) {
                            return $x->target.' '.$x->satuan;
                        })
                        ->addColumn('realisasi_quantity', function ($x) {
                            return $x->realisasi_indikator_realisasi_quantity.' '.$x->realisasi_indikator_satuan;
                        })
                        ->addColumn('action', function ($x) {
                            return $x->sasaran_id;
                        });

                        if ($keyword = $request->get('search')['value']) {
                        $datatables->filterColumn('rownum', 'whereRawx', '@rownum  + 1 like ?', ["%{$keyword}%"]);
                        } 
                        return $datatables->make(true);




     
    } 
    

    public function AddRealisasiProgramTriwulan(Request $request)
    {
       
        $capaian_id = $request->capaian_id;
        $indikator_program_id = $request->indikator_program_id;

        $x = IndikatorProgram::
                            leftjoin('db_pare_2018.renja_program AS renja_program', function($join) {
                                $join   ->on('renja_indikator_program.program_id','=','renja_program.id');
                            })
                           
                            //REALISASINYA SASARAN
                            ->leftjoin('db_pare_2018.realisasi_program_triwulan AS realisasi_program', function($join) use($capaian_id) {
                                $join   ->on('realisasi_program.program_id','=','renja_program.id');
                                $join   ->WHERE('realisasi_program.capaian_id','=', $capaian_id );
                            }) 
                            ->leftjoin('db_pare_2018.realisasi_indikator_program_triwulan AS realisasi_indikator', function($join) use($capaian_id) {
                                $join   ->on('realisasi_indikator.indikator_program_id','=','renja_indikator_program.id');
                                $join   ->WHERE('realisasi_indikator.capaian_id','=', $capaian_id );
                            })
                            
                
                            ->SELECT(       'renja_program.id AS program_id',
                                            'renja_program.label AS program_label',


                                            'renja_indikator_program.id AS indikator_program_id',
                                            'renja_indikator_program.label AS indikator_label',
                                            'renja_indikator_program.target AS indikator_quantity',
                                            'renja_indikator_program.satuan AS indikator_satuan',

                                            'realisasi_indikator.id AS realisasi_indikator_program_id',
                                            'realisasi_indikator.target_quantity AS realisasi_indikator_target_quantity',
                                            'realisasi_indikator.realisasi_quantity AS realisasi_indikator_realisasi_quantity',
                                            'realisasi_indikator.satuan AS realisasi_indikator_satuan',

                                            'realisasi_program.id AS realisasi_program_id'
                                          
                                    ) 
                            ->WHERE('renja_indikator_program.id', $indikator_program_id)
                            ->first();

       
        $jm_indikator = IndikatorProgram::WHERE('program_id',$x->program_id)->count();

       

        $ind_program = array(
            'indikator_program_id'      => $x->indikator_program_id,
            'indikator_program_label'   => $x->indikator_label,

            'program_id'                => $x->program_id,
            'program_label'             => $x->program_label,

            'realisasi_indikator_program_triwulan_id'    => $x->realisasi_indikator_program_id,
            'realisasi_program_triwulan_id'    => $x->realisasi_program_id,
            'jumlah_indikator'                  => $jm_indikator,

            

            'target_quantity'           => $x->realisasi_indikator_program_id ? $x->realisasi_indikator_target_quantity : $x->indikator_quantity,
            'realisasi_quantity'        => $x->realisasi_indikator_realisasi_quantity,
            'satuan'                    => $x->realisasi_indikator_program_id ? $x->realisasi_indikator_satuan : $x->indikator_satuan,


        ); 
        return $ind_program; 
    }
    
    
    public function Store(Request $request)
    {

        $messages = [
                'capaian_triwulan_id.required'  => 'Harus diisi',
                'program_id.required'           => 'Harus diisi',
                'indikator_program_id.required' => 'Harus diisi',
                
                'target_quantity.required'     => 'Harus diisi',
                'realisasi_quantity.required'  => 'Harus diisi',
                'satuan.required'              => 'Harus diisi',

        ];

        $validator = Validator::make(
                        Input::all(),
                        array(
                            'capaian_triwulan_id'   => 'required',
                            'program_id'            => 'required',
                            'indikator_program_id'  => 'required',

                            'target_quantity'       => 'required|numeric|min:0',
                            //'realisasi_quantity'    => 'required|numeric|min:0|max:'.$request->target_quantity,
                            'realisasi_quantity'    => 'required|numeric|min:0',
                        ),
                        $messages
        );

        if ( $validator->fails() ){
            //$messages = $validator->messages();
            return response()->json(['errors'=>$validator->messages()],422);
            
        }


        $st_kt    = new RealisasiIndikatorProgramTriwulan;

        $st_kt->indikator_program_id    = Input::get('indikator_program_id');
        $st_kt->capaian_id              = Input::get('capaian_triwulan_id');
        $st_kt->target_quantity         = Input::get('target_quantity');
        $st_kt->realisasi_quantity      = Input::get('realisasi_quantity');
        $st_kt->satuan                  = Input::get('satuan');
       

        if ( $st_kt->save()){


             //CARI REALISASI SASARAN NYA
             $rkt    = RealisasiProgramTriwulan::WHERE('capaian_id','=',Input::get('capaian_triwulan_id'))
                                                ->WHERE('program_id','=',Input::get('program_id'))
                                                ->count();

            //jiki belum ada add new
            if ( $rkt == 0 ) {
            $rkt_save    = new RealisasiProgramTriwulan;
            $rkt_save->capaian_id              = Input::get('capaian_triwulan_id');
            $rkt_save->program_id              = Input::get('program_id');
            $rkt_save->jumlah_indikator        = Input::get('jumlah_indikator');
            $rkt_save->save();

        //jika sudah ada update saja
        }else{

            $rkt_update                     = RealisasiProgramTriwulan::find(Input::get('realisasi_program_triwulan_id'));
            $rkt_update->jumlah_indikator   = Input::get('jumlah_indikator');
            $rkt_update->save();
        }



            return \Response::make('sukses'+$rkt, 200);
        }else{
            return \Response::make('error', 500);
        } 
            
            
    
    } 

    public function Update(Request $request)
    {

            $messages = [
                'realisasi_indikator_program_triwulan_id.required'  => 'Harus diisi',
                'capaian_triwulan_id.required'                      => 'Harus diisi',
                'program_id.required'                               => 'Harus diisi',
                'indikator_program_id.required'                     => 'Harus diisi',
                'jumlah_indikator.required'                         => 'Harus diisi',

                'target_quantity.required'                          => 'Harus diisi',
                'realisasi_quantity.required'                       => 'Harus diisi',
                'satuan.required'                                   => 'Harus diisi',

                
        

        ];

        $validator = Validator::make(
                        Input::all(),
                        array(
                            'realisasi_indikator_program_triwulan_id'   => 'required',
                            'capaian_triwulan_id'                       => 'required',
                            'program_id'                                => 'required',
                            'indikator_program_id'                      => 'required',
                            'jumlah_indikator'                          => 'required|numeric|min:1',

                            'target_quantity'                           => 'required|numeric|min:0',
                            //'realisasi_quantity'                        => 'required|numeric|min:0|max:'.$request->target_quantity,
                            'realisasi_quantity'                        => 'required|numeric|min:0',
                            'satuan'                                    => 'required',


                        ),
                        $messages
        );

        if ( $validator->fails() ){
            //$messages = $validator->messages();
            return response()->json(['errors'=>$validator->messages()],422);
            
        }


        $st_update                          = RealisasiIndikatorProgramTriwulan::find(Input::get('realisasi_indikator_program_triwulan_id'));

        $st_update->target_quantity         = Input::get('target_quantity');
        $st_update->realisasi_quantity      = Input::get('realisasi_quantity');
        $st_update->satuan                  = Input::get('satuan');
    

        if ( $st_update->save()){

            //CARI REALISASI Program NYA
            $rkt    = RealisasiProgramTriwulan::WHERE('capaian_id','=',Input::get('capaian_triwulan_id'))
                                                ->WHERE('program_id','=',Input::get('program_id'))
                                                ->count();

             //jiki belum ada add new
             if ( $rkt == 0 ) {
                $rkt_save    = new RealisasiProgramTriwulan;
                $rkt_save->capaian_id              = Input::get('capaian_triwulan_id');
                $rkt_save->program_id              = Input::get('program_id');
                $rkt_save->jumlah_indikator        = Input::get('jumlah_indikator');
                $rkt_save->save();
    
            //jika sudah ada update saja
            }else{
    
                $rkt_update                     = RealisasiProgramTriwulan::find(Input::get('realisasi_program_triwulan_id'));
                $rkt_update->jumlah_indikator   = Input::get('jumlah_indikator');
                $rkt_update->save();
            }

            return \Response::make('sukses', 200);
        }else{
            return \Response::make('error', 500);
        } 
    } 

    public function Destroy(Request $request)
    {

        $messages = [
               
                'realisasi_indikator_id.required'      => 'Harus diisi',
        ];

        $validator = Validator::make(
                        Input::all(),
                        array(
                            'realisasi_indikator_id'   => 'required',
                        ),
                        $messages
        );

        if ( $validator->fails() ){
            //$messages = $validator->messages();
            return response()->json(['errors'=>$validator->messages()],422);
            
        }

        
        $st_kt    = RealisasiIndikatorProgramTriwulan::find(Input::get('realisasi_indikator_id'));
        if (is_null($st_kt)) {
            return $this->sendError('Realisasi Indikator Program tidak ditemukan.');
        }


        if ( $st_kt->delete()){
            //Saat indikator kegiatan di hapus.,cek dulu jumlah indikator 
            $capaian_id = $st_kt->capaian_id ;
            $data_uing = IndikatorProgram::WHERE('program_id',Input::get('program_id'))
                                            //LEFT JOIN TERHADAP REALISASI INDIKATOR KEGIATAN
                                            ->join('db_pare_2018.realisasi_indikator_program_triwulan AS realisasi_indikator', function($join) use($capaian_id) {
                                                $join   ->on('realisasi_indikator.indikator_program_id','=','renja_indikator_program.id');
                                                $join   ->WHERE('realisasi_indikator.capaian_id','=',  $capaian_id );
                                                
                                            })
                                            ->count();

            if ( $data_uing === 0 ){
                $del_ah    = RealisasiProgramTriwulan::find(Input::get('realisasi_program_id'));
                $del_ah->delete();
            }


            return \Response::make('sukses'. $data_uing  , 200);
        }else{
            return \Response::make('error', 500);
        } 
            
            
    
    } 
}
