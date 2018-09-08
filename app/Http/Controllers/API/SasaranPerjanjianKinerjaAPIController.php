<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\SasaranPerjanjianKinerja;
use App\Models\Sasaran;
use App\Models\IndikatorSasaran;
use App\Models\PerjanjianKinerja;
use App\Helpers\Pustaka;

use Datatables;
use Validator;
use Gravatar;
use Input;
Use Alert;

class SasaranPerjanjianKinerjaAPIController extends Controller {


    public function SKPD_sasaran_perjanjian_kinerja_list(Request $request)
    {
            
       
        //\DB::statement(\DB::raw('set @rownum='.$request->get('start')));
        \DB::statement(\DB::raw('set @rownum=0'));
      
        $dt = SasaranPerjanjianKinerja::where('perjanjian_kinerja_id', '=' ,$request->get('perjanjian_kinerja_id'))
                                            ->select([   
                                                        
                                                    \DB::raw('@rownum  := @rownum  + 1 AS rownum'), 
                                                    'id AS sasaran_perjanjian_kinerja_id',
                                                    'sasaran_id',
                                                    'perjanjian_kinerja_id',
                                                    
                                                    ])
                                                    ->get();

        
        $datatables = Datatables::of($dt)
        ->addColumn('jm_child', function ($x) {
            $jm_indikator = IndikatorSasaran::where('sasaran_perjanjian_kinerja_id',$x->sasaran_perjanjian_kinerja_id)->count();
           return 	$jm_indikator;
		})->addColumn('label', function ($x) {
            return $x->sasaran->label;
        });
        if ($keyword = $request->get('search')['value']) {
            $datatables->filterColumn('rownum', 'whereRawx', '@rownum  + 1 like ?', ["%{$keyword}%"]);
        } 
        return $datatables->make(true); 
    }


    

    public function Store()
    {

        $pk = new SasaranPerjanjianKinerja;
        $pk->sasaran_id                 = Input::get('sasaran_id');
        $pk->perjanjian_kinerja_id      = Input::get('perjanjian_kinerja_id');

        

        if ( $pk->save()){
            return \Response::make('sukses', 200);
        }else{
            return \Response::make('error', 500);
        }
        
       
    }
   

}
