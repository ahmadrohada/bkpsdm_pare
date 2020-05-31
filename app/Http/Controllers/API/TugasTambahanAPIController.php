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



class TugasTambahanAPIController extends Controller {


    public function TugasTambahanSelect2(Request $request)
    {
            
        $tugas_tambahan = TugasTambahan::SELECT('id','label')
                        ->WHERE('skp_tahunan_tugas_tambahan.skp_tahunan_id', $request->skp_tahunan_id )
                        ->get(); 

        $tugas_tambahan_list = [];
            foreach ($tugas_tambahan as $x) {
                $tugas_tambahan_list[] = array(
                        'text'          => $x->label,
                        'id'            => $x->id,
                );
            }
        return $tugas_tambahan_list;
    }


    public function TugasTambahanTree(Request $request)
    {
        $skp_tahunan_id = $request->skp_tahunan_id;
        //klasifikasi get data menurut root node nya,.. 
        if ( $request->id == "#"){
            $data = 'tugas_tambahan';
        }else{
            $data = $request->data;
        }
        $state = array( "opened" => true, "selected" => false );

        switch ($data) {
            case 'tugas_tambahan':
            
            $tugas_tambahan = TugasTambahan::SELECT('id','label')
                                            ->WHERE('skp_tahunan_tugas_tambahan.skp_tahunan_id', $skp_tahunan_id )
                                            ->get(); 
            foreach ($tugas_tambahan as $x) {
                   

                    $sub_data_tugas_tambahan['id']	            = $x->id;
                    $sub_data_tugas_tambahan['data']	        = "tugas_tambahan";
                    $sub_data_tugas_tambahan['text']			= Pustaka::capital_string($x->label);
                    $sub_data_tugas_tambahan['icon']            = "jstree-tugas_tambahan";
                    $sub_data_tugas_tambahan['type']            = "tugas_tambahan";
                    //$sub_data_tugas_tambahan['state']           = $state;
                    //$sub_data_tugas_tambahan['children']        = true ;

                    $uraian = UraianTugasTambahan::where('tugas_tambahan_id','=',$x->id)->select('id','label')->get();
                    foreach ($uraian as $y) {
                        $sub_data_uraian['id']		        = $y->id;
                        $sub_data_uraian['data']	        = "uraian_tugas_tambahan";
                        $sub_data_uraian['text']		    = Pustaka::capital_string($y->label);
                        $sub_data_uraian['icon']            = "jstree-uraian_tugas_tambahan";
                        $sub_data_uraian['type']            = "uraian_tugas_tambahan";
                        $sub_data_uraian['children']        = false ;
                        //$sub_data_uraian['state']           = $state;

                    $uraian_list[] = $sub_data_uraian ;
                }	
                if(!empty($uraian_list)) { 
                    $sub_data_tugas_tambahan['children']       = $uraian_list;
                }
                $tugas_tambahan_list[] = $sub_data_tugas_tambahan ;	
                $uraian_list = "";
                unset($sub_data_tugas_tambahan['children']);
            }	
                if(!empty($tugas_tambahan_list)) { 
                    return $tugas_tambahan_list;
                }else{
                    return "[{}]";
                }
            break;
            case 'uraian_tugas_tambahan':
                return "[{}]";
            
            break;
            default:
            return "[{}]";
            break;
        }
    }








    
    public function TugasTambahanList(Request $request)
    {
            
        $dt = TugasTambahan::where('skp_tahunan_id', '=' ,$request->get('skp_tahunan_id'))
                                ->select([   
                                    'id AS tugas_tambahan_id',
                                    'label AS tugas_tambahan_label',
                                    'target AS tugas_tambahan_target',
                                    'satuan AS tugas_tambahan_satuan',
                                    'quality AS tugas_tambahan_quality',
                                    'angka_kredit AS tugas_tambahan_ak'
                                ])
                                ->get();

        $datatables = Datatables::of($dt)
                    ->addColumn('id', function ($x) {
                        return $x->tugas_tambahan_id;
                    })
                    ->addColumn('label', function ($x) {
                        return $x->tugas_tambahan_label;
                    })
                    ->addColumn('output', function ($x) {
                        return $x->tugas_tambahan_target.' '.$x->tugas_tambahan_satuan;
                    })
                    ->addColumn('mutu', function ($x) {
                        return $x->tugas_tambahan_quality.' %';
                    })
                    ->addColumn('angka_kredit', function ($x) {
                        return $x->tugas_tambahan_ak;
                    });

                    if ($keyword = $request->get('search')['value']) {
                        $datatables->filterColumn('rownum', 'whereRawx', '@rownum  + 1 like ?', ["%{$keyword}%"]);
                    } 
        return $datatables->make(true);
    }

