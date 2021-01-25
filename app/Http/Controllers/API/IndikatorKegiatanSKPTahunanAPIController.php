<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use App\Models\IndikatorKegiatanSKPTahunan;
use App\Models\KegiatanSKPTahunan;

use App\Helpers\Pustaka;

use Datatables;
use Validator;
use Gravatar;
use Input;
Use Alert;

class IndikatorKegiatanSKPTahunanAPIController extends Controller {



    public function UpdateIndikatorKegiatanSKPTahunan(Request $request){

        
        $kegiatan = KegiatanSKPTahunan::get();

        //loop sub kegiatan 
        foreach ($kegiatan as $x) {
            $id_baru = $x->id;
            
            $dt_cek = IndikatorKegiatanSKPTahunan::WHERE('kegiatan_id',$x->subkegiatan_id)->get();
                foreach ($dt_cek as $y) {
                    $st_kt                  = IndikatorKegiatanSKPTahunan::find($y->id);
                    $st_kt->kegiatan_id     = $id_baru ;
                    $st_kt->save();
                }
        }
    }


    public function SelectIndikatorKegiatanList(Request $request){
         
  
        $indikator     = KegiatanSKPTahunan::
                                            rightjoin('db_pare_2018.skp_tahunan_indikator_kegiatan AS indikator', function($join){
                                                $join   ->on('indikator.kegiatan_id','=','skp_tahunan_kegiatan.id');
                                            })
                                            ->Where('indikator.label','like', '%'.$request->get('label').'%')
                                            ->SELECT('indikator.id AS indikator_id','indikator.label AS indikator_label')
                                            ->where('skp_tahunan_kegiatan.skp_tahunan_id','=',$request->skp_tahunan_id )
                                            ->get();
 
 
        $no = 0;
        $indikator_list = [];
        foreach  ( $indikator as $x){
            $no++;
            $indikator_list[] = array(
                             'id'		    => $x->indikator_id,
                             'label'		=> $x->indikator_label,
                             );
            } 
         
        return $indikator_list;
         
    }

