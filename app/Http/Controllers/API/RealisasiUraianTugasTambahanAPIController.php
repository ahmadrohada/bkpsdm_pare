<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\UraianTugasTambahan;
use App\Models\RealisasiUraianTugasTambahan;
use App\Models\SKPTahunan;
use App\Models\SKPBulanan;

use App\Helpers\Pustaka;
use App\Traits\HitungCapaian;
use App\Traits\BawahanList;

use Datatables;
use Validator;
use Input;

class RealisasiUraianTugasTambahanAPIController extends Controller {
    use HitungCapaian;
    use BawahanList;
    
    

    

    public function RealisasiUraianTugasTambahanList(Request $request)
    {
            
        $dt = UraianTugasTambahan::
                                leftjoin('db_pare_2018.skp_tahunan_tugas_tambahan AS tugas_tambahan', function($join){
                                    $join   ->on('tugas_tambahan.id','=','uraian_tugas_tambahan.tugas_tambahan_id');
                                })
                                ->leftjoin('db_pare_2018.realisasi_uraian_tugas_tambahan AS realisasi', function($join){
                                    $join   ->on('realisasi.uraian_tugas_tambahan_id','=','uraian_tugas_tambahan.id');
                                })
                                ->select([   
                                    'uraian_tugas_tambahan.id AS uraian_tugas_tambahan_id',
                                    'uraian_tugas_tambahan.label AS uraian_tugas_tambahan_label',
                                    'uraian_tugas_tambahan.target AS uraian_tugas_tambahan_target',
                                    'uraian_tugas_tambahan.satuan AS uraian_tugas_tambahan_satuan',
                                    'tugas_tambahan.label AS tugas_tambahan_label',
                                    'realisasi.id AS realisasi_uraian_tugas_tambahan_id',
                                    'realisasi.realisasi',
                                    'realisasi.satuan AS realisasi_satuan'
                                ])
                                ->ORDERBY('uraian_tugas_tambahan.id','ASC')
                                ->where('skp_bulanan_id', '=' ,$request->get('skp_bulanan_id'))
                                ->get();

        $datatables = Datatables::of($dt)
                                    ->addColumn('uraian_tugas_tambahan_id', function ($x) {
                                    return $x->uraian_tugas_tambahan_id;
                                    })
                                    ->addColumn('realisasi_uraian_tugas_tambahan_id', function ($x) {
                                        return $x->realisasi_uraian_tugas_tambahan_id;
                                    })
                                    ->addColumn('tugas_tambahan_label', function ($x) {
                                    return $x->tugas_tambahan_label;
                                    })
                                    ->addColumn('uraian_tugas_tambahan_label', function ($x) {
                                    return $x->uraian_tugas_tambahan_label;
                                    })
                                    ->addColumn('target', function ($x) {
                                    return $x->uraian_tugas_tambahan_target.' '.$x->uraian_tugas_tambahan_satuan;
                                    })
                                    ->addColumn('realisasi', function ($x) {
                                        return $x->realisasi.' '.$x->realisasi_satuan;
                                    })
                                    ->addColumn('persen', function ($x) {
                                        return   Pustaka::persen($x->realisasi,$x->uraian_tugas_tambahan_target);
                                    });

        if ($keyword = $request->get('search')['value']) {
        $datatables->filterColumn('rownum', 'whereRawx', '@rownum  + 1 like ?', ["%{$keyword}%"]);
        } 
        return $datatables->make(true);
        
    } 

    


    public function Store(Request $request)
    {

        $messages = [
                'uraian_tugas_tambahan_id.required' => 'Harus diisi',
                'capaian_bulanan_id.required'       => 'Harus diisi',
                'target.required'                   => 'Harus diisi',
                'realisasi.required'                => 'Harus diisi',
                'satuan.required'                   => 'Harus diisi',
        ];

        $validator = Validator::make(
                        Input::all(),
                        array(
                            'uraian_tugas_tambahan_id'  => 'required',
                            'capaian_bulanan_id'        => 'required',
                            'target'                    => 'required',
                            //'realisasi'                 => 'required|numeric|max:'.$request->target,
                            'realisasi'                 => 'required|numeric',
                            'satuan'                    => 'required',
                        ),
                        $messages
        );

        if ( $validator->fails() ){
            //$messages = $validator->messages();
            return response()->json(['errors'=>$validator->messages()],422);
            
        }/* else if ( Input::get('realisasi') >  Input::get('target') ) {
            return response()->json(['errors'=>"tes"],422);
        } */

        //UPDATE dulu target nya
        $utt            = UraianTugasTambahan::find(Input::get('uraian_tugas_tambahan_id'));
        $utt->target    = $request->target;
        $utt->save();

        if ( $utt->save()){
            $realisasi_utt    = new RealisasiUraianTugasTambahan;

            $realisasi_utt->uraian_tugas_tambahan_id= Input::get('uraian_tugas_tambahan_id');
            $realisasi_utt->capaian_id              = Input::get('capaian_bulanan_id');
            $realisasi_utt->realisasi               = Input::get('realisasi');
            $realisasi_utt->satuan                  = Input::get('satuan');
        

            if ( $realisasi_utt->save()){
                return \Response::make('sukses', 200);
            }else{
                return \Response::make('error', 500);
            } 
        }else{
            return \Response::make('error', 500);
        } 
            
            
    
    }


