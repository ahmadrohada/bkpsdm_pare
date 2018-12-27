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

        $pk = new Program;
        $pk->label                  = Input::get('text');
        $pk->indikator_sasaran_id   = Input::get('parent_id');

    
        if ( $pk->save()){
            $tes = array('id' => 'program|'.$pk->id);
            return \Response::make($tes, 200);
        }else{
            return \Response::make('error', 500);
        }
       
       
    }

    public function Rename(Request $request )
    {
        
         /*   $input = $request->all();
        $validator = Validator::make($input, [
            'text'          => 'required',
            'id'            => 'required'
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
        */
        $program = Program::find($request->id);
        if (is_null($program)) {
            return $this->sendError('Program  tidak ditemukan');
        }

        $program->label = $request->text;
        
        
        if ( $program->save()){
            return \Response::make('Sukses', 200);
        }else{
            return \Response::make('error', 500);
        }

        
      
    }
   

}
