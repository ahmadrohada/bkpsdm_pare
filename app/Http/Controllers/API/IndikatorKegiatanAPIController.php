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


    public function IndikatorKegiatanList(Request $request)
    {
            
      
        $dt = IndikatorKegiatan::where('kegiatan_id', '=' ,$request->get('kegiatan_id'))
                                ->select([   
                                    'id AS ind_kegiatan_id',
                                    'kegiatan_id',
                                    'label',
                                    'target',
                                    'satuan'
                                    ])
                                    ->get();


        $datatables = Datatables::of($dt)
        ->addColumn('label_ind_kegiatan', function ($x) {
            return $x->label;
        })->addColumn('target_ind_kegiatan', function ($x) {
            return $x->target."  ".$x->satuan;
        });

        if ($keyword = $request->get('search')['value']) {
            $datatables->filterColumn('rownum', 'whereRawx', '@rownum  + 1 like ?', ["%{$keyword}%"]);
        } 
        return $datatables->make(true);
    }


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


    public function Select2IndikatorKegiatanList(Request $request)
    {

       
        $data       = IndikatorKegiatan::where('kegiatan_id', $request->get('kegiatan_renja_id'))
                                        ->SELECT('id','label','target','satuan')
                                        ->get();

        $ind_kegiatan_list = [];
        foreach  ( $data as $x){
           
            
            $ind_kegiatan_list[] = array(
                'id'		=> $x->id,
                'text'		=> $x->label,
                'satuan'    => $x->satuan,
                'target'	=> $x->target,
            );
             


        } 
                    
        return $ind_kegiatan_list;


    }



    public function IndikatorKegiatanDetail(Request $request)
    {
       
        $skp_tahunan_id = $request->skp_tahunan_id;
        
        $x = IndikatorKegiatan::
                leftjoin('db_pare_2018_demo.renja_kegiatan AS renja_kegiatan', function($join) {
                    $join   ->on('renja_indikator_kegiatan.kegiatan_id','=','renja_kegiatan.id');
                })
                ->leftjoin('db_pare_2018_demo.skp_tahunan_kegiatan AS kegiatan_tahunan', function($join) use($skp_tahunan_id) {
                    $join   ->on('kegiatan_tahunan.kegiatan_id','=','renja_kegiatan.id');
                    $join   ->WHERE('kegiatan_tahunan.skp_tahunan_id','=', $skp_tahunan_id);
                })
                ->SELECT(       'renja_indikator_kegiatan.id AS ind_kegiatan_id',
                                'renja_indikator_kegiatan.label',
                                'renja_indikator_kegiatan.target',
                                'renja_indikator_kegiatan.satuan',
                                'kegiatan_tahunan.cost AS cost',
                                'renja_kegiatan.id AS kegiatan_id',
                                'kegiatan_tahunan.id AS kegiatan_tahunan_id'

                        ) 
                            ->WHERE('renja_indikator_kegiatan.id', $request->ind_kegiatan_id)
                            ->first();

        $ind_kegiatan = array(
            'id'                    => $x->ind_kegiatan_id,
            'kegiatan_id'           => $x->kegiatan_id,
            'ind_kegiatan_id'       => $x->ind_kegiatan_id,
            'kegiatan_tahunan_id'   => $x->kegiatan_tahunan_id,
            'label'                 => $x->label,
            'target'                => $x->target,
            'satuan'                => $x->satuan,
            'cost'                  => $x->cost

        );
        return $ind_kegiatan;
    }
  
    public function Store(Request $request)
    {

        $messages = [
                'kegiatan_id.required'          => 'Harus diisi',
                'label_ind_kegiatan.required'   => 'Harus diisi',
                'target_ind_kegiatan.required'  => 'Harus diisi',
                'satuan_ind_kegiatan.required'  => 'Harus diisi',

        ];

        $validator = Validator::make(
                        Input::all(),
                        array(
                            'kegiatan_id'           => 'required',
                            'label_ind_kegiatan'    => 'required',
                            'target_ind_kegiatan'   => 'required',
                            'satuan_ind_kegiatan'   => 'required',

                        ),
                        $messages
        );

        if ( $validator->fails() ){
            //$messages = $validator->messages();
            return response()->json(['errors'=>$validator->messages()],422);
            
        }


        $sr    = new IndikatorKegiatan;

        $sr->kegiatan_id       = Input::get('kegiatan_id');
        $sr->label             = Input::get('label_ind_kegiatan');
        $sr->target            = Input::get('target_ind_kegiatan');
        $sr->satuan            = Input::get('satuan_ind_kegiatan');
        
        if ( $sr->save()){
            $tes = array('id' => 'Indkegiatan|'.$sr->id);
            return \Response::make($tes, 200);
        }else{
            return \Response::make('error', 500);
        } 
       
    }
   

    public function Update(Request $request)
    {

        $messages = [
            'ind_kegiatan_id.required'       => 'Harus diisi',
            'label_ind_kegiatan.required'    => 'Harus diisi',
            'target_ind_kegiatan.required' => 'Harus diisi',
            'satuan_ind_kegiatan.required'   => 'Harus diisi',
                

        ];

        $validator = Validator::make(
                        Input::all(),
                        array(
                            'ind_kegiatan_id'        => 'required',
                            'label_ind_kegiatan'     => 'required',
                            'target_ind_kegiatan'  => 'required',
                            'satuan_ind_kegiatan'    => 'required',
                            
                        ),
                        $messages
        );

        if ( $validator->fails() ){
            //$messages = $validator->messages();
            return response()->json(['errors'=>$validator->messages()],422);
            
        }

        
        $is    = IndikatorKegiatan::find(Input::get('ind_kegiatan_id'));
        if (is_null($is)) {
            return $this->sendError('Indikator Kegiatan idak ditemukan.');
        }


        $is->label             = Input::get('label_ind_kegiatan');
        $is->target          = Input::get('target_ind_kegiatan');
        $is->satuan            = Input::get('satuan_ind_kegiatan');

        if ( $is->save()){
            return \Response::make('sukses', 200);
        }else{
            return \Response::make('error', 500);
        } 
            
            

    
    }



    public function Hapus(Request $request)
    {

        $messages = [
                'ind_kegiatan_id.required'   => 'Harus diisi',
        ];

        $validator = Validator::make(
                        Input::all(),
                        array(
                            'ind_kegiatan_id'   => 'required',
                        ),
                        $messages
        );

        if ( $validator->fails() ){
            //$messages = $validator->messages();
            return response()->json(['errors'=>$validator->messages()],422);
            
        }

        
        $is    = IndikatorKegiatan::find(Input::get('ind_kegiatan_id'));
        if (is_null($is)) {
            return $this->sendError('Indikator Kegiatan tidak ditemukan.');
        }


        if ( $is->delete()){
            return \Response::make('sukses', 200);
        }else{
            return \Response::make('error', 500);
        } 
            
            
    
    }


   
}
