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

class KegiatanAPIController extends Controller {


    public function SKPD_kegiatan_perjanjian_kinerja_list(Request $request)
    {
            
       
        //\DB::statement(\DB::raw('set @rownum='.$request->get('start')));
        \DB::statement(\DB::raw('set @rownum=0'));
        
        $dt = Kegiatan::where('indikator_program_id', '=' ,$request->get('indikator_program_id'))
            ->select([   
                    
                \DB::raw('@rownum  := @rownum  + 1 AS rownum'), 
                'id AS kegiatan_id',
                'indikator_program_id',
                'label',
                'jabatan_id',
                
                ])
                ->get();
        



        $datatables = Datatables::of($dt)
        ->addColumn('jm_child', function ($x) {
            $jm_indikator_kegiatan = IndikatorKegiatan::where('kegiatan_id',$x->kegiatan_id)->count();
            return 	 $jm_indikator_kegiatan;
        
        })->addColumn('label', function ($x) {
            return $x->label;
        
        })->addColumn('pengelola', function ($x) {
            return Pustaka::capital_string($x->pengelola->jabatan);
        });
        
        if ($keyword = $request->get('search')['value']) {
            $datatables->filterColumn('rownum', 'whereRawx', '@rownum  + 1 like ?', ["%{$keyword}%"]);
        } 

        return $datatables->make(true);
    }


  
    public function Store(Request $request)
    {

       
        $messages = [
                //'label.required' => ':attribute Indikator Sasaran Harus diisi. ',
                'label.required'         => 'Label Indikator Sasaran Harus diisi. ',
                'jabatan_id.required'    => 'Jabatan Harus dipilih. ',
        ];

        $validator = Validator::make(
                        Input::all(),
                        array(
                            'indikator_program_id'    => 'required',
                            'label'                   => 'required|max:200',
                            'jabatan_id'              => 'required',
                        ),
                        $messages
        );
       
        if ( $validator->fails() ){
            //$messages = $validator->messages();
            return response()->json(['errors'=>$validator->messages()],422);
            
        }


        $kegiatan = new Kegiatan;
        $kegiatan->label                = Input::get('label');
        $kegiatan->indikator_program_id = Input::get('indikator_program_id');
        $kegiatan->jabatan_id           = Input::get('jabatan_id');

        if ( $kegiatan->save()){
            return \Response::make('sukses', 200);
        }else{
            return \Response::make('error', 500);
        } 
       
       
    }
   

}
