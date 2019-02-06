<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;

use App\Models\SasaranPerjanjianKinerja;
use App\Models\Sasaran;
use App\Models\IndikatorSasaran;
use App\Models\Program;
use App\Models\PerjanjianKinerja;
use App\Helpers\Pustaka;

use Datatables;
use Validator;
use Gravatar;
use Input;
Use Alert;

class IndikatorSasaranAPIController extends Controller {


    public function IndSasaranList(Request $request)
    {
            
        $dt = IndikatorSasaran::where('sasaran_id', '=' ,$request->get('sasaran_id'))
                                ->select([   
                                    'id AS ind_sasaran_id',
                                    'label AS label_ind_sasaran',
                                    'target',
                                    'satuan'
                                    ])
                                    ->get();

        $datatables = Datatables::of($dt)
        ->addColumn('label_ind_sasaran', function ($x) {
            return $x->label_ind_sasaran;
        })
        ->addColumn('target_ind_sasaran', function ($x) {
             return $x->target.' '.$x->satuan;
        })
        ->addColumn('action', function ($x) {
            return $x->ind_sasaran_id;
        });

            if ($keyword = $request->get('search')['value']) {
                $datatables->filterColumn('rownum', 'whereRawx', '@rownum  + 1 like ?', ["%{$keyword}%"]);
        } 
        return $datatables->make(true);
    }

    public function IndSasaranDetail(Request $request)
    {
       
        
        $x = IndikatorSasaran::
                SELECT(     'renja_indikator_sasaran.id AS ind_sasaran_id',
                            'renja_indikator_sasaran.label',
                            'renja_indikator_sasaran.target',
                            'renja_indikator_sasaran.satuan'


                                    ) 
                            ->WHERE('renja_indikator_sasaran.id', $request->ind_sasaran_id)
                            ->first();

		
		//return  $kegiatan_tahunan;
        $ind_sasaran = array(
            'id'            => $x->ind_sasaran_id,
            'label'         => $x->label,
            'target'      => $x->target,
            'satuan'        => $x->satuan

        );
        return $ind_sasaran;
    }

    public function Store(Request $request)
    {

        $messages = [
                'sasaran_id.required'           => 'Harus diisi',
                'label_ind_sasaran.required'    => 'Harus diisi',
                'target_ind_sasaran.required' => 'Harus diisi',
                //'satuan_ind_sasaran.required'   => 'Harus diisi',

        ];

        $validator = Validator::make(
                        Input::all(),
                        array(
                            'sasaran_id'            => 'required',
                            'label_ind_sasaran'     => 'required',
                            'target_ind_sasaran'  => 'required',
                            //'satuan_ind_sasaran'    => 'required',
                        ),
                        $messages
        );

        if ( $validator->fails() ){
            //$messages = $validator->messages();
            return response()->json(['errors'=>$validator->messages()],422);
            
        }


        $is    = new IndikatorSasaran;

        $is->sasaran_id     = Input::get('sasaran_id');
        $is->label          = Input::get('label_ind_sasaran');
        $is->target       = Input::get('target_ind_sasaran');
        $is->satuan         = Input::get('satuan_ind_sasaran');

        if ( $is->save()){
            return \Response::make('sukses', 200);
        }else{
            return \Response::make('error', 500);
        } 
            
            
    
    }

    public function Update(Request $request)
    {

        $messages = [
            'ind_sasaran_id.required'       => 'Harus diisi',
            'label_ind_sasaran.required'    => 'Harus diisi',
            'target_ind_sasaran.required' => 'Harus diisi',
            //'satuan_ind_sasaran.required'   => 'Harus diisi',
                

        ];

        $validator = Validator::make(
                        Input::all(),
                        array(
                            'ind_sasaran_id'        => 'required',
                            'label_ind_sasaran'     => 'required',
                            'target_ind_sasaran'  => 'required',
                            //'satuan_ind_sasaran'    => 'required',
                            
                        ),
                        $messages
        );

        if ( $validator->fails() ){
            //$messages = $validator->messages();
            return response()->json(['errors'=>$validator->messages()],422);
            
        }

        
        $is    = IndikatorSasaran::find(Input::get('ind_sasaran_id'));
        if (is_null($is)) {
            return $this->sendError('Indikator Sasaran idak ditemukan.');
        }


        $is->label             = Input::get('label_ind_sasaran');
        $is->target          = Input::get('target_ind_sasaran');
        $is->satuan            = Input::get('satuan_ind_sasaran');

        if ( $is->save()){
            return \Response::make('sukses', 200);
        }else{
            return \Response::make('error', 500);
        } 
            
            

    
    }



    public function Hapus(Request $request)
    {

        $messages = [
                'ind_sasaran_id.required'   => 'Harus diisi',
        ];

        $validator = Validator::make(
                        Input::all(),
                        array(
                            'ind_sasaran_id'   => 'required',
                        ),
                        $messages
        );

        if ( $validator->fails() ){
            //$messages = $validator->messages();
            return response()->json(['errors'=>$validator->messages()],422);
            
        }

        
        $is    = IndikatorSasaran::find(Input::get('ind_sasaran_id'));
        if (is_null($is)) {
            return $this->sendError('Indikator Sasaran tidak ditemukan.');
        }


        if ( $is->delete()){
            return \Response::make('sukses', 200);
        }else{
            return \Response::make('error', 500);
        } 
            
            
    
    }

}
