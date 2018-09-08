<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\SasaranPerjanjianKinerja;
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


    

}
