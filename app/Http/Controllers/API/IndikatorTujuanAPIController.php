<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;

use App\Models\SasaranPerjanjianKinerja;
use App\Models\Sasaran;
use App\Models\IndikatorSasaran;
use App\Models\Program;
use App\Models\Tujuan;
use App\Models\IndikatorTujuan;
use App\Models\PerjanjianKinerja;
use App\Helpers\Pustaka;

use Datatables;
use Validator;
use Gravatar;
use Input;
Use Alert;

class IndikatorTujuanAPIController extends Controller {


    public function IndikatorTujuanList(Request $request)
    {
            
       
        $dt = IndikatorTujuan::where('tujuan_id', '=' ,$request->get('tujuan_id'))
            ->select([   
                'id AS ind_tujuan_id',
                'label AS label_ind_tujuan',
                'target',
                'satuan'
                ])
                ->get();

        $datatables = Datatables::of($dt)
        ->addColumn('label_ind_tujuan', function ($x) {
            return $x->label_ind_tujuan;
        })
        ->addColumn('target_ind_tujuan', function ($x) {
            return Pustaka::decimal($x->target).' '.$x->satuan;
        })
        ->addColumn('action', function ($x) {
            return $x->ind_tujuan_id;
        });

        if ($keyword = $request->get('search')['value']) {
            $datatables->filterColumn('rownum', 'whereRawx', '@rownum  + 1 like ?', ["%{$keyword}%"]);
        } 
        return $datatables->make(true);
    }

    public function IndTujuanDetail(Request $request)
    {
       
        
        $x = IndikatorTujuan::
                SELECT(     'renja_indikator_tujuan.id AS ind_tujuan_id',
                            'renja_indikator_tujuan.label',
                            'renja_indikator_tujuan.target',
                            'renja_indikator_tujuan.satuan'


                                    ) 
                            ->WHERE('renja_indikator_tujuan.id', $request->ind_tujuan_id)
                            ->first();

		
		//return  $kegiatan_tahunan;
        $ind_tujuan = array(
            'id'            => $x->ind_tujuan_id,
            'label'         => $x->label,
            'target'        => $x->target,
            'satuan'        => $x->satuan

        );
        return $ind_tujuan;
    }

    public function Store(Request $request)
    {

        $messages = [
                'tujuan_id.required'            => 'Harus diisi',
                'label_ind_tujuan.required'     => 'Harus diisi',
                'target_ind_tujuan.required'  => 'Harus diisi',
                //'satuan_ind_tujuan.required'    => 'Harus diisi',

        ];

        $validator = Validator::make(
                        Input::all(),
                        array(
                            'tujuan_id'             => 'required',
                            'label_ind_tujuan'      => 'required',
                            'target_ind_tujuan'     => 'required|numeric|min:0',
                            //'satuan_ind_tujuan'     => 'required',
                        ),
                        $messages
        );

        if ( $validator->fails() ){
            //$messages = $validator->messages();
            return response()->json(['errors'=>$validator->messages()],422);
            
        }


        $ind_tj    = new IndikatorTujuan;

        $ind_tj->tujuan_id      = Input::get('tujuan_id');
        $ind_tj->label          = Input::get('label_ind_tujuan');
        $ind_tj->target       = Input::get('target_ind_tujuan');
        $ind_tj->satuan         = Input::get('satuan_ind_tujuan');

        if ( $ind_tj->save()){
            return \Response::make('sukses', 200);
        }else{
            return \Response::make('error', 500);
        } 
            
            
    
    }

    public function Update(Request $request)
    {

        $messages = [
                'ind_tujuan_id.required'             => 'Harus diisi',
                'label_ind_tujuan.required'          => 'Harus diisi',
                'target_ind_tujuan.required'       => 'Harus diisi',
                //'satuan_ind_tujuan.required'         => 'Harus diisi'
                

        ];

        $validator = Validator::make(
                        Input::all(),
                        array(
                            'ind_tujuan_id'          => 'required',
                            'label_ind_tujuan'       => 'required',
                           'target_ind_tujuan'          => 'required|numeric|min:0',
                            //'satuan_ind_tujuan'      => 'required',
                            
                        ),
                        $messages
        );

        if ( $validator->fails() ){
            //$messages = $validator->messages();
            return response()->json(['errors'=>$validator->messages()],422);
            
        }

        
        $it    = IndikatorTujuan::find(Input::get('ind_tujuan_id'));
        if (is_null($it)) {
            return $this->sendError('Indikator Tujuan idak ditemukan.');
        }


        $it->label             = Input::get('label_ind_tujuan');
        $it->target          = Input::get('target_ind_tujuan');
        $it->satuan            = Input::get('satuan_ind_tujuan');

        if ( $it->save()){
            return \Response::make('sukses', 200);
        }else{
            return \Response::make('error', 500);
        } 
            
            

    
    }



    public function Hapus(Request $request)
    {

        $messages = [
                'ind_tujuan_id.required'   => 'Harus diisi',
        ];

        $validator = Validator::make(
                        Input::all(),
                        array(
                            'ind_tujuan_id'   => 'required',
                        ),
                        $messages
        );

        if ( $validator->fails() ){
            //$messages = $validator->messages();
            return response()->json(['errors'=>$validator->messages()],422);
            
        }

        
        $it    = IndikatorTujuan::find(Input::get('ind_tujuan_id'));
        if (is_null($it)) {
            return $this->sendError('Indikator Tujuan tidak ditemukan.');
        }


        if ( $it->delete()){
            return \Response::make('sukses', 200);
        }else{
            return \Response::make('error', 500);
        } 
            
            
    
    }


}
