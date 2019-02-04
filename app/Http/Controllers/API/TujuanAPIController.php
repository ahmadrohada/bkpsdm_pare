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
use App\Models\Tujuan;
use App\Models\IndikatorKegiatan;
use App\Models\PerjanjianKinerja;
use App\Helpers\Pustaka;

use Datatables;
use Validator;
use Gravatar;
use Input;
Use Alert;

class TujuanAPIController extends Controller {


    public function TujuanList(Request $request)
    {
            
      
        $dt = Tujuan::where('renja_id', '=' ,$request->get('renja_id'))
            ->select([   
                'id AS tujuan_id',
                'label',
                ])
                ->get();
        $datatables = Datatables::of($dt)
        ->addColumn('label', function ($x) {
            return $x->label;
        })
        ->addColumn('action', function ($x) {
            return $x->renja_id;
        });

        if ($keyword = $request->get('search')['value']) {
            $datatables->filterColumn('rownum', 'whereRawx', '@rownum  + 1 like ?', ["%{$keyword}%"]);
        } 
        return $datatables->make(true);
    }

    public function TujuanDetail(Request $request)
    {
       
        
        $x = Tujuan::
                SELECT(     'renja_tujuan.id AS tujuan_id',
                            'renja_tujuan.label',
                            'renja_tujuan.misi_id'

                                    ) 
                            ->WHERE('renja_tujuan.id', $request->tujuan_id)
                            ->first();

		
		//return  $kegiatan_tahunan;
        $tujuan = array(
            'id'            => $x->tujuan_id,
            'label'         => $x->label,
            'misi_id'       => $x->misi_id,

        );
        return $tujuan;
    }

    public function Store(Request $request)
    {

        $messages = [
                //'misi_id.required'           => 'Harus diisi',
                'renja_id.required'          => 'Harus diisi',
                'label.required'             => 'Harus diisi',

        ];

        $validator = Validator::make(
                        Input::all(),
                        array(
                            //'misi_id'       => 'required',
                            'renja_id'      => 'required',
                            'label'         => 'required',
                        ),
                        $messages
        );

        if ( $validator->fails() ){
            //$messages = $validator->messages();
            return response()->json(['errors'=>$validator->messages()],422);
            
        }


        $tj    = new Tujuan;

        $tj->misi_id        = '1';
        $tj->renja_id       = Input::get('renja_id');
        $tj->label          = Input::get('label');

        if ( $tj->save()){
            return \Response::make('sukses', 200);
        }else{
            return \Response::make('error', 500);
        } 
            
            
    
    }

    public function Update(Request $request)
    {

        $messages = [
                'tujuan_id.required'   => 'Harus diisi',
                'misi_id.required'     => 'Harus diisi',
                'label.required'       => 'Harus diisi',
                

        ];

        $validator = Validator::make(
                        Input::all(),
                        array(
                            'tujuan_id'   => 'required',
                            'misi_id'     => 'required',
                            'label'       => 'required',
                            
                        ),
                        $messages
        );

        if ( $validator->fails() ){
            //$messages = $validator->messages();
            return response()->json(['errors'=>$validator->messages()],422);
            
        }

        
        $tj    = Tujuan::find(Input::get('tujuan_id'));
        if (is_null($tj)) {
            return $this->sendError('Tujuan idak ditemukan.');
        }


        $tj->label             = Input::get('label');
        $tj->misi_id           = Input::get('misi_id');

        if ( $tj->save()){
            return \Response::make('sukses', 200);
        }else{
            return \Response::make('error', 500);
        } 
            
            

    
    }



    public function Hapus(Request $request)
    {

        $messages = [
                'tujuan_id.required'   => 'Harus diisi',
        ];

        $validator = Validator::make(
                        Input::all(),
                        array(
                            'tujuan_id'   => 'required',
                        ),
                        $messages
        );

        if ( $validator->fails() ){
            //$messages = $validator->messages();
            return response()->json(['errors'=>$validator->messages()],422);
            
        }

        
        $tj    = Tujuan::find(Input::get('tujuan_id'));
        if (is_null($tj)) {
            return $this->sendError('Tujuan tidak ditemukan.');
        }


        if ( $tj->delete()){
            return \Response::make('sukses', 200);
        }else{
            return \Response::make('error', 500);
        } 
            
            
    
    }
       
}