    public function IndikatorKegiatanSKPTahunanList(Request $request)
    {
            
      
        $dt = IndikatorKegiatanSKPTahunan::where('kegiatan_id', '=' ,$request->get('kegiatan_skp_tahunan_id'))
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

    public function IndikatorKegiatanSKPTahunanDetail(Request $request)
    {
       
        $x = IndikatorKegiatanSKPTahunan::where('id', '=' ,$request->get('indikator_kegiatan_skp_tahunan_id'))
                                        ->first();

        $ind_kegiatan = array(
            'ind_kegiatan_id'       => $x->id,
            'label'                 => $x->label,
            'target'                => $x->target,
            'satuan'                => $x->satuan,
            'cost'                  => $x->cost

        );
        return $ind_kegiatan;
    }

   /* 
    public function Store(Request $request)
    {

        $messages = [
                'kegiatan_id.required'           => 'Harus diisi',
                'skp_tahunan_id.required'        => 'Harus diisi',
                'label.required'                 => 'Harus diisi',
                //'target.required'                => 'Harus diisi',
                //'satuan.required'                => 'Harus diisi',
                'quality.required'               => 'Harus diisi',
                'target_waktu.required'          => 'Harus diisi',

        ];

        $validator = Validator::make(
                        Input::all(),
                        array(
                            'kegiatan_id'       => 'required',
                            'skp_tahunan_id'    => 'required',
                            'label'             => 'required',
                            //'target'            => 'required|numeric',
                            //'satuan'            => 'required',
                            'quality'           => 'required|numeric|min:1|max:100',
                            'target_waktu'      => 'required|numeric|min:1|max:12',
                        ),
                        $messages
        );

        if ( $validator->fails() ){
            //$messages = $validator->messages();
            return response()->json(['errors'=>$validator->messages()],422);
            
        }


        $st_kt    = new KegiatanSKPTahunan;

        $st_kt->kegiatan_id             = Input::get('kegiatan_id');
        $st_kt->skp_tahunan_id          = Input::get('skp_tahunan_id');
        $st_kt->label                   = Input::get('label');
        $st_kt->target                  = Input::get('target');
        $st_kt->satuan                  = Input::get('satuan');
        $st_kt->angka_kredit            = Input::get('angka_kredit');
        $st_kt->quality                 = Input::get('quality');
        $st_kt->cost                    = preg_replace('/[^0-9]/', '', Input::get('cost'));
        $st_kt->target_waktu            = Input::get('target_waktu');

        if ( $st_kt->save()){
            return \Response::make('sukses', 200);
        }else{
            return \Response::make('error', 500);
        } 
            
            
    
    }


    public function Update(Request $request)
    {

        $messages = [
                'kegiatan_tahunan_id.required'   => 'Harus diisi',
                'label.required'                 => 'Harus diisi',
                //'target.required'              => 'Harus diisi',
                //'satuan.required'                => 'Harus diisi',
                'quality.required'               => 'Harus diisi',
                'target_waktu.required'          => 'Harus diisi',

        ];

        $validator = Validator::make(
                        Input::all(),
                        array(
                            'kegiatan_tahunan_id'   => 'required',
                            'label'                 => 'required',
                            //'target'                => 'required|numeric',
                            //'satuan'                => 'required',
                            'quality'               => 'required|numeric|min:1|max:100',
                            'target_waktu'          => 'required|numeric|min:1|max:12',
                        ),
                        $messages
        );

        if ( $validator->fails() ){
            //$messages = $validator->messages();
            return response()->json(['errors'=>$validator->messages()],422);
            
        }

        
        $st_kt    = KegiatanSKPTahunan::find(Input::get('kegiatan_tahunan_id'));
        if (is_null($st_kt)) {
            return $this->sendError('Kegiatan Tahunan tidak ditemukan.');
        }


        $st_kt->label             = Input::get('label');
        $st_kt->target          = preg_replace('/[^0-9]/', '', Input::get('target'));
        $st_kt->satuan            = Input::get('satuan');
        $st_kt->angka_kredit      = Input::get('angka_kredit');
        $st_kt->quality           = preg_replace('/[^0-9]/', '', Input::get('quality'));
        $st_kt->cost              = preg_replace('/[^0-9]/', '', Input::get('cost'));
        $st_kt->target_waktu      = preg_replace('/[^0-9]/', '', Input::get('target_waktu'));

        if ( $st_kt->save()){
            return \Response::make('sukses', 200);
        }else{
            return \Response::make('error', 500);
        } 
            
            

    
    } */


    public function Hapus(Request $request)
    {

        $messages = [
                'id.required'   => 'Harus diisi',
        ];

        $validator = Validator::make(
                        Input::all(),
                        array(
                            'id'   => 'required',
                        ),
                        $messages
        );

        if ( $validator->fails() ){
            //$messages = $validator->messages();
            return response()->json(['errors'=>$validator->messages()],422);
            
        }

        
        $del_ind    = IndikatorKegiatanSKPTahunan::find(Input::get('id'));
        if (is_null($del_ind)) {
            return $this->sendError('Indikator Kegiatan SKP Tahunan tidak ditemukan.');
        }

        
        

        if ( $del_ind->delete()){
            //after delete ,cek kegiatan tahunan, jika tidak lagi memiliki indikator,maka hapus
            $jm_keg = IndikatorKegiatanSKPTahunan::WHERE('kegiatan_id','=',$del_ind->KegiatanSKPTahunan->id)
                                                    ->whereNull('deleted_at')
                                                    ->count();
            if ( $jm_keg === 0 ){
                KegiatanSKPTahunan::WHERE('id',$del_ind->KegiatanSKPTahunan->id)->delete();
            }
            return \Response::make('sukses', 200);
        }else{
            return \Response::make('error', 500);
        }  
            
            
    
    }


}