    public function Detail(Request $request)
    {
       
        
        $x = TugasTambahan::
                            SELECT(     'skp_tahunan_tugas_tambahan.id AS tugas_tambahan_id',
                                        'skp_tahunan_tugas_tambahan.skp_tahunan_id',
                                        'skp_tahunan_tugas_tambahan.label',
                                        'skp_tahunan_tugas_tambahan.target',
                                        'skp_tahunan_tugas_tambahan.satuan',
                                        'skp_tahunan_tugas_tambahan.angka_kredit',
                                        'skp_tahunan_tugas_tambahan.quality',
                                        'skp_tahunan_tugas_tambahan.cost',
                                        'skp_tahunan_tugas_tambahan.target_waktu'

                                    ) 
                            ->WHERE('skp_tahunan_tugas_tambahan.id', $request->tugas_tambahan_id)
                            ->first();
     
		//return  $tugas_tambahan;
        $tugas_tambahan = array(
            'id'                    => $x->tugas_tambahan_id,
            'skp_tahunan_id'        => $x->skp_tahunan_id,
            'label'                 => $x->label,
            'ak'                    => $x->angka_kredit,
            'output'                => $x->target.' '.$x->satuan,
            'satuan'                => $x->satuan,
            'target'                => $x->target,
            'quality'               => $x->quality,
            'target_waktu'          => $x->target_waktu,
            'cost'	                => number_format($x->cost,'0',',','.')
            
        );
        return $tugas_tambahan;
    }

    public function Store(Request $request)
    {

        $messages = [
                'skp_tahunan_id.required'           => 'Harus diisi',
                'label.required'                    => 'Harus diisi',
                'target.required'                   => 'Harus diisi',
                'satuan.required'                   => 'Harus diisi',
                'quality.required'                  => 'Harus diisi',

        ];

        $validator = Validator::make(
                        Input::all(),
                        array(
                            'skp_tahunan_id'    => 'required',
                            'label'             => 'required',
                            'target'            => 'required',
                            'satuan'            => 'required',
                            'quality'           => 'required',
                        ),
                        $messages
        );

        if ( $validator->fails() ){
            //$messages = $validator->messages();
            return response()->json(['errors'=>$validator->messages()],422);
            
        }


        $sr    = new TugasTambahan;

        $sr->skp_tahunan_id        = Input::get('skp_tahunan_id');
        $sr->label                 = Input::get('label');
        $sr->target                = Input::get('target');
        $sr->satuan                = Input::get('satuan');
        $sr->quality               = Input::get('quality');
        $sr->angka_kredit          = Input::get('angka_kredit');
        $sr->cost                  = Input::get('cost');
        $sr->target_waktu          = Input::get('target_waktu');

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
                    'target.required'                   => 'Harus diisi',
                    'satuan.required'                   => 'Harus diisi',
                    'quality.required'                  => 'Harus diisi',


        ];

        $validator = Validator::make(
                        Input::all(),
                        array(
                            'tugas_tambahan_id' => 'required',
                            'label'             => 'required',
                            'target'            => 'required',
                            'satuan'            => 'required',
                            'quality'           => 'required',
                            
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


        
        $sr->label                 = Input::get('label');
        $sr->target                = Input::get('target');
        $sr->satuan                = Input::get('satuan');
        $sr->quality               = Input::get('quality');
        $sr->angka_kredit          = Input::get('angka_kredit');
        $sr->cost                  = Input::get('cost');
        $sr->target_waktu          = Input::get('target_waktu');


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
