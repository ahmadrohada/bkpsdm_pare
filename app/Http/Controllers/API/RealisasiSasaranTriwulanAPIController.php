<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller; 
use Illuminate\Http\Request;

use App\Models\Tujuan;
use App\Models\Sasaran;
use App\Models\IndikatorSasaran;

use App\Models\RealisasiSasaranTriwulan;
use App\Models\RealisasiIndikatorSasaranTriwulan;


use App\Helpers\Pustaka;

use Datatables;
use Validator;
use Input;

class RealisasiSasaranTriwulanAPIController extends Controller {


    public function RealisasiSasaranTriwulan(Request $request) 
    {


        $capaian_id     = $request->capaian_pk_triwulan_id;
        $renja_id       = $request->renja_id;

        $dt = Tujuan:: 
                        leftjoin('db_pare_2018.renja_sasaran AS sasaran', function($join){
                            $join   ->on('sasaran.tujuan_id','=','renja_tujuan.id');
                        })
                        //INDIKATOR SASARAN
                        ->leftjoin('db_pare_2018.renja_indikator_sasaran AS indikator_sasaran', function($join){
                            $join   ->on('indikator_sasaran.sasaran_id','=','sasaran.id');
                        })
                         
                       
                        //LEFT JOIN TERHADAP REALISASI SASARAN
                        ->leftjoin('db_pare_2018.realisasi_sasaran_triwulan AS realisasi_sasaran', function($join) use ( $capaian_id ){
                            $join   ->on('realisasi_sasaran.sasaran_id','=','sasaran.id');
                            $join   ->WHERE('realisasi_sasaran.capaian_id','=',  $capaian_id );
                        })
                        //LEFT JOIN TERHADAP REALISASI INDIKATOR SASARAN
                        ->leftjoin('db_pare_2018.realisasi_indikator_sasaran_triwulan AS realisasi_indikator', function($join) use ( $capaian_id ){
                            $join   ->on('realisasi_indikator.indikator_sasaran_id','=','indikator_sasaran.id');
                            $join   ->WHERE('realisasi_indikator.capaian_id','=',  $capaian_id );
                            
                        })

                        ->WHERE('renja_tujuan.renja_id',$renja_id)
                        ->select([   
                            'sasaran.id AS sasaran_id',
                            'sasaran.label AS sasaran_label',
                            'indikator_sasaran.id AS indikator_sasaran_id',
                            'indikator_sasaran.label AS indikator_label',
                            'indikator_sasaran.target AS target',
                            'indikator_sasaran.satuan AS satuan',

                            //realisasi
                            'realisasi_indikator.id AS realisasi_indikator_id',
                            'realisasi_indikator.target_quantity AS realisasi_indikator_target_quantity',
                            'realisasi_indikator.realisasi_quantity AS realisasi_indikator_realisasi_quantity',
                            'realisasi_indikator.satuan AS realisasi_indikator_satuan',
    
                            'realisasi_sasaran.id AS realisasi_sasaran_id',
                            'realisasi_sasaran.jumlah_indikator'

                            ])
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
    
    
    
    public function AddRealisasiSasaranTriwulan(Request $request)
    {
       
        $capaian_id = $request->capaian_id;
        $indikator_sasaran_id = $request->indikator_sasaran_id;

        $x = IndikatorSasaran::
                            leftjoin('db_pare_2018.renja_sasaran AS renja_sasaran', function($join) {
                                $join   ->on('renja_indikator_sasaran.sasaran_id','=','renja_sasaran.id');
                            })
                           
                            //REALISASINYA SASARAN
                            ->leftjoin('db_pare_2018.realisasi_sasaran_triwulan AS realisasi_sasaran', function($join) use($capaian_id) {
                                $join   ->on('realisasi_sasaran.sasaran_id','=','renja_sasaran.id');
                                $join   ->WHERE('realisasi_sasaran.capaian_id','=', $capaian_id );
                            }) 
                            ->leftjoin('db_pare_2018.realisasi_indikator_sasaran_triwulan AS realisasi_indikator', function($join) use($capaian_id) {
                                $join   ->on('realisasi_indikator.indikator_sasaran_id','=','renja_indikator_sasaran.id');
                                $join   ->WHERE('realisasi_indikator.capaian_id','=', $capaian_id );
                            })
                            
                
                            ->SELECT(       'renja_sasaran.id AS sasaran_id',
                                            'renja_sasaran.label AS sasaran_label',


                                            'renja_indikator_sasaran.id AS indikator_sasaran_id',
                                            'renja_indikator_sasaran.label AS indikator_label',
                                            'renja_indikator_sasaran.target AS indikator_quantity',
                                            'renja_indikator_sasaran.satuan AS indikator_satuan',

                                            /* 'kegiatan_tahunan.id AS kegiatan_tahunan_id',
                                            'kegiatan_tahunan.label AS kegiatan_tahunan_label',
                                            'kegiatan_tahunan.quality AS kegiatan_tahunan_quality',
                                            'kegiatan_tahunan.cost AS kegiatan_tahunan_cost',
                                            'kegiatan_tahunan.target_waktu AS kegiatan_tahunan_target_waktu',
                                            'kegiatan_tahunan.angka_kredit AS kegiatan_tahunan_ak', */

                                            'realisasi_indikator.id AS realisasi_indikator_sasaran_id',
                                            'realisasi_indikator.target_quantity AS realisasi_indikator_target_quantity',
                                            'realisasi_indikator.realisasi_quantity AS realisasi_indikator_realisasi_quantity',
                                            'realisasi_indikator.satuan AS realisasi_indikator_satuan',

                                           
                                            'realisasi_sasaran.id AS realisasi_sasaran_id'
                                        



                                            
                                    ) 
                            ->WHERE('renja_indikator_sasaran.id', $indikator_sasaran_id)
                            ->first();

       
        $jm_indikator = IndikatorSasaran::WHERE('sasaran_id',$x->sasaran_id)->count();

       

        $ind_sasaran = array(
            'indikator_sasaran_id'      => $x->indikator_sasaran_id,
            'indikator_sasaran_label'   => $x->indikator_label,

            'sasaran_id'                => $x->sasaran_id,
            'sasaran_label'             => $x->sasaran_label,

            'realisasi_indikator_sasaran_triwulan_id'    => $x->realisasi_indikator_sasaran_id,
            'realisasi_sasaran_triwulan_id'    => $x->realisasi_sasaran_id,
            'jumlah_indikator'                  => $jm_indikator,

            

            'target_quantity'           => $x->realisasi_indikator_sasaran_id ? $x->realisasi_indikator_target_quantity : $x->indikator_quantity,
            'realisasi_quantity'        => $x->realisasi_indikator_realisasi_quantity,
            'satuan'                    => $x->realisasi_indikator_sasaran_id ? $x->realisasi_indikator_satuan : $x->indikator_satuan,


        ); 
        return $ind_sasaran; 
    }

    public function Store(Request $request)
    {

        $messages = [
                'capaian_triwulan_id.required'  => 'Harus diisi',
                'sasaran_id.required'           => 'Harus diisi',
                'indikator_sasaran_id.required' => 'Harus diisi',
                
                'target_quantity.required'     => 'Harus diisi',
                'realisasi_quantity.required'  => 'Harus diisi',
                'satuan.required'              => 'Harus diisi',

        ];

        $validator = Validator::make(
                        Input::all(),
                        array(
                            'capaian_triwulan_id'   => 'required',
                            'sasaran_id'            => 'required',
                            'indikator_sasaran_id'  => 'required',

                            'target_quantity'       => 'required|numeric|min:0',
                            'realisasi_quantity'    => 'required|numeric|min:0|max:'.$request->target_quantity,
                        ),
                        $messages
        );

        if ( $validator->fails() ){
            //$messages = $validator->messages();
            return response()->json(['errors'=>$validator->messages()],422);
            
        }


        $st_kt    = new RealisasiIndikatorSasaranTriwulan;

        $st_kt->indikator_sasaran_id    = Input::get('indikator_sasaran_id');
        $st_kt->capaian_id              = Input::get('capaian_triwulan_id');
        $st_kt->target_quantity         = Input::get('target_quantity');
        $st_kt->realisasi_quantity      = Input::get('realisasi_quantity');
        $st_kt->satuan                  = Input::get('satuan');
       

        if ( $st_kt->save()){


             //CARI REALISASI SASARAN NYA
             $rkt    = RealisasiSasaranTriwulan::WHERE('capaian_id','=',Input::get('capaian_triwulan_id'))
                                                ->WHERE('sasaran_id','=',Input::get('sasaran_id'))
                                                ->count();

            //jiki belum ada add new
            if ( $rkt == 0 ) {
            $rkt_save    = new RealisasiSasaranTriwulan;
            $rkt_save->capaian_id              = Input::get('capaian_triwulan_id');
            $rkt_save->sasaran_id              = Input::get('sasaran_id');
            $rkt_save->jumlah_indikator        = Input::get('jumlah_indikator');
            $rkt_save->save();

        //jika sudah ada update saja
        }else{

            $rkt_update                     = RealisasiSasaranTriwulan::find(Input::get('realisasi_sasaran_triwulan_id'));
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
                'realisasi_indikator_sasaran_triwulan_id.required'  => 'Harus diisi',
                'capaian_triwulan_id.required'                      => 'Harus diisi',
                'sasaran_id.required'                               => 'Harus diisi',
                'indikator_sasaran_id.required'                     => 'Harus diisi',
                'jumlah_indikator.required'                         => 'Harus diisi',

                'target_quantity.required'                          => 'Harus diisi',
                'realisasi_quantity.required'                       => 'Harus diisi',
                'satuan.required'                                   => 'Harus diisi',

                
        

        ];

        $validator = Validator::make(
                        Input::all(),
                        array(
                            'realisasi_indikator_sasaran_triwulan_id'   => 'required',
                            'capaian_triwulan_id'                       => 'required',
                            'sasaran_id'                                => 'required',
                            'indikator_sasaran_id'                      => 'required',
                            'jumlah_indikator'                          => 'required|numeric|min:1',

                            'target_quantity'                           => 'required|numeric|min:0',
                            'realisasi_quantity'                        => 'required|numeric|min:0|max:'.$request->target_quantity,
                            'satuan'                                    => 'required',


                        ),
                        $messages
        );

        if ( $validator->fails() ){
            //$messages = $validator->messages();
            return response()->json(['errors'=>$validator->messages()],422);
            
        }


        $st_update                          = RealisasiIndikatorSasaranTriwulan::find(Input::get('realisasi_indikator_sasaran_triwulan_id'));

        $st_update->target_quantity         = Input::get('target_quantity');
        $st_update->realisasi_quantity      = Input::get('realisasi_quantity');
        $st_update->satuan                  = Input::get('satuan');
    

        if ( $st_update->save()){

            //CARI REALISASI Sasaran NYA
            $rkt    = RealisasiSasaranTriwulan::WHERE('capaian_id','=',Input::get('capaian_triwulan_id'))
                                                ->WHERE('sasaran_id','=',Input::get('sasaran_id'))
                                                ->count();

             //jiki belum ada add new
             if ( $rkt == 0 ) {
                $rkt_save    = new RealisasiSasaranTriwulan;
                $rkt_save->capaian_id              = Input::get('capaian_triwulan_id');
                $rkt_save->sasaran_id              = Input::get('sasaran_id');
                $rkt_save->jumlah_indikator        = Input::get('jumlah_indikator');
                $rkt_save->save();
    
            //jika sudah ada update saja
            }else{
    
                $rkt_update                     = RealisasiSasaranTriwulan::find(Input::get('realisasi_sasaran_triwulan_id'));
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

        
        $st_kt    = RealisasiIndikatorSasaranTriwulan::find(Input::get('realisasi_indikator_id'));
        if (is_null($st_kt)) {
            return $this->sendError('Realisasi Indikator Sasaran tidak ditemukan.');
        }


        if ( $st_kt->delete()){
            //Saat indikator kegiatan di hapus.,cek dulu jumlah indikator 
            $capaian_id = $st_kt->capaian_id ;
            $data_uing = IndikatorSasaran::WHERE('sasaran_id',Input::get('sasaran_id'))
                                            //LEFT JOIN TERHADAP REALISASI INDIKATOR KEGIATAN
                                            ->join('db_pare_2018.realisasi_indikator_sasaran_triwulan AS realisasi_indikator', function($join) use($capaian_id) {
                                                $join   ->on('realisasi_indikator.indikator_sasaran_id','=','renja_indikator_sasaran.id');
                                                $join   ->WHERE('realisasi_indikator.capaian_id','=',  $capaian_id );
                                                
                                            })
                                            ->count();

            if ( $data_uing === 0 ){
                $del_ah    = RealisasiSasaranTriwulan::find(Input::get('realisasi_sasaran_id'));
                $del_ah->delete();
            }


            return \Response::make('sukses'. $data_uing  , 200);
        }else{
            return \Response::make('error', 500);
        } 
            
            
    
    } 
}
