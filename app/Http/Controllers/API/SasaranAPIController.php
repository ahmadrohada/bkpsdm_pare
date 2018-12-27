<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use App\Models\Sasaran;
use App\Models\PerjanjianKinerja;
use App\Helpers\Pustaka;

use Datatables;
use Validator;
use Gravatar;
use Input;
Use Alert;

class SasaranAPIController extends Controller {


    public function SKPD_sasaran_list(Request $request)
    {
            
       
        //\DB::statement(\DB::raw('set @rownum='.$request->get('start')));
        \DB::statement(\DB::raw('set @rownum=0'));
      
        $dt = Sasaran::leftjoin('sasaran_perjanjian_kinerja', function($join){
                                                                    $join   ->on('sasaran_perjanjian_kinerja.sasaran_id','=','sasaran.id');
                                                                    $join   ->where('sasaran_perjanjian_kinerja.perjanjian_kinerja_id','=', Request('perjanjian_kinerja_id'));
                                                                })
                      
                        ->select([   
                                                        
                        \DB::raw('@rownum  := @rownum  + 1 AS rownum'), 
                        'sasaran.id AS sasaran_id',
                        'sasaran.label',
                        'sasaran_perjanjian_kinerja.sasaran_id AS sasaran_id_2'
                        ])
                        ->get();

        
        $datatables = Datatables::of($dt)
        ->addColumn('action', function ($x) {

            if ($x->sasaran_id == $x->sasaran_id_2)
            {
                return 		'<a href="#" class="btn btn-xs btn-default" style="margin:2px;" disabled><i class="fa fa-plus"></i> Add</a>';
            }else{
                return 		'<a href="#" class="btn btn-xs btn-info add_sasaran_id" style="margin:2px;"  data-id="'.$x->sasaran_id.'" data-pk="'.Request('perjanjian_kinerja_id').'"><i class="fa fa-plus"></i> Add </a>';
            }

		})->addColumn('label', function ($x) {
            return $x->label;
        });


        if ($keyword = $request->get('search')['value']) {
            $datatables->filterColumn('rownum', 'whereRawx', '@rownum  + 1 like ?', ["%{$keyword}%"]);
        } 

        return $datatables->make(true); 
        //return $dt;
    }


    public function Store()
    {

        $pk = new Sasaran;
        $pk->label                      = Input::get('text');
        $pk->renja_id                   = Input::get('renja_id');
        $pk->indikator_tujuan_id        = Input::get('parent_id');

    
        if ( $pk->save()){
            $tes = array('id' => 'sasaran|'.$pk->id);
            return \Response::make($tes, 200);
        }else{
            return \Response::make('error', 500);
        }
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

        $sasaran = Sasaran::find($request->id);
        if (is_null($sasaran)) {
            return $this->sendError('Sasaran  tidak ditemukan');
        }

        $sasaran->label = $request->text;
        
        
        if ( $sasaran->save()){
            return \Response::make('Sukses', 200);
        }else{
            return \Response::make('error', 500);
        }

        
      
    }


}
