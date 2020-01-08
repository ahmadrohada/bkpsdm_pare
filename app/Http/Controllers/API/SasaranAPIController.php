<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Tujuan;
use App\Models\Sasaran;
use App\Models\Kegiatan;
use App\Models\PerjanjianKinerja;
use App\Helpers\Pustaka;

use Datatables;
use Validator;
use Gravatar;
use Input;
Use Alert;

class SasaranAPIController extends Controller {


    public function SasaranList(Request $request)
    {
            
        $dt = Sasaran::where('tujuan_id', '=' ,$request->get('tujuan_id'))
                                ->select([   
                                    'id AS sasaran_id',
                                    'label AS label_sasaran',
                                    ])
                                    ->get();

        $datatables = Datatables::of($dt)
                    ->addColumn('label_sasaran', function ($x) {
                        return $x->label_sasaran;
                    })
                    ->addColumn('action', function ($x) {
                        return $x->sasaran_id;
                    });

                    if ($keyword = $request->get('search')['value']) {
                        $datatables->filterColumn('rownum', 'whereRawx', '@rownum  + 1 like ?', ["%{$keyword}%"]);
                    } 
        return $datatables->make(true);
    }

    
    public function SasaranListJFTSelect2(Request $request)
    {
            
        $sasaran = Tujuan::
                            /* leftjoin('db_pare_2018.renja_indikator_tujuan AS ind_tujuan', function($join){
                                $join   ->on('renja_tujuan.id','=','ind_tujuan.tujuan_id');
                                
                            })  */
                            join('db_pare_2018.renja_sasaran AS sasaran', function($join){
                                $join   ->on('sasaran.tujuan_id','=','renja_tujuan.id');
                                
                            }) 
                            ->WHERE('renja_tujuan.renja_id', $request->renja_id )
                            ->WHERE('sasaran.label', 'LIKE', '%' . $request->sasaran . '%')
                            ->SELECT(   'sasaran.id AS sasaran_id',
                                        'sasaran.label AS sasaran_label'
                                    ) 
                            ->get(); 

        $sasaran_list = [];
            foreach ($sasaran as $x) {
                $sasaran_list[] = array(
                        'text'          => $x->sasaran_label,
                        'id'            => $x->sasaran_id,
                );
            }
        return $sasaran_list;
    }

    public function SasaranDetail(Request $request)
    {
       
        
        $x = Sasaran::
                SELECT(     'renja_sasaran.id AS sasaran_id',
                            'renja_sasaran.label'

                                    ) 
                            ->WHERE('renja_sasaran.id', $request->sasaran_id)
                            ->first();

		
        //return  $kegiatan_tahunan;
        if ($x){
            $sasaran = array(
                'id'            => $x->sasaran_id,
                'label'         => $x->label
            );
        }else{
            $sasaran = array(
                'id'            => "",
                'label'         => ""
            );
        }
        return $sasaran;
    }

    public function Store(Request $request)
    {

        $messages = [
                'tujuan_id.required'        => 'Harus diisi',
                'label_sasaran.required'    => 'Harus diisi',

        ];

        $validator = Validator::make(
                        Input::all(),
                        array(
                            'tujuan_id'     => 'required',
                            'label_sasaran' => 'required',
                        ),
                        $messages
        );

        if ( $validator->fails() ){
            //$messages = $validator->messages();
            return response()->json(['errors'=>$validator->messages()],422);
            
        }


        $sr    = new Sasaran;

        $sr->tujuan_id        = Input::get('tujuan_id');
        $sr->label            = Input::get('label_sasaran');

        if ( $sr->save()){
            return \Response::make('sukses', 200);
        }else{
            return \Response::make('error', 500);
        } 
            
            
    
    }

    public function Update(Request $request)
    {

        $messages = [
                'sasaran_id.required'       => 'Harus diisi',
                'label_sasaran.required'    => 'Harus diisi',
                

        ];

        $validator = Validator::make(
                        Input::all(),
                        array(
                            'sasaran_id'    => 'required',
                            'label_sasaran' => 'required',
                            
                        ),
                        $messages
        );

        if ( $validator->fails() ){
            //$messages = $validator->messages();
            return response()->json(['errors'=>$validator->messages()],422);
            
        }

        
        $sr    = Sasaran::find(Input::get('sasaran_id'));
        if (is_null($sr)) {
            return $this->sendError('Sasaran idak ditemukan.');
        }


        $sr->label             = Input::get('label_sasaran');

        if ( $sr->save()){
            return \Response::make('sukses', 200);
        }else{
            return \Response::make('error', 500);
        } 
            
            

    
    }



    public function Hapus(Request $request)
    {

        $messages = [
                'sasaran_id.required'   => 'Harus diisi',
        ];

        $validator = Validator::make(
                        Input::all(),
                        array(
                            'sasaran_id'   => 'required',
                        ),
                        $messages
        );

        if ( $validator->fails() ){
            //$messages = $validator->messages();
            return response()->json(['errors'=>$validator->messages()],422);
            
        }

        
        $sr    = Sasaran::find(Input::get('sasaran_id'));
        if (is_null($sr)) {
            return $this->sendError('Sasaran tidak ditemukan.');
        }


        if ( $sr->delete()){
            return \Response::make('sukses', 200);
        }else{
            return \Response::make('error', 500);
        } 
            
            
    
    }
}
