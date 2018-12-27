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


    public function SKPD_indikator_program_perjanjian_kinerja_list(Request $request)
    {
            
       
        //\DB::statement(\DB::raw('set @rownum='.$request->get('start')));
        \DB::statement(\DB::raw('set @rownum=0'));
        
        $dt = IndikatorProgram::where('program_id', '=' ,$request->get('program_id'))
            ->select([   
                    
                \DB::raw('@rownum  := @rownum  + 1 AS rownum'), 
                'id AS indikator_program_id',
                'program_id',
                'label',
                'target',
                'satuan'
                
                ])
                ->get();
        



        $datatables = Datatables::of($dt)
        ->addColumn('jm_child', function ($x) {
            $jm_kegiatan = Kegiatan::where('indikator_program_id',$x->indikator_program_id)->count();
			return 	$jm_kegiatan;
		})->addColumn('label', function ($x) {
            return $x->label."  ";
        })->addColumn('target', function ($x) {
            return $x->target."  ".$x->satuan;
        });

        
        if ($keyword = $request->get('search')['value']) {
            $datatables->filterColumn('rownum', 'whereRawx', '@rownum  + 1 like ?', ["%{$keyword}%"]);
        } 

        return $datatables->make(true);
    }


  
    public function Store(Request $request)
    {

        $pk = new IndikatorProgram;
        $pk->label                  = Input::get('text');
        $pk->program_id             = Input::get('parent_id');

    
        if ( $pk->save()){
            $tes = array('id' => 'ind_program|'.$pk->id);
            return \Response::make($tes, 200);
        }else{
            return \Response::make('error', 500);
        }
       
        /* $messages = [
                //'label.required' => ':attribute Indikator Sasaran Harus diisi. ',
                'label.required' => 'Label Indikator Sasaran Harus diisi. ',
                'target.required' => 'Target tidak boleh kosong. ',
                'satuan.required' => 'Satuan tidak boleh kosong. ',
        ];

        $validator = Validator::make(
                        Input::all(),
                        array(
                            'program_id'    => 'required',
                            'label'         => 'required|max:200',
                            'target'        => 'required',
                            'satuan'        => 'required'
                        ),
                        $messages
        );
       
        if ( $validator->fails() ){
            //$messages = $validator->messages();
            return response()->json(['errors'=>$validator->messages()],422);
            
        }


        $indikator_program = new Indikatorprogram;
        $indikator_program->label               = Input::get('label');
        $indikator_program->program_id          = Input::get('program_id');
        $indikator_program->target              = Input::get('target');
        $indikator_program->satuan              = Input::get('satuan');

        if ( $indikator_program->save()){
            return \Response::make('sukses', 200);
        }else{
            return \Response::make('error', 500);
        }  */
       
       
    }

    public function Rename(Request $request )
    {
        

        $ind_program = IndikatorProgram::find($request->id);
        if (is_null($ind_program)) {
            return \Response::make('Indikator Program  tidak ditemukan', 404);
        }

        $ind_program->label = $request->text;
        
        
        if ( $ind_program->save()){
            return \Response::make('Sukses', 200);
        }else{
            return \Response::make('error', 500);
        }

        
      
    }
   

}
