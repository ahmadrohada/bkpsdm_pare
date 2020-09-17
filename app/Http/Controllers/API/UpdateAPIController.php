<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use App\Models\Sasaran;
use App\Models\Program;
use App\Models\Kegiatan;

use Datatables;
use Validator;
use Gravatar;
use Input;
Use Alert;

class UpdateAPIController extends Controller {


    public function Sasaran(Request $request)
    {
        //ini ada    
        $dt = Sasaran::
                        leftjoin('pare_2018_demo.renja_indikator_tujuan AS ind_tujuan', function($join){
                            $join   ->on('ind_tujuan.id','=','renja_sasaran.indikator_tujuan_id');
                        })
                        ->select([   
                                    'renja_sasaran.id AS sasaran_id',
                                    'renja_sasaran.label AS label_sasaran',
                                    'renja_sasaran.indikator_tujuan_id',
                                    'ind_tujuan.tujuan_id AS tujuan_id'
                        ])
                        ->get();
        $no = 0 ;
        foreach ($dt as $x) {

            $sr    = Sasaran::find( $x->sasaran_id );
            $sr->tujuan_id   = $x->tujuan_id;
    
            if ( $sr->save()){
                $no++;
            }


        }
        return "berhasil update data sebanyak : ".$no;
    }


    public function Program(Request $request)
    {
            
        $dt = Program::
                        leftjoin('pare_2018_demo.renja_indikator_sasaran AS ind_sasaran', function($join){
                            $join   ->on('ind_sasaran.id','=','renja_program.indikator_sasaran_id');
                        })
                        ->select([   
                                    'renja_program.id AS program_id',
                                    'renja_program.label AS label_program',
                                    'renja_program.indikator_sasaran_id',
                                    'ind_sasaran.sasaran_id AS sasaran_id'
                        ])
                        ->get();
        
        //return $dt;
        $no = 0 ;
        foreach ($dt as $x) {

            $sr    = Program::find( $x->program_id );
            $sr->sasaran_id   = $x->sasaran_id;
    
            if ( $sr->save()){
                $no++;
            }


        }
        return "berhasil update data sebanyak : ".$no;



       




    }

    public function Kegiatan(Request $request)
    {
            
        $dt = Kegiatan::
                        leftjoin('pare_2018_demo.renja_indikator_program AS ind_program', function($join){
                            $join   ->on('ind_program.id','=','renja_kegiatan.indikator_program_id');
                        })
                        ->select([   
                                    'renja_kegiatan.id AS kegiatan_id',
                                    'renja_kegiatan.label AS label_kegiatan',
                                    'renja_kegiatan.indikator_program_id',
                                    'ind_program.program_id AS program_id'
                        ])
                        ->get();
        
        //return $dt;
        $no = 0 ;
        foreach ($dt as $x) {

            $sr    = Kegiatan::find( $x->kegiatan_id );
            $sr->program_id   = $x->program_id;
    
            if ( $sr->save()){
                $no++;
            }


        }
        return "berhasil update data sebanyak : ".$no;

    }

    /* public function SasaranDetail(Request $request)
    {
       
        
        $x = Sasaran::
                SELECT(     'renja_sasaran.id AS sasaran_id',
                            'renja_sasaran.label'

                                    ) 
                            ->WHERE('renja_sasaran.id', $request->sasaran_id)
                            ->first();

		
		//return  $kegiatan_tahunan;
        $sasaran = array(
            'id'            => $x->sasaran_id,
            'label'         => $x->label

        );
        return $sasaran;
    }

    public function Store(Request $request)
    {

        $messages = [
                'ind_tujuan_id.required'     => 'Harus diisi',
                'label_sasaran.required'             => 'Harus diisi',

        ];

        $validator = Validator::make(
                        Input::all(),
                        array(
                            'ind_tujuan_id' => 'required',
                            'label_sasaran' => 'required',
                        ),
                        $messages
        );

        if ( $validator->fails() ){
            //$messages = $validator->messages();
            return response()->json(['errors'=>$validator->messages()],422);
            
        }


        $sr    = new Sasaran;

        $sr->indikator_tujuan_id        = Input::get('ind_tujuan_id');
        $sr->label                      = Input::get('label_sasaran');

        if ( $sr->save()){
            return \Response::make('sukses', 200);
        }else{
            return \Response::make('error', 500);
        } 
            
            
    
    }

    public function Update(Request $request)
    {

        $messages = [
                'sasaran_id.required'   => 'Harus diisi',
                'label_sasaran.required'       => 'Harus diisi',
                

        ];

        $validator = Validator::make(
                        Input::all(),
                        array(
                            'sasaran_id'   => 'required',
                            'label_sasaran'     => 'required',
                            
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
            
            
    
    } */
}
