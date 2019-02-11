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
use App\Models\PerjanjianKinerja;
use App\Helpers\Pustaka;
use App\Helpers\Skpd;

use Datatables;
use Validator;
use Gravatar;
use Input;
Use Alert;

class ProgramAPIController extends Controller {


   
    public function ProgramList(Request $request)
    {
            
        $dt = Program::where('indikator_sasaran_id', '=' ,$request->get('ind_sasaran_id'))
                                ->select([   
                                    'id AS program_id',
                                    'label AS label_program',
                                    ])
                                    ->get();

        $datatables = Datatables::of($dt)
                    ->addColumn('label_program', function ($x) {
                        return $x->label_program;
                    })
                    ->addColumn('action', function ($x) {
                        return $x->program_id;
                    });

                    if ($keyword = $request->get('search')['value']) {
                        $datatables->filterColumn('rownum', 'whereRawx', '@rownum  + 1 like ?', ["%{$keyword}%"]);
                    } 
        return $datatables->make(true);
    }

    public function ProgramDetail(Request $request)
    {
       
        
        $x = Program::
                SELECT(     'renja_program.id AS program_id',
                            'renja_program.label'

                                    ) 
                            ->WHERE('renja_program.id', $request->program_id)
                            ->first();

		
		//return  $kegiatan_tahunan;
        $program = array(
            'id'            => $x->program_id,
            'label'         => $x->label

        );
        return $program;
    }

    public function Store(Request $request)
    {

        $messages = [
                'ind_sasaran_id.required'     => 'Harus diisi',
                'label_program.required'             => 'Harus diisi',

        ];

        $validator = Validator::make(
                        Input::all(),
                        array(
                            'ind_sasaran_id' => 'required',
                            'label_program' => 'required',
                        ),
                        $messages
        );

        if ( $validator->fails() ){
            //$messages = $validator->messages();
            return response()->json(['errors'=>$validator->messages()],422);
            
        }


        $sr    = new Program;

        $sr->indikator_sasaran_id        = Input::get('ind_sasaran_id');
        $sr->label                      = Input::get('label_program');

        if ( $sr->save()){
            return \Response::make('sukses', 200);
        }else{
            return \Response::make('error', 500);
        } 
            
            
    
    }

    public function Update(Request $request)
    {

        $messages = [
                'program_id.required'   => 'Harus diisi',
                'label_program.required'       => 'Harus diisi',
                

        ];

        $validator = Validator::make(
                        Input::all(),
                        array(
                            'program_id'   => 'required',
                            'label_program'     => 'required',
                            
                        ),
                        $messages
        );

        if ( $validator->fails() ){
            //$messages = $validator->messages();
            return response()->json(['errors'=>$validator->messages()],422);
            
        }

        
        $sr    = Program::find(Input::get('program_id'));
        if (is_null($sr)) {
            return $this->sendError('Program idak ditemukan.');
        }


        $sr->label             = Input::get('label_program');

        if ( $sr->save()){
            return \Response::make('sukses', 200);
        }else{
            return \Response::make('error', 500);
        } 
            
            

    
    }



    public function Hapus(Request $request)
    {

        $messages = [
                'program_id.required'   => 'Harus diisi',
        ];

        $validator = Validator::make(
                        Input::all(),
                        array(
                            'program_id'   => 'required',
                        ),
                        $messages
        );

        if ( $validator->fails() ){
            //$messages = $validator->messages();
            return response()->json(['errors'=>$validator->messages()],422);
            
        }

        
        $sr    = Program::find(Input::get('program_id'));
        if (is_null($sr)) {
            return $this->sendError('Program tidak ditemukan.');
        }


        if ( $sr->delete()){
            return \Response::make('sukses', 200);
        }else{
            return \Response::make('error', 500);
        } 
            
            
    
    }
   

}
