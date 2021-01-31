<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\KodeEtik;

use App\Traits\TraitCapaianBulanan;
use Validator;
use Input;


class KodeEtikAPIController extends Controller {

    use TraitCapaianBulanan;
   
  
    public function PenilaianKodeEtik(Request $request)
    {
        return $this->NilaiKodeEtik($request->capaian_bulanan_id);
    }

    protected function PenilaianKodeEtikDetail(Request $request){
     

        $pke = KodeEtik::WHERE('id',$request->penilaian_kode_etik_id)->first();
            $data = array(
                
                    'penilaian_kode_etik_id'=> $pke->id,
                    'santun'                => $pke->santun,
                    'amanah'                => $pke->amanah,
                    'harmonis'              => $pke->harmonis,
                    'adaptif'               => $pke->adaptif,
                    'terbuka'               => $pke->terbuka,
                    'efektif'               => $pke->efektif,
            );
        return $data; 
    } 


    public function Store(Request $request)
	{
        $messages = [
                'capaian_bulanan_id.required'   => 'Harus diisi',
                'santun.required'               => 'Harus Lebih dari nol',
                'amanah.required'               => 'Harus Lebih dari nol',
                'harmonis.required'             => 'Harus Lebih dari nol',
                'adaptif.required'              => 'Harus Lebih dari nol',
                'terbuka.required'              => 'Harus Lebih dari nol',
                'efektif.required'              => 'Harus Lebih dari nol'

        ];

        $validator = Validator::make(
                        Input::all(),
                        array(
                            'capaian_bulanan_id'=> 'required',
                            'santun'            => 'required|integer|min:1',
                            'amanah'            => 'required|integer|min:1',
                            'harmonis'          => 'required|integer|min:1',
                            'adaptif'           => 'required|integer|min:1',
                            'terbuka'           => 'required|integer|min:1',
                            'efektif'           => 'required|integer|min:1'
                        ),
                        $messages
        );

        if ( $validator->fails() ){
            //$messages = $validator->messages();
                    return response()->json(['errors'=>$validator->messages()],422);
            
        }

       
        $cek = KodeEtik::WHERE('capaian_bulanan_id',Input::get('capaian_bulanan_id'))
                                ->SELECT('id')
                                ->count();

        if ( $cek == 0 ){
           
            $pke    = new KodeEtik;
            $pke->capaian_bulanan_id  = Input::get('capaian_bulanan_id');
            $pke->santun              = Input::get('santun');
            $pke->amanah              = Input::get('amanah');
            $pke->harmonis            = Input::get('harmonis');
            $pke->adaptif             = Input::get('adaptif');
            $pke->terbuka             = Input::get('terbuka');
            $pke->efektif             = Input::get('efektif');
            
    
            
    
            if ( $pke->save()){
                return \Response::make($pke->id, 200);
            }else{
                return \Response::make('error', 500);
            } 

        //IF CEK SUDAH ADA CAPAIAN NYA
        }else{
            return response()->json(['errors'=>'data sudah ada'],422);
        } 

    }   


    public function Update(Request $request)
    {

        $messages = [
                'penilaian_kode_etik_id.required'   => 'Harus diisi',
                'santun.required'               => 'Harus Lebih dari nol',
                'amanah.required'               => 'Harus Lebih dari nol',
                'harmonis.required'             => 'Harus Lebih dari nol',
                'adaptif.required'              => 'Harus Lebih dari nol',
                'terbuka.required'              => 'Harus Lebih dari nol',
                'efektif.required'              => 'Harus Lebih dari nol'

        ];

        $validator = Validator::make(
                        Input::all(),
                        array(
                            'penilaian_kode_etik_id'=> 'required',
                            'santun'            => 'required|integer|min:1',
                            'amanah'            => 'required|integer|min:1',
                            'harmonis'          => 'required|integer|min:1',
                            'adaptif'           => 'required|integer|min:1',
                            'terbuka'           => 'required|integer|min:1',
                            'efektif'           => 'required|integer|min:1'
                        ),
                        $messages
        );

        if ( $validator->fails() ){
            //$messages = $validator->messages();
                    return response()->json(['errors'=>$validator->messages()],422);
            
        }

        
        $pke    = KodeEtik::find(Input::get('penilaian_kode_etik_id'));
        if (is_null($pke)) {
            return response()->json('PKE tidak ditemukan.',422);
        }


        $pke->santun              = Input::get('santun');
        $pke->amanah              = Input::get('amanah');
        $pke->harmonis            = Input::get('harmonis');
        $pke->adaptif             = Input::get('adaptif');
        $pke->terbuka             = Input::get('terbuka');
        $pke->efektif             = Input::get('efektif');


        if ( $pke->save()){
            return \Response::make('sukses', 200);
        }else{
            return \Response::make('error', 500);
        } 
            
            

    
    }
}
