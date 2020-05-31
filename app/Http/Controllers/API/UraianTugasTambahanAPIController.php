<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;

use App\Models\TugasTambahan;
use App\Models\UraianTugasTambahan;
use App\Helpers\Pustaka;


use Datatables;
use Validator;
use Input;



class UraianTugasTambahanAPIController extends Controller {


   

    
    public function UraianTugasTambahanList(Request $request)
    {
            
        $dt = UraianTugasTambahan::
                                leftjoin('db_pare_2018.skp_tahunan_tugas_tambahan AS tugas_tambahan', function($join){
                                    $join   ->on('tugas_tambahan.id','=','uraian_tugas_tambahan.tugas_tambahan_id');
                                })
                                ->select([   
                                    'uraian_tugas_tambahan.id AS uraian_tugas_tambahan_id',
                                    'uraian_tugas_tambahan.label AS uraian_tugas_tambahan_label',
                                    'uraian_tugas_tambahan.target AS uraian_tugas_tambahan_target',
                                    'uraian_tugas_tambahan.satuan AS uraian_tugas_tambahan_satuan',
                                    'tugas_tambahan.label AS tugas_tambahan_label'
                                ])
                                ->ORDERBY('tugas_tambahan.id','ASC')
                                ->where('skp_bulanan_id', '=' ,$request->get('skp_bulanan_id'))
                                ->get();

        $datatables = Datatables::of($dt)
                    ->addColumn('id', function ($x) {
                        return $x->uraian_tugas_tambahan_id;
                    })
                    ->addColumn('tugas_tambahan_label', function ($x) {
                        return $x->tugas_tambahan_label;
                    })
                    ->addColumn('label', function ($x) {
                        return $x->uraian_tugas_tambahan_label;
                    })
                    ->addColumn('output', function ($x) {
                        return $x->uraian_tugas_tambahan_target.' '.$x->uraian_tugas_tambahan_satuan;
                    });

                    if ($keyword = $request->get('search')['value']) {
                        $datatables->filterColumn('rownum', 'whereRawx', '@rownum  + 1 like ?', ["%{$keyword}%"]);
                    } 
        return $datatables->make(true);
    }

    

    public function Store(Request $request)
    {

        $messages = [
                'skp_bulanan_id.required'           => 'Harus diisi',
                'tugas_tambahan_id.required'        => 'Harus diisi',
                'target.required'                   => 'Harus diisi',
                'satuan.required'                   => 'Harus diisi',

        ];

        $validator = Validator::make(
                        Input::all(),
                        array(
                            'skp_bulanan_id'    => 'required',
                            'tugas_tambahan_id' => 'required',
                            'label'             => 'required',
                            'target'            => 'required',
                            'satuan'            => 'required',
                            
                        ),
                        $messages
        );

        if ( $validator->fails() ){
            //$messages = $validator->messages();
            return response()->json(['errors'=>$validator->messages()],422);
            
        }


        $sr    = new UraianTugasTambahan;

        $sr->skp_bulanan_id        = Input::get('skp_bulanan_id');
        $sr->tugas_tambahan_id     = Input::get('tugas_tambahan_id');
        $sr->label                 = Input::get('label');
        $sr->target                = Input::get('target');
        $sr->satuan                = Input::get('satuan');

        if ( $sr->save()){
            return \Response::make('sukses', 200);
        }else{
            return \Response::make('error', 500);
        } 
            
            
    
    }

    public function Detail(Request $request)
    {
       
        
        $x = UraianTugasTambahan::
                            leftjoin('db_pare_2018.skp_tahunan_tugas_tambahan AS tugas_tambahan', function($join){
                                $join   ->on('tugas_tambahan.id','=','uraian_tugas_tambahan.tugas_tambahan_id');
                            })
                            ->SELECT(    'uraian_tugas_tambahan.id AS uraian_tugas_tambahan_id',
                                        'uraian_tugas_tambahan.tugas_tambahan_id AS tugas_tambahan_id',
                                        'uraian_tugas_tambahan.skp_bulanan_id',
                                        'uraian_tugas_tambahan.label',
                                        'uraian_tugas_tambahan.target',
                                        'uraian_tugas_tambahan.satuan',
                                        'tugas_tambahan.label AS tugas_tambahan_label'

                                    ) 
                            ->WHERE('uraian_tugas_tambahan.id', $request->uraian_tugas_tambahan_id)
                            ->first();
     
		//return  $tugas_tambahan;
        $uraian_tugas_tambahan = array(
            'id'                    => $x->uraian_tugas_tambahan_id,
            'tugas_tambahan_id'     => $x->tugas_tambahan_id,
            'tugas_tambahan_label'  => $x->tugas_tambahan_label,
            'skp_bulanan_id'        => $x->skp_bulanan_id,
            'label'                 => $x->label,
            'output'                => $x->target.' '.$x->satuan,
            'satuan'                => $x->satuan,
            'target'                => $x->target
            
        );
        return $uraian_tugas_tambahan;
    }

    public function Update(Request $request)
    {

        $messages = [
                    'uraian_tugas_tambahan_id.required' => 'Harus diisi',
                    'tugas_tambahan_id.required'        => 'Harus diisi',
                    'label.required'                    => 'Harus diisi',
                    'target.required'                   => 'Harus diisi',
                    'satuan.required'                   => 'Harus diisi',


        ];

        $validator = Validator::make(
                        Input::all(),
                        array(
                            'uraian_tugas_tambahan_id'  => 'required',
                            'tugas_tambahan_id'         => 'required',
                            'label'                     => 'required',
                            'target'                    => 'required',
                            'satuan'                    => 'required',
                            
                            
                        ),
                        $messages
        );

        if ( $validator->fails() ){
            //$messages = $validator->messages();
            return response()->json(['errors'=>$validator->messages()],422);
            
        }

        
        $sr    = UraianTugasTambahan::find(Input::get('uraian_tugas_tambahan_id'));
        if (is_null($sr)) {
            return $this->sendError('Uraian Tugas Tambahan Tidak ditemukan.');
        }


        $sr->tugas_tambahan_id     = Input::get('tugas_tambahan_id');
        $sr->label                 = Input::get('label');
        $sr->target                = Input::get('target');
        $sr->satuan                = Input::get('satuan');
       

        if ( $sr->save()){
            return \Response::make('sukses', 200);
        }else{
            return \Response::make('error', 500);
        } 
            
            

    
    }



    public function Destroy(Request $request)
    {

        $messages = [
                'uraian_tugas_tambahan_id.required'   => 'Harus diisi',
        ];

        $validator = Validator::make(
                        Input::all(),
                        array(
                            'uraian_tugas_tambahan_id'   => 'required',
                        ),
                        $messages
        );

        if ( $validator->fails() ){
            //$messages = $validator->messages();
            return response()->json(['errors'=>$validator->messages()],422);
            
        }

        
        $sr    = UraianTugasTambahan::find(Input::get('uraian_tugas_tambahan_id'));
        if (is_null($sr)) {
            return $this->sendError('Uraian Tugas Tambahan tidak ditemukan.');
        }


        if ( $sr->delete()){
            return \Response::make('sukses', 200);
        }else{
            return \Response::make('error', 500);
        } 
            
            
    
    }
   

}
