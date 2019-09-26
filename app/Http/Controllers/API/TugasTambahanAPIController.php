<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;

use App\Models\TugasTambahan;


use Datatables;
use Validator;
use Input;


class TugasTambahanAPIController extends Controller {


   
    public function TugasTambahanList(Request $request)
    {
            
        $dt = TugasTambahan::where('capaian_tahunan_id', '=' ,$request->get('capaian_tahunan_id'))
                                ->select([   
                                    'id AS tugas_tambahan_id',
                                    'label AS tugas_tambahan_label',
                                    'nilai AS tugas_tambahan_nilai'
                                ])
                                ->get();

        $datatables = Datatables::of($dt)
                    ->addColumn('tugas_tambahan_label', function ($x) {
                        return $x->tugas_tambahan_label;
                    })
                    ->addColumn('action', function ($x) {
                        return $x->tugas_tambahan_id;
                    });

                    if ($keyword = $request->get('search')['value']) {
                        $datatables->filterColumn('rownum', 'whereRawx', '@rownum  + 1 like ?', ["%{$keyword}%"]);
                    } 
        return $datatables->make(true);
    }

    public function TugasTambahanDetail(Request $request)
    {
       
        
        $x = TugasTambahan::
                SELECT(     'tugas_tambahan.id AS tugas_tambahan_id',
                            'tugas_tambahan.label',
                            'tugas_tambahan.nilai'

                                    ) 
                            ->WHERE('tugas_tambahan.id', $request->tugas_tambahan_id)
                            ->first();

		
        $tugas_tambahan = array(
            'id'            => $x->tugas_tambahan_id,
            'label'         => $x->label

        );
        return $tugas_tambahan;
    }

    public function Store(Request $request)
    {

        $messages = [
                'capaian_tahunan_id.required'           => 'Harus diisi',
                'label.required'                         => 'Harus diisi',

        ];

        $validator = Validator::make(
                        Input::all(),
                        array(
                            'capaian_tahunan_id'        => 'required',
                            'label'                     => 'required',
                        ),
                        $messages
        );

        if ( $validator->fails() ){
            //$messages = $validator->messages();
            return response()->json(['errors'=>$validator->messages()],422);
            
        }


        $sr    = new TugasTambahan;

        $sr->capaian_tahunan_id        = Input::get('capaian_tahunan_id');
        $sr->label                      = Input::get('label');

        if ( $sr->save()){
            return \Response::make('sukses', 200);
        }else{
            return \Response::make('error', 500);
        } 
            
            
    
    }

    public function Update(Request $request)
    {

        $messages = [
                'tugas_tambahan_id.required'        => 'Harus diisi',
                'label.required'                    => 'Harus diisi',


        ];

        $validator = Validator::make(
                        Input::all(),
                        array(
                            'tugas_tambahan_id'     => 'required',
                            'label'                 => 'required',
                            
                        ),
                        $messages
        );

        if ( $validator->fails() ){
            //$messages = $validator->messages();
            return response()->json(['errors'=>$validator->messages()],422);
            
        }

        
        $sr    = TugasTambahan::find(Input::get('tugas_tambahan_id'));
        if (is_null($sr)) {
            return $this->sendError('TugasTambahan Tidak ditemukan.');
        }


        $sr->label             = Input::get('label');


        if ( $sr->save()){
            return \Response::make('sukses', 200);
        }else{
            return \Response::make('error', 500);
        } 
            
            

    
    }



    public function Destroy(Request $request)
    {

        $messages = [
                'tugas_tambahan_id.required'   => 'Harus diisi',
        ];

        $validator = Validator::make(
                        Input::all(),
                        array(
                            'tugas_tambahan_id'   => 'required',
                        ),
                        $messages
        );

        if ( $validator->fails() ){
            //$messages = $validator->messages();
            return response()->json(['errors'=>$validator->messages()],422);
            
        }

        
        $sr    = TugasTambahan::find(Input::get('tugas_tambahan_id'));
        if (is_null($sr)) {
            return $this->sendError('TugasTambahan tidak ditemukan.');
        }


        if ( $sr->delete()){
            return \Response::make('sukses', 200);
        }else{
            return \Response::make('error', 500);
        } 
            
            
    
    }
   

}
