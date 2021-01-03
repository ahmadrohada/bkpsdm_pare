<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\TugasTambahan;
use App\Models\RealisasiTugasTambahan;
use App\Models\SKPTahunan;
use App\Models\SKPBulanan;

use App\Helpers\Pustaka;
use App\Traits\HitungCapaian;
use App\Traits\BawahanList;
use App\Traits\TraitCapaianTahunan;

use Datatables;
use Validator;
use Input;

class RealisasiTugasTambahanAPIController extends Controller {
    use HitungCapaian;
    use BawahanList;
    use TraitCapaianTahunan;
    
    

    

    public function RealisasiTugasTambahanList(Request $request)
    {
        
            
        $dt = $this->TugasTambahan($request->skp_tahunan_id);

        $datatables = Datatables::of(collect($dt));

        if ($keyword = $request->get('search')['value']) {
        $datatables->filterColumn('rownum', 'whereRawx', '@rownum  + 1 like ?', ["%{$keyword}%"]);
        } 
        return $datatables->make(true);
        
    } 

    


    public function Store(Request $request)
    {

        $messages = [
                'tugas_tambahan_id.required' => 'Harus diisi',
                'capaian_bulanan_id.required'       => 'Harus diisi',
                'target.required'                   => 'Harus diisi',
                'realisasi.required'                => 'Harus diisi',
                'satuan.required'                   => 'Harus diisi',
        ];

        $validator = Validator::make(
                        Input::all(),
                        array(
                            'tugas_tambahan_id'  => 'required',
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
        $utt            = TugasTambahan::find(Input::get('tugas_tambahan_id'));
        $utt->target    = $request->target;
        $utt->save();

        if ( $utt->save()){
            $realisasi_utt    = new RealisasiTugasTambahan;

            $realisasi_utt->tugas_tambahan_id= Input::get('tugas_tambahan_id');
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
       
        
        $x = RealisasiTugasTambahan::
                            leftjoin('db_pare_2018.skp_tahunan_tugas_tambahan AS tugas_tambahan', function($join){
                                $join   ->on('tugas_tambahan.id','=','realisasi_tugas_tambahan.tugas_tambahan_id');
                            })
                            ->SELECT(   'realisasi_tugas_tambahan.id AS realisasi_tugas_tambahan_id',
                                        'realisasi_tugas_tambahan.capaian_id AS capaian_id',
                                        'realisasi_tugas_tambahan.realisasi AS realisasi',
                                        'realisasi_tugas_tambahan.satuan',
                                        'tugas_tambahan.id AS tugas_tambahan_id',
                                        'tugas_tambahan.label AS tugas_tambahan_label',
                                        'tugas_tambahan.target',
                                        'tugas_tambahan.skp_tahunan_id'
                                    ) 
                            ->WHERE('realisasi_tugas_tambahan.id', $request->realisasi_tugas_tambahan_id)
                            ->first();

        if ( $x->jabatan_id > 0 ){
            $pelaksana = Pustaka::capital_string($x->Pelaksana->skpd);
        }else{
            $pelaksana = '-';
        }
		
		//return  $rencana_aksi;
        $rencana_aksi = array(
            'id'                            => $x->realisasi_tugas_tambahan_id,
            'skp_bulanan_id'                => $x->skp_bulanan_id,
            'capaian_id'                    => $x->capaian_id,
            'label'                         => $x->tugas_tambahan_label,
            'output'                        => $x->target.' '.$x->satuan,
            'target'                        => $x->target,
            'tugas_tambahan_target'         => $x->target,
            'tugas_tambahan_id'             => $x->tugas_tambahan_id,
            'realisasi'                     => $x->realisasi,
            'satuan'                        => $x->satuan
 
        );
        return $rencana_aksi;
    }

    public function Update(Request $request)
    {

        $messages = [
                    'realisasi_tugas_tambahan_id.required'   => 'Harus diisi',
                    'tugas_tambahan_id.required'             => 'Harus diisi',
                    'target.required'                               => 'Harus diisi',
                    'realisasi.required'                            => 'Harus diisi',
                    'satuan.required'                               => 'Harus diisi',

        ];

        $validator = Validator::make(
                        Input::all(),
                        array(
                            'realisasi_tugas_tambahan_id'    => 'required',
                            'tugas_tambahan_id'              => 'required',
                            'target'                                => 'required',
                            //'realisasi'                             => 'required|numeric|max:'.$request->target,
                            'realisasi'                         => 'required|numeric',
                            'satuan'                                => 'required',
                        ),
                        $messages
        );

        if ( $validator->fails() ){
            //$messages = $validator->messages();
            return response()->json(['errors'=>$validator->messages()],422);
            
        }

       //UPDATE dulu target nya
       $utt            = TugasTambahan::find(Input::get('tugas_tambahan_id'));
       $utt->target    = $request->target;
       $utt->save();

       if ( $utt->save()){
            $realisasi_utt            = RealisasiTugasTambahan::find(Input::get('realisasi_tugas_tambahan_id'));
           
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
                'realisasi_tugas_tambahan.required'   => 'Harus diisi',
        ];

        $validator = Validator::make(
                        Input::all(),
                        array(
                            'realisasi_tugas_tambahan'   => 'required',
                        ),
                        $messages
        );

        if ( $validator->fails() ){
            //$messages = $validator->messages();
            return response()->json(['errors'=>$validator->messages()],422);
            
        }

        
        $st_kt    = RealisasiTugasTambahan::find(Input::get('realisasi_tugas_tambahan'));
        if (is_null($st_kt)) {
            return $this->sendError('Realisasi  Tugas Tambahan tidak ditemukan.');
        }


        if ( $st_kt->delete()){
            return \Response::make('sukses', 200);
        }else{
            return \Response::make('error', 500);
        } 
            
            
    
    } 



}
