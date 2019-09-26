<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;

use App\Models\Kreativitas;


use Datatables;
use Validator;
use Input;


class KreativitasAPIController extends Controller {


   
    public function KreativitasList(Request $request)
    {
            
        $dt = Kreativitas::where('capaian_tahunan_id', '=' ,$request->get('capaian_tahunan_id'))
                                ->select([   
                                    'id AS kreativitas_id',
                                    'label AS kreativitas_label',
                                    'nilai AS kreativitas_nilai',
                                    'manfaat AS kreativitas_manfaat',
                                ])
                                ->get();

        $datatables = Datatables::of($dt)
                    ->addColumn('kreativitas_label', function ($x) {
                        return $x->kreativitas_label;
                    })
                    ->addColumn('action', function ($x) {
                        return $x->kreativitas_id;
                    });

                    if ($keyword = $request->get('search')['value']) {
                        $datatables->filterColumn('rownum', 'whereRawx', '@rownum  + 1 like ?', ["%{$keyword}%"]);
                    } 
        return $datatables->make(true);
    }

    public function KreatvitasDetail(Request $request)
    {
       
        
        $x = Kreativitas::
                SELECT(     'kreativitas.id AS kreativitas_id',
                            'kreativitas.label'

                                    ) 
                            ->WHERE('kreativitas.id', $request->kreativitas_id)
                            ->first();

		
        $kreativitas = array(
            'id'            => $x->kreativitas_id,
            'label'         => $x->label

        );
        return $kreativitas;
    }

    public function Store(Request $request)
    {

        $messages = [
                'capaian_tahunan_id.required'           => 'Harus diisi',
                'label_kreativitas.required'    => 'Harus diisi',
                'manfaat.required'              => 'Harus diisi',

        ];

        $validator = Validator::make(
                        Input::all(),
                        array(
                            'capaian_tahunan_id'        => 'required',
                            'label_kreativitas' => 'required',
                            'manfaat'           => 'required',
                        ),
                        $messages
        );

        if ( $validator->fails() ){
            //$messages = $validator->messages();
            return response()->json(['errors'=>$validator->messages()],422);
            
        }


        $sr    = new Kreativitas;

        $sr->capaian_tahunan_id        = Input::get('capaian_tahunan_id');
        $sr->label             = Input::get('label_kreativitas');
        $sr->manfaat           = Input::get('manfaat');

        if ( $sr->save()){
            return \Response::make('sukses', 200);
        }else{
            return \Response::make('error', 500);
        } 
            
            
    
    }

    public function Update(Request $request)
    {

        $messages = [
                'kreativitas_id.required'       => 'Harus diisi',
                'label_kreativitas.required'    => 'Harus diisi',
                'manfaat.required'              => 'Harus diisi',


        ];

        $validator = Validator::make(
                        Input::all(),
                        array(
                            'kreativitas_id'    => 'required',
                            'label_kreativitas' => 'required',
                            'manfaat'           => 'required',
                            
                        ),
                        $messages
        );

        if ( $validator->fails() ){
            //$messages = $validator->messages();
            return response()->json(['errors'=>$validator->messages()],422);
            
        }

        
        $sr    = Kreativitas::find(Input::get('kreativitas_id'));
        if (is_null($sr)) {
            return $this->sendError('Kreativitas Tidak ditemukan.');
        }


        $sr->label             = Input::get('label_kreativitas');
        $sr->manfaat           = Input::get('manfaat');


        if ( $sr->save()){
            return \Response::make('sukses', 200);
        }else{
            return \Response::make('error', 500);
        } 
            
            

    
    }



    public function Hapus(Request $request)
    {

        $messages = [
                'kreativitas_id.required'   => 'Harus diisi',
        ];

        $validator = Validator::make(
                        Input::all(),
                        array(
                            'kreativitas_id'   => 'required',
                        ),
                        $messages
        );

        if ( $validator->fails() ){
            //$messages = $validator->messages();
            return response()->json(['errors'=>$validator->messages()],422);
            
        }

        
        $sr    = Kreativitas::find(Input::get('kreativitas_id'));
        if (is_null($sr)) {
            return $this->sendError('Kreativitas tidak ditemukan.');
        }


        if ( $sr->delete()){
            return \Response::make('sukses', 200);
        }else{
            return \Response::make('error', 500);
        } 
            
            
    
    }
   

}
