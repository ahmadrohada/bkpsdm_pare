<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;

use App\Models\SasaranPerjanjianKinerja;
use App\Models\Sasaran;
use App\Models\IndikatorSasaran;
use App\Models\Program;
use App\Models\IndikatorProgram;
use App\Models\Kegiatan;
use App\Models\IndikatorKegiatan;
use App\Models\PerjanjianKinerja;
use App\Helpers\Pustaka;

use Datatables;
use Validator;
use Gravatar;
use Input;
Use Alert;

class IndikatorProgramAPIController extends Controller {


    public function IndProgramList(Request $request)
    {
            
        $dt = IndikatorProgram::where('program_id', '=' ,$request->get('program_id'))
                                ->select([   
                                    'id AS ind_program_id',
                                    'label AS label_ind_program',
                                    'target',
                                    'satuan'
                                    ])
                                    ->get();

        $datatables = Datatables::of($dt)
        ->addColumn('label_ind_program', function ($x) {
            return $x->label_ind_program;
        })
        ->addColumn('target_ind_program', function ($x) {
             return $x->target.' '.$x->satuan;
        })
        ->addColumn('action', function ($x) {
            return $x->ind_program_id;
        });

            if ($keyword = $request->get('search')['value']) {
                $datatables->filterColumn('rownum', 'whereRawx', '@rownum  + 1 like ?', ["%{$keyword}%"]);
        } 
        return $datatables->make(true);
    }

    public function IndProgramDetail(Request $request)
    {
       
        
        $x = IndikatorProgram::
                SELECT(     'renja_indikator_program.id AS ind_program_id',
                            'renja_indikator_program.label',
                            'renja_indikator_program.target',
                            'renja_indikator_program.satuan'


                                    ) 
                            ->WHERE('renja_indikator_program.id', $request->ind_program_id)
                            ->first();

		
		//return  $kegiatan_tahunan;
        $ind_program = array(
            'id'            => $x->ind_program_id,
            'label'         => $x->label,
            'target'      => $x->target,
            'satuan'        => $x->satuan

        );
        return $ind_program;
    }

    public function Store(Request $request)
    {

        $messages = [
                'program_id.required'           => 'Harus diisi',
                'label_ind_program.required'    => 'Harus diisi',
                'target_ind_program.required' => 'Harus diisi',
                //'satuan_ind_program.required'   => 'Harus diisi',

        ];

        $validator = Validator::make(
                        Input::all(),
                        array(
                            'program_id'            => 'required',
                            'label_ind_program'     => 'required',
                            'target_ind_program'  => 'required',
                            //'satuan_ind_program'    => 'required',
                        ),
                        $messages
        );

        if ( $validator->fails() ){
            //$messages = $validator->messages();
            return response()->json(['errors'=>$validator->messages()],422);
            
        }


        $is    = new IndikatorProgram;

        $is->program_id     = Input::get('program_id');
        $is->label          = Input::get('label_ind_program');
        $is->target       = Input::get('target_ind_program');
        $is->satuan         = Input::get('satuan_ind_program');

        if ( $is->save()){
            return \Response::make('sukses', 200);
        }else{
            return \Response::make('error', 500);
        } 
            
            
    
    }

    public function Update(Request $request)
    {

        $messages = [
            'ind_program_id.required'       => 'Harus diisi',
            'label_ind_program.required'    => 'Harus diisi',
            'target_ind_program.required' => 'Harus diisi',
            //'satuan_ind_program.required'   => 'Harus diisi',
                

        ];

        $validator = Validator::make(
                        Input::all(),
                        array(
                            'ind_program_id'        => 'required',
                            'label_ind_program'     => 'required',
                            'target_ind_program'  => 'required',
                            //'satuan_ind_program'    => 'required',
                            
                        ),
                        $messages
        );

        if ( $validator->fails() ){
            //$messages = $validator->messages();
            return response()->json(['errors'=>$validator->messages()],422);
            
        }

        
        $is    = IndikatorProgram::find(Input::get('ind_program_id'));
        if (is_null($is)) {
            return $this->sendError('Indikator Program idak ditemukan.');
        }


        $is->label             = Input::get('label_ind_program');
        $is->target          = Input::get('target_ind_program');
        $is->satuan            = Input::get('satuan_ind_program');

        if ( $is->save()){
            return \Response::make('sukses', 200);
        }else{
            return \Response::make('error', 500);
        } 
            
            

    
    }



    public function Hapus(Request $request)
    {

        $messages = [
                'ind_program_id.required'   => 'Harus diisi',
        ];

        $validator = Validator::make(
                        Input::all(),
                        array(
                            'ind_program_id'   => 'required',
                        ),
                        $messages
        );

        if ( $validator->fails() ){
            //$messages = $validator->messages();
            return response()->json(['errors'=>$validator->messages()],422);
            
        }

        
        $is    = IndikatorProgram::find(Input::get('ind_program_id'));
        if (is_null($is)) {
            return $this->sendError('Indikator program tidak ditemukan.');
        }


        if ( $is->delete()){
            return \Response::make('sukses', 200);
        }else{
            return \Response::make('error', 500);
        } 
            
            
    
    }
   

}
