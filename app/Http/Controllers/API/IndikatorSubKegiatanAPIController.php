<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\IndikatorSubKegiatan;

use Datatables;
use Validator;
use Input;

class IndikatorSubKegiatanAPIController extends Controller {


    public function IndikatorSubKegiatanList(Request $request)
    {
            
      
        $dt = IndikatorSubKegiatan::where('subkegiatan_id', '=' ,$request->get('subkegiatan_id'))
                                ->select([   
                                    'id AS ind_subkegiatan_id',
                                    'subkegiatan_id',
                                    'label',
                                    'target',
                                    'satuan'
                                    ])
                                    ->get();


        $datatables = Datatables::of($dt)
        ->addColumn('label_ind_subkegiatan', function ($x) {
            return $x->label;
        })->addColumn('target_ind_subkegiatan', function ($x) {
            return $x->target."  ".$x->satuan;
        });

        if ($keyword = $request->get('search')['value']) {
            $datatables->filterColumn('rownum', 'whereRawx', '@rownum  + 1 like ?', ["%{$keyword}%"]);
        } 
        return $datatables->make(true);
    }


    public function IndikatorSubKegiatanDetail(Request $request)
    {
       
        
        $x = IndikatorSubKegiatan::SELECT('id','label')
                            ->WHERE('renja_indikator_subkegiatan.id', $request->get('ind_subkegiatan_id') )
                            ->SELECT(   'renja_indikator_subkegiatan.id AS ind_subkegiatan_id',
                                        'renja_indikator_subkegiatan.label AS label',
                                        'renja_indikator_subkegiatan.target AS target',
                                        'renja_indikator_subkegiatan.satuan AS satuan'
                                    ) 
                            ->first();
		
        $kegiatan = array(
                'ind-subkegiatan_id'=> $x->ind_subkegiatan_id,
                'label'             => $x->label,
                'target'            => $x->target,
                'satuan'            => $x->satuan,
                'output'            => $x->target.' '.$x->satuan,
                //j'pejabat'       => Pustaka::capital_string($x->jabatan_id != '0' ? $x->PenanggungJawab->jabatan : '0'),
                //'list_indikator'=> $list,   
            );
        return $kegiatan;
        
    }


    public function Store(Request $request)
    {

        $messages = [
                'subkegiatan_id.required'          => 'Harus diisi',
                'label_ind_subkegiatan.required'   => 'Harus diisi',
                'target_ind_subkegiatan.required'  => 'Harus diisi',
                'satuan_ind_subkegiatan.required'  => 'Harus diisi',

        ];

        $validator = Validator::make(
                        Input::all(),
                        array(
                            'subkegiatan_id'           => 'required',
                            'label_ind_subkegiatan'    => 'required',
                            'target_ind_subkegiatan'   => 'required|numeric|min:0',
                            'satuan_ind_subkegiatan'   => 'required',

                        ),
                        $messages
        );

        if ( $validator->fails() ){
            //$messages = $validator->messages();
            return response()->json(['errors'=>$validator->messages()],422);
            
        }


        $sr    = new IndikatorSubKegiatan;

        $sr->subkegiatan_id       = Input::get('subkegiatan_id');
        $sr->label             = Input::get('label_ind_subkegiatan');
        $sr->target            = Input::get('target_ind_subkegiatan');
        $sr->satuan            = Input::get('satuan_ind_subkegiatan');
        
        if ( $sr->save()){
            $tes = array('id' => 'IndSubkegiatan|'.$sr->id);
            return \Response::make($tes, 200);
        }else{
            return \Response::make('error', 500);
        } 
       
    }
   

    public function Update(Request $request)
    {

        $messages = [
            'ind_subkegiatan_id.required'       => 'Harus diisi',
            'label_ind_subkegiatan.required'    => 'Harus diisi',
            'target_ind_subkegiatan.required' => 'Harus diisi',
            'satuan_ind_subkegiatan.required'   => 'Harus diisi',
                

        ];

        $validator = Validator::make(
                        Input::all(),
                        array(
                            'ind_subkegiatan_id'        => 'required',
                            'label_ind_subkegiatan'     => 'required',
                            'target_ind_subkegiatan'  => 'required|numeric|min:0',
                            'satuan_ind_subkegiatan'    => 'required',
                            
                        ),
                        $messages
        );

        if ( $validator->fails() ){
            //$messages = $validator->messages();
            return response()->json(['errors'=>$validator->messages()],422);
            
        }

        
        $is    = IndikatorSubKegiatan::find(Input::get('ind_subkegiatan_id'));
        if (is_null($is)) {
            return $this->sendError('Indikator Sub Kegiatan idak ditemukan.');
        }


        $is->label             = Input::get('label_ind_subkegiatan');
        $is->target          = Input::get('target_ind_subkegiatan');
        $is->satuan            = Input::get('satuan_ind_subkegiatan');

        if ( $is->save()){
            return \Response::make('sukses', 200);
        }else{
            return \Response::make('error', 500);
        } 
            
            

    
    }



    public function Hapus(Request $request)
    {

        $messages = [
                'ind_subkegiatan_id.required'   => 'Harus diisi',
        ];

        $validator = Validator::make(
                        Input::all(),
                        array(
                            'ind_subkegiatan_id'   => 'required',
                        ),
                        $messages
        );

        if ( $validator->fails() ){
            //$messages = $validator->messages();
            return response()->json(['errors'=>$validator->messages()],422);
            
        }

        
        $is    = IndikatorSubKegiatan::find(Input::get('ind_subkegiatan_id'));
        if (is_null($is)) {
            return $this->sendError('Indikator sub kegiatan tidak ditemukan.');
        }


        if ( $is->delete()){
            return \Response::make('sukses', 200);
        }else{
            return \Response::make('error', 500);
        } 
            
            
    
    }
   
}