    public function Detail(Request $request)
    {
       
        
        $x = RealisasiUraianTugasTambahan::
                            leftjoin('db_pare_2018.uraian_tugas_tambahan AS uraian_tugas_tambahan', function($join){
                                $join   ->on('uraian_tugas_tambahan.id','=','realisasi_uraian_tugas_tambahan.uraian_tugas_tambahan_id');
                            })
                            ->SELECT(   'realisasi_uraian_tugas_tambahan.id AS realisasi_uraian_tugas_tambahan_id',
                                        'realisasi_uraian_tugas_tambahan.capaian_id AS capaian_id',
                                        'realisasi_uraian_tugas_tambahan.realisasi AS realisasi',
                                        'realisasi_uraian_tugas_tambahan.satuan',
                                        'uraian_tugas_tambahan.id AS uraian_tugas_tambahan_id',
                                        'uraian_tugas_tambahan.label AS uraian_tugas_tambahan_label',
                                        'uraian_tugas_tambahan.target',
                                        'uraian_tugas_tambahan.skp_bulanan_id',
                                        'uraian_tugas_tambahan.tugas_tambahan_id'
                                    ) 
                            ->WHERE('realisasi_uraian_tugas_tambahan.id', $request->realisasi_uraian_tugas_tambahan_id)
                            ->first();

        if ( $x->jabatan_id > 0 ){
            $pelaksana = Pustaka::capital_string($x->Pelaksana->skpd);
        }else{
            $pelaksana = '-';
        }
		
		//return  $rencana_aksi;
        $rencana_aksi = array(
            'id'                            => $x->realisasi_uraian_tugas_tambahan_id,
            'skp_bulanan_id'                => $x->skp_bulanan_id,
            'capaian_id'                    => $x->capaian_id,
            'label'                         => $x->uraian_tugas_tambahan_label,
            'output'                        => $x->target.' '.$x->satuan,
            'target'                        => $x->target,
            'uraian_tugas_tambahan_target'  => $x->target,
            'uraian_tugas_tambahan_id'      => $x->uraian_tugas_tambahan_id,
            'realisasi'                     => $x->realisasi,
            'satuan'                        => $x->satuan
 
        );
        return $rencana_aksi;
    }

    public function Update(Request $request)
    {

        $messages = [
                    'realisasi_uraian_tugas_tambahan_id.required'   => 'Harus diisi',
                    'uraian_tugas_tambahan_id.required'             => 'Harus diisi',
                    'target.required'                               => 'Harus diisi',
                    'realisasi.required'                            => 'Harus diisi',
                    'satuan.required'                               => 'Harus diisi',

        ];

        $validator = Validator::make(
                        Input::all(),
                        array(
                            'realisasi_uraian_tugas_tambahan_id'    => 'required',
                            'uraian_tugas_tambahan_id'              => 'required',
                            'target'                                => 'required',
                            //'realisasi'                             => 'required|numeric|max:'.$request->target,
                            'realisasi'                             => 'required|numeric',
                            'satuan'                                => 'required',
                        ),
                        $messages
        );

        if ( $validator->fails() ){
            //$messages = $validator->messages();
            return response()->json(['errors'=>$validator->messages()],422);
            
        }

       //UPDATE dulu target nya
       $utt            = UraianTugasTambahan::find(Input::get('uraian_tugas_tambahan_id'));
       $utt->target    = $request->target;
       $utt->save();

       if ( $utt->save()){
            $realisasi_utt            = RealisasiUraianTugasTambahan::find(Input::get('realisasi_uraian_tugas_tambahan_id'));
           
            $realisasi_utt->realisasi               = Input::get('realisasi');
            $realisasi_utt->satuan                  = Input::get('satuan');
       

            if ( $realisasi_utt->save()){
                return \Response::make('sukses', 200);
            }else{
                return \Response::make('error', 500);
            } 
        }else{
           return \Response::make('error', 500);
        } 

       
    }
   

    public function Destroy(Request $request)
    {

        $messages = [
                'realisasi_uraian_tugas_tambahan.required'   => 'Harus diisi',
        ];

        $validator = Validator::make(
                        Input::all(),
                        array(
                            'realisasi_uraian_tugas_tambahan'   => 'required',
                        ),
                        $messages
        );

        if ( $validator->fails() ){
            //$messages = $validator->messages();
            return response()->json(['errors'=>$validator->messages()],422);
            
        }

        
        $st_kt    = RealisasiUraianTugasTambahan::find(Input::get('realisasi_uraian_tugas_tambahan'));
        if (is_null($st_kt)) {
            return $this->sendError('Realisasi Uraian Tugas Tambahan tidak ditemukan.');
        }


        if ( $st_kt->delete()){
            return \Response::make('sukses', 200);
        }else{
            return \Response::make('error', 500);
        } 
            
            
    
    } 



}
