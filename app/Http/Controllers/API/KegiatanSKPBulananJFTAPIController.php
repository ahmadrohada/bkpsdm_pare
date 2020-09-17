<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use App\Models\KegiatanSKPTahunanJFT;
use App\Models\KegiatanSKPBulananJFT;

use App\Helpers\Pustaka;

use Datatables;
use Validator;
use Gravatar;
use Input;
Use Alert;

class KegiatanSKPBulananJFTAPIController extends Controller {

    public function KegiatanBulananDetail(Request $request)
    {
       
        
        $x = KegiatanSKPBulananJFT::

                            join('db_pare_2018_demo.skp_tahunan_kegiatan_jft AS kegiatan_tahunan', function($join){
                                $join   ->on('kegiatan_tahunan.id','=','skp_bulanan_kegiatan_jft.kegiatan_tahunan_id');
                                
                            })
                            ->SELECT(   'skp_bulanan_kegiatan_jft.id AS kegiatan_bulanan_id',
                                        'skp_bulanan_kegiatan_jft.label',
                                        'skp_bulanan_kegiatan_jft.target',
                                        'skp_bulanan_kegiatan_jft.satuan',
                                        'skp_bulanan_kegiatan_jft.angka_kredit',
                                        'skp_bulanan_kegiatan_jft.quality',
                                        'skp_bulanan_kegiatan_jft.cost',
                                        'skp_bulanan_kegiatan_jft.target_waktu',
                                        'skp_bulanan_kegiatan_jft.kegiatan_tahunan_id',
                                        'kegiatan_tahunan.id AS kegiatan_tahunan_id',
                                        'kegiatan_tahunan.label AS kegiatan_tahunan_label',
                                        'kegiatan_tahunan.target AS kegiatan_tahunan_target',
                                        'kegiatan_tahunan.satuan AS kegiatan_tahunan_satuan',
                                        'kegiatan_tahunan.cost AS kegiatan_tahunan_cost',
                                        'kegiatan_tahunan.target_waktu AS kegiatan_tahunan_target_waktu'

                                    ) 
                            ->WHERE('skp_bulanan_kegiatan_jft.id', $request->kegiatan_bulanan_id)
                            ->first();
      
		
		//return  $kegiatan_bulanan;
        $kegiatan_bulanan = array(
            'kegiatan_tahunan_id'      => $x->kegiatan_tahunan_id,
            'kegiatan_tahunan_label'   => $x->kegiatan_tahunan_label,
            'kegiatan_tahunan_output'  => $x->kegiatan_tahunan_target." ".$x->kegiatan_tahunan_satuan,  
            'kegiatan_tahunan_waktu'   => $x->kegiatan_tahunan_target_waktu, 
            'kegiatan_tahunan_cost'    => number_format($x->kegiatan_tahunan_cost,'0',',','.'),

            'id'                    => $x->kegiatan_bulanan_id,
            'label'                 => $x->label, 
            'ak'                    => $x->angka_kredit,
            'output'                => $x->target.' '.$x->satuan,
            'satuan'                => $x->satuan,
            'target'                => $x->target,
            'quality'               => $x->quality,
            'target_waktu'          => $x->target_waktu,
            'cost'	                => number_format($x->cost,'0',',','.'),
           
         
        );
        return $kegiatan_bulanan;
    }

    public function KegiatanBulanan5(Request $request)
    {
            
        
        $dt = KegiatanSKPBulananJFT::
                    WHERE('skp_bulanan_id','=', $request->skp_bulanan_id )
                    ->SELECT(   'skp_bulanan_kegiatan_jft.id',
                                'skp_bulanan_kegiatan_jft.label',
                                'skp_bulanan_kegiatan_jft.target',
                                'skp_bulanan_kegiatan_jft.satuan'
                            ) 
                    ->get();
        
        $datatables = Datatables::of($dt)
        ->addColumn('skp_bulanan_id', function ($x){
            return $x->id;
        })->addColumn('target', function ($x) {
            return $x->target." ".$x->satuan;
        });

        
        if ($keyword = $request->get('search')['value']) {
            $datatables->filterColumn('rownum', 'whereRawx', '@rownum  + 1 like ?', ["%{$keyword}%"]);
        } 

        return $datatables->make(true); 
        
    } 
 
