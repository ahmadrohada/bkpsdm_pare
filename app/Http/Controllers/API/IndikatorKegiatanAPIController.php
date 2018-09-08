<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;

use App\Models\SasaranPerjanjianKinerja;
use App\Models\Sasaran;
use App\Models\IndikatorSasaran;
use App\Models\Program;
use App\Models\Kegiatan;
use App\Models\IndikatorKegiatan;
use App\Models\PerjanjianKinerja;
use App\Helpers\Pustaka;

use Datatables;
use Validator;
use Gravatar;
use Input;
Use Alert;

class IndikatorKegiatanAPIController extends Controller {


    public function SKPD_indikator_kegiatan_perjanjian_kinerja_list(Request $request)
    {
            
       
        //\DB::statement(\DB::raw('set @rownum='.$request->get('start')));
        \DB::statement(\DB::raw('set @rownum=0'));
        
        $dt = IndikatorKegiatan::where('kegiatan_id', '=' ,$request->get('kegiatan_id'))
            ->select([   
                    
                \DB::raw('@rownum  := @rownum  + 1 AS rownum'), 
                'id AS indikator_kegiatan_id',
                'kegiatan_id',
                'label',
                'target',
                'satuan'
                
                ])
                ->get();
        



        $datatables = Datatables::of($dt)
        ->addColumn('label', function ($x) {
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

       
        $messages = [
                //'label.required' => ':attribute Indikator Sasaran Harus diisi. ',
                'label.required' => 'Label Indikator Sasaran Harus diisi. ',
                'target.required' => 'Target tidak boleh kosong. ',
                'satuan.required' => 'Satuan tidak boleh kosong. ',
        ];

        $validator = Validator::make(
                        Input::all(),
                        array(
                            'kegiatan_id'    => 'required',
                            'label'          => 'required|max:200',
                            'target'         => 'required',
                            'satuan'         => 'required'
                        ),
                        $messages
        );
       
        if ( $validator->fails() ){
            //$messages = $validator->messages();
            return response()->json(['errors'=>$validator->messages()],422);
            
        }


        $indikator_kegiatan = new IndikatorKegiatan;
        $indikator_kegiatan->label         = Input::get('label');
        $indikator_kegiatan->kegiatan_id   = Input::get('kegiatan_id');
        $indikator_kegiatan->target        = Input::get('target');
        $indikator_kegiatan->satuan        = Input::get('satuan');;

        if ( $indikator_kegiatan->save()){
            return \Response::make('sukses', 200);
        }else{
            return \Response::make('error', 500);
        } 
       
       
    }
   

}
