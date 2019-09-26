<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;

use App\Models\PerilakuKerja;


use Datatables;
use Validator;
use Input;


class PerilakuKerjaAPIController extends Controller {


   
  
    public function PenilaianPerilakuKerjaDetail(Request $request)
    {
       
        
        $x = PerilakuKerja::
                            SELECT( '*') 
                            ->WHERE('penilaian_perilaku_kerja.capaian_tahunan_id', $request->capaian_tahunan_id)
                            ->first();

		if ( $x != null ){
            $pk = array(
                    'id'           => $x->perilaku_kerja_id,
                
					'pelayanan_02' => $x->pelayanan_02,
					'pelayanan_03' => $x->pelayanan_03,
					
					'integritas_01' => $x->integritas_01,
					'integritas_02' => $x->integritas_02,
					'integritas_03' => $x->integritas_03,
					'integritas_04' => $x->integritas_04,
					
					
					'komitmen_01' => $x->komitmen_01,
					'komitmen_02' => $x->komitmen_02,
					'komitmen_03' => $x->komitmen_03,
					
					
					'disiplin_01' => $x->disiplin_01,
					'disiplin_02' => $x->disiplin_02,
					'disiplin_03' => $x->disiplin_03,
					'disiplin_04' => $x->disiplin_04,
					
					'kerjasama_01' => $x->kerjasama_01,
					'kerjasama_02' => $x->kerjasama_02,
					'kerjasama_03' => $x->kerjasama_03,
					'kerjasama_04' => $x->kerjasama_04,
					'kerjasama_05' => $x->kerjasama_05,
					
					
					'kepemimpinan_01' => $x->kepemimpinan_01,
					'kepemimpinan_02' => $x->kepemimpinan_02,
					'kepemimpinan_03' => $x->kepemimpinan_03,
					'kepemimpinan_04' => $x->kepemimpinan_04,
					'kepemimpinan_05' => $x->kepemimpinan_05,
					'kepemimpinan_06' => $x->kepemimpinan_06, 
            );
            return $pk;
        }else{
            $pk = array(
                'id'           => 0,
            
                'pelayanan_02' => 0,
                'pelayanan_03' => 0,
                
                'integritas_01' => 0,
                'integritas_02' => 0,
                'integritas_03' => 0,
                'integritas_04' => 0,
                
                
                'komitmen_01' => 0,
                'komitmen_02' => 0,
                'komitmen_03' => 0,
                
                
                'disiplin_01' => 0,
                'disiplin_02' => 0,
                'disiplin_03' => 0,
                'disiplin_04' => 0,
                
                'kerjasama_01' => 0,
                'kerjasama_02' => 0,
                'kerjasama_03' => 0,
                'kerjasama_04' => 0,
                'kerjasama_05' => 0,
                
                
                'kepemimpinan_01' => 0,
                'kepemimpinan_02' => 0,
                'kepemimpinan_03' => 0,
                'kepemimpinan_04' => 0,
                'kepemimpinan_05' => 0,
                'kepemimpinan_06' => 0,
        );
        return $pk;
        }
       
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