    public function Store(Request $request)
    {

        $messages = [
                'kegiatan_tahunan_id.required'   => 'Harus diisi',
                'skp_bulanan_id.required'        => 'Harus diisi',
                'label.required'                 => 'Harus diisi',
                'target.required'                => 'Harus diisi',
                'satuan.required'                => 'Harus diisi',
                
        ];

        $validator = Validator::make(
                        Input::all(),
                        array(
                            'kegiatan_tahunan_id'   => 'required',
                            'skp_bulanan_id'        => 'required',
                            'label'                 => 'required',
                            'target'                => 'required',
                            'satuan'                => 'required',
                        ),
                        $messages
        );

        if ( $validator->fails() ){
            //$messages = $validator->messages();
            return response()->json(['errors'=>$validator->messages()],422);
            
        }


        $st_kt    = new KegiatanSKPBulananJFT;

        $st_kt->kegiatan_tahunan_id = Input::get('kegiatan_tahunan_id');
        $st_kt->skp_bulanan_id      = Input::get('skp_bulanan_id');
        $st_kt->label               = Input::get('label');
        $st_kt->target              = preg_replace('/[^0-9]/', '', Input::get('target'));
        $st_kt->satuan              = Input::get('satuan');
        $st_kt->angka_kredit        = Input::get('angka_kredit');
        $st_kt->quality             = preg_replace('/[^0-9]/', '', Input::get('quality'));
        $st_kt->cost                = preg_replace('/[^0-9]/', '', Input::get('cost'));
        $st_kt->target_waktu        = preg_replace('/[^0-9]/', '', Input::get('target_waktu'));
       

        if ( $st_kt->save()){
            return \Response::make('sukses', 200);
        }else{
            return \Response::make('error', 500);
        } 
            
            
    
    }

    public function Update(Request $request)
    {

        $messages = [
                'kegiatan_bulanan_id.required'   => 'Harus diisi',
                'kegiatan_tahunan_id.required'   => 'Harus diisi',   
                'label.required'                 => 'Harus diisi',
                'target.required'              => 'Harus diisi',
                'satuan.required'                => 'Harus diisi',
                'quality.required'               => 'Harus diisi',
                'target_waktu.required'          => 'Harus diisi',

        ];

        $validator = Validator::make(
                        Input::all(),
                        array(
                            'kegiatan_bulanan_id'   => 'required',
                            'kegiatan_tahunan_id'   => 'required',
                            'label'                 => 'required',
                            'target'                => 'required|numeric',
                            'satuan'                => 'required',
                            'quality'               => 'required|numeric|min:1|max:100',
                            'target_waktu'          => 'required|numeric|min:1|max:12',
                        ),
                        $messages
        );

        if ( $validator->fails() ){
            //$messages = $validator->messages();
            return response()->json(['errors'=>$validator->messages()],422);
            
        }

        
        $st_kt    = KegiatanSKPBulananJFT::find(Input::get('kegiatan_bulanan_id'));
        if (is_null($st_kt)) {
            return $this->sendError('Kegiatan Bulanan tidak ditemukan.');
        }

        $st_kt->kegiatan_tahunan_id = Input::get('kegiatan_tahunan_id');
        $st_kt->label             = Input::get('label');
        $st_kt->target            = preg_replace('/[^0-9]/', '', Input::get('target'));
        $st_kt->satuan            = Input::get('satuan');
        $st_kt->angka_kredit      = Input::get('angka_kredit');
        $st_kt->quality           = preg_replace('/[^0-9]/', '', Input::get('quality'));
        $st_kt->cost              = preg_replace('/[^0-9]/', '', Input::get('cost'));
        $st_kt->target_waktu      = preg_replace('/[^0-9]/', '', Input::get('target_waktu'));

        if ( $st_kt->save()){
            return \Response::make('sukses', 200);
        }else{
            return \Response::make('error', 500);
        } 
            
            

    
    }


    public function Destroy(Request $request)
    {

        $messages = [
                'kegiatan_bulanan_id.required'   => 'Harus diisi',
        ];

        $validator = Validator::make(
                        Input::all(),
                        array(
                            'kegiatan_bulanan_id'   => 'required',
                        ),
                        $messages
        );

        if ( $validator->fails() ){
            //$messages = $validator->messages();
            return response()->json(['errors'=>$validator->messages()],422);
            
        }

        
        $st_kt    = KegiatanSKPBulananJFT::find(Input::get('kegiatan_bulanan_id'));
        if (is_null($st_kt)) {
            return $this->sendError('Kegiatan Bulanan tidak ditemukan.');
        }


        if ( $st_kt->delete()){
            return \Response::make('sukses', 200);
        }else{
            return \Response::make('error', 500);
        } 
    }
}
