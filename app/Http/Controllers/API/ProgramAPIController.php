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


    public function SKPD_program_perjanjian_kinerja_list(Request $request)
    {
            
       
        \DB::statement(\DB::raw('set @rownum='.$request->get('start')));
        //\DB::statement(\DB::raw('set @rownum=0'));
        
        $dt = Program::where('indikator_sasaran_id', '=' ,$request->get('indikator_sasaran_id'))
            ->select([   
                    
                \DB::raw('@rownum  := @rownum  + 1 AS rownum'), 
                'id AS program_id',
                'indikator_sasaran_id',
                'label',
                
                ])
                ->get();
        



        $datatables = Datatables::of($dt)
        ->addColumn('jm_child', function ($x) {
            $jm_indikator_program = IndikatorProgram::where('program_id',$x->program_id)->count();
			return 	 $jm_indikator_program;
		})->addColumn('label', function ($x) {
            return $x->label;
        });

        if ($keyword = $request->get('search')['value']) {
            $datatables->filterColumn('rownum', 'whereRawx', '@rownum  + 1 like ?', ["%{$keyword}%"]);
        } 

        return $datatables->make(true);
    }






    public function Store(Request $request)
    {

       
        $messages = [
                'label.required'        => 'Label Program Harus diisi. ',
        ];

        $validator = Validator::make(
                        Input::all(),
                        array(
                            'indikator_sasaran_id' => 'required',
                            'label'                         => 'required|max:200',
                        ),
                        $messages
        );
       
        if ( $validator->fails() ){
            //$messages = $validator->messages();
            return response()->json(['errors'=>$validator->messages()],422);
            
        }


        $program    = new Program;
        $program->label                  = Input::get('label');
        $program->indikator_sasaran_id   = Input::get('indikator_sasaran_id');

        if ( $program->save()){
            return \Response::make('sukses', 200);
        }else{
            return \Response::make('error', 500);
        } 
       
       
    }
   

}
