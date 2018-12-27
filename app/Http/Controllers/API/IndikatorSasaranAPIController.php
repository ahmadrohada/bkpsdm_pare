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


    public function SKPD_indikator_sasaran_perjanjian_kinerja_list(Request $request)
    {
            
       
        \DB::statement(\DB::raw('set @rownum='.$request->get('start')));
        //\DB::statement(\DB::raw('set @rownum=0'));
        
        $dt = IndikatorSasaran::where('sasaran_perjanjian_kinerja_id', '=' ,$request->get('sasaran_perjanjian_kinerja_id'))
            ->select([   
                    
                \DB::raw('@rownum  := @rownum  + 1 AS rownum'), 
                'id AS indikator_sasaran_id',
                'sasaran_perjanjian_kinerja_id',
                'label',
                'target',
                'satuan'
                
                ])
                ->get();
        



        $datatables = Datatables::of($dt)
        ->addColumn('jm_child', function ($x) {
            $jm_program = Program::where('indikator_sasaran_id',$x->indikator_sasaran_id)->count();
			return 		$jm_program;
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


  
    public function Store()
    {

        $pk = new IndikatorSasaran;
        $pk->label             = Input::get('text');
        $pk->sasaran_id        = Input::get('parent_id');

    
        if ( $pk->save()){
            $tes = array('id' => 'ind_sasaran|'.$pk->id);
            return \Response::make($tes, 200);
        }else{
            return \Response::make('error', 500);
        }

       
       /*  $messages = [
                //'label.required' => ':attribute Indikator Sasaran Harus diisi. ',
                'label.required' => 'Label Indikator Sasaran Harus diisi. ',
                'target.required' => 'Target tidak boleh kosong. ',
                'satuan.required' => 'Satuan tidak boleh kosong. ',
        ];

        $validator = Validator::make(
                        Input::all(),
                        array(
                            'sasaran_perjanjian_kinerja_id' => 'required',
                            'label'                         => 'required|max:200',
                            'target'                        => 'required',
                            'satuan'                        => 'required'
                        ),
                        $messages
        );
       
        if ( $validator->fails() ){
            //$messages = $validator->messages();
            return response()->json(['errors'=>$validator->messages()],422);
            
        }


        $indikator_sasaran = new IndikatorSasaran;
        $indikator_sasaran->label                           = Input::get('label');
        $indikator_sasaran->sasaran_perjanjian_kinerja_id   = Input::get('sasaran_perjanjian_kinerja_id');
        $indikator_sasaran->target                          = Input::get('target');
        $indikator_sasaran->satuan                          = Input::get('satuan');;

        if ( $indikator_sasaran->save()){
            return \Response::make('sukses', 200);
        }else{
            return \Response::make('error', 500);
        }  */
       
       
    }
   
    
    public function Rename(Request $request )
    {
        
        $input = $request->all();
        $validator = Validator::make($input, [
            'text'          => 'required',
            'id'            => 'required'
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }

        $ind_sasaran = IndikatorSasaran::find($request->id);
        if (is_null($ind_sasaran)) {
            return $this->sendError('Sasaran  tidak ditemukan');
        }

        $ind_sasaran->label = $request->text;
        
        
        if ( $ind_sasaran->save()){
            return \Response::make('Sukses', 200);
        }else{
            return \Response::make('error', 500);
        }

        
      
    }

}
