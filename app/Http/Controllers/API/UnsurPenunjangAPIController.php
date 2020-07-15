<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;

use App\Models\UnsurPenunjangTugasTambahan;
use App\Models\UnsurPenunjangKreativitas;


use Datatables;
use Validator;
use Input;


class UnsurPenunjangAPIController extends Controller {

    
   
    public function TugasTambahanList(Request $request)
    {
            
        $dt = UnsurPenunjangTugasTambahan::where('capaian_tahunan_id', '=' ,$request->get('capaian_tahunan_id'))
                                ->select([   
                                    'id AS tugas_tambahan_id',
                                    'label AS tugas_tambahan_label',
                                    'approvement'
                                ])
                                ->get();

        //nilai tugas tambahan
        $n_tt = UnsurPenunjangTugasTambahan::WHERE('capaian_tahunan_id', '=' ,$request->get('capaian_tahunan_id'))
                                            ->WHERE('approvement', '=' , '1' )
                                            ->count();

        if ( $n_tt < 1){
            $n_nilai = 0;
        }else if ( $n_tt <= 3 ){
            $n_nilai = 1;
        }else if ( $n_tt <= 6 ){
            $n_nilai = 2;
        }else if ( $n_tt >= 7 ){
            $n_nilai = 3;
        }

        $datatables = Datatables::of($dt)
                    ->addColumn('tugas_tambahan_label', function ($x) {
                        return $x->tugas_tambahan_label;
                    })
                    ->addColumn('action', function ($x) {
                        return $x->tugas_tambahan_id;
                    })
                    ->addColumn('tugas_tambahan_nilai', function ($x) use($n_nilai) {
                        return $n_nilai;
                    });

                    if ($keyword = $request->get('search')['value']) {
                        $datatables->filterColumn('rownum', 'whereRawx', '@rownum  + 1 like ?', ["%{$keyword}%"]);
                    } 
        return $datatables->make(true);
    }

    public function TugasTambahanDetail(Request $request)
    {
       
        
        $x = UnsurPenunjangTugasTambahan::
                SELECT(     'unsur_penunjang_tugas_tambahan.id AS tugas_tambahan_id',
                            'unsur_penunjang_tugas_tambahan.label',
                            'unsur_penunjang_tugas_tambahan.nilai'

                                    ) 
                            ->WHERE('unsur_penunjang_tugas_tambahan.id', $request->tugas_tambahan_id)
                            ->first();

		
        $tugas_tambahan = array(
            'id'            => $x->tugas_tambahan_id,
            'label'         => $x->label

        );
        return $tugas_tambahan;
    }

    public function TugasTambahanStore(Request $request)
    {

        $messages = [
                'capaian_tahunan_id.required'           => 'Harus diisi',
                'label.required'                         => 'Harus diisi',

        ];

        $validator = Validator::make(
                        Input::all(),
                        array(
                            'capaian_tahunan_id'        => 'required',
                            'label'                     => 'required',
                        ),
                        $messages
        );

        if ( $validator->fails() ){
            //$messages = $validator->messages();
            return response()->json(['errors'=>$validator->messages()],422);
            
        }


        $sr    = new UnsurPenunjangTugasTambahan;

        $sr->capaian_tahunan_id        = Input::get('capaian_tahunan_id');
        $sr->label                      = Input::get('label');

        if ( $sr->save()){
            return \Response::make('sukses', 200);
        }else{
            return \Response::make('error', 500);
        } 
            
            
    
    }

    public function TugasTambahanUpdate(Request $request)
    {

        $messages = [
                'unsur_penunjang_tugas_tambahan_id.required'        => 'Harus diisi',
                'label.required'                                    => 'Harus diisi',


        ];

        $validator = Validator::make(
                        Input::all(),
                        array(
                            'unsur_penunjang_tugas_tambahan_id'     => 'required',
                            'label'                                 => 'required',
                            
                        ),
                        $messages
        );

        if ( $validator->fails() ){
            //$messages = $validator->messages();
            return response()->json(['errors'=>$validator->messages()],422);
            
        }

        
        $sr    = UnsurPenunjangTugasTambahan::find(Input::get('unsur_penunjang_tugas_tambahan_id'));
        if (is_null($sr)) {
            return $this->sendError('Tugas Tambahan Tidak ditemukan.');
        }


        $sr->label             = Input::get('label');


        if ( $sr->save()){
            return \Response::make('sukses', 200);
        }else{
            return \Response::make('error', 500);
        } 
            
            

    
    }



    public function TugasTambahanDestroy(Request $request)
    {

        $messages = [
                'tugas_tambahan_id.required'   => 'Harus diisi',
        ];

        $validator = Validator::make(
                        Input::all(),
                        array(
                            'tugas_tambahan_id'   => 'required',
                        ),
                        $messages
        );

        if ( $validator->fails() ){
            //$messages = $validator->messages();
            return response()->json(['errors'=>$validator->messages()],422);
            
        }

        
        $sr    = UnsurPenunjangTugasTambahan::find(Input::get('tugas_tambahan_id'));
        if (is_null($sr)) {
            return $this->sendError('TugasTambahan tidak ditemukan.');
        }


        if ( $sr->delete()){
            return \Response::make('sukses', 200);
        }else{
            return \Response::make('error', 500);
        } 
            
            
    
    }

    public function TugasTambahanApprove(Request $request)
    {
        $messages = [
                'tugas_tambahan_id.required'        => 'Harus diisi',
        ];

        $validator = Validator::make(
                        Input::all(),
                        array(
                            'tugas_tambahan_id'     => 'required',
                        ),
                        $messages
        );

        if ( $validator->fails() ){
            //$messages = $validator->messages();
            return response()->json(['errors'=>$validator->messages()],422);  
        }

        $sr    = UnsurPenunjangTugasTambahan::find(Input::get('tugas_tambahan_id'));
        if (is_null($sr)) {
            return $this->sendError('Tugas Tambahan Tidak ditemukan.');
        }


        $sr->approvement   = '1';

        if ( $sr->save()){
            return \Response::make('sukses', 200);
        }else{
            return \Response::make('error', 500);
        } 
    }
    public function TugasTambahanReject(Request $request)
    {
        $messages = [
                'tugas_tambahan_id.required'        => 'Harus diisi',
        ];

        $validator = Validator::make(
                        Input::all(),
                        array(
                            'tugas_tambahan_id'     => 'required',
                        ),
                        $messages
        );

        if ( $validator->fails() ){
            //$messages = $validator->messages();
            return response()->json(['errors'=>$validator->messages()],422);  
        }

        $sr    = UnsurPenunjangTugasTambahan::find(Input::get('tugas_tambahan_id'));
        if (is_null($sr)) {
            return $this->sendError('Tugas Tambahan Tidak ditemukan.');
        }


        $sr->approvement    = '0';

        if ( $sr->save()){
            return \Response::make('sukses', 200);
        }else{
            return \Response::make('error', 500);
        } 
    }
   

    //========================== K ERE ATIVITAS ==============================================//


    public function KreativitasList(Request $request)
    {
            
        $dt = UnsurPenunjangKreativitas::where('capaian_tahunan_id', '=' ,$request->get('capaian_tahunan_id'))
                                ->select([   
                                    'id AS kreativitas_id',
                                    'label AS kreativitas_label',
                                    'nilai AS kreativitas_nilai',
                                    'manfaat_id',
                                    'approvement'
                                ])
                                ->get();

        $datatables = Datatables::of($dt)
                    ->addColumn('kreativitas_label', function ($x) {
                        return $x->kreativitas_label;
                    })
                    ->addColumn('kreativitas_manfaat', function ($x) {
                        switch ($x->manfaat_id) {
                            case "3":
                              return "Untuk Unit Kerja";
                              break;
                            case "6":
                                return "Untuk Organisasi";
                              break;
                            case "12":
                                return "Untuk Pemerintah";
                              break;
                            default:
                                return "Undefine";
                          }
                    })
                    ->addColumn('action', function ($x) {
                        return $x->kreativitas_id;
                    });

                    if ($keyword = $request->get('search')['value']) {
                        $datatables->filterColumn('rownum', 'whereRawx', '@rownum  + 1 like ?', ["%{$keyword}%"]);
                    } 
        return $datatables->make(true);
    }

    public function KreativitasDetail(Request $request)
    {
       
        
        $x = UnsurPenunjangKreativitas::
                SELECT(     'unsur_penunjang_kreativitas.id AS kreativitas_id',
                            'unsur_penunjang_kreativitas.label',
                            'unsur_penunjang_kreativitas.manfaat_id'

                                    ) 
                            ->WHERE('unsur_penunjang_kreativitas.id', $request->kreativitas_id)
                            ->first();

		
        $kreativitas = array(
            'id'            => $x->kreativitas_id,
            'label'         => $x->label,
            'manfaat_id'    => $x->manfaat_id

        );
        return $kreativitas;
    }

    public function KreativitasStore(Request $request)
    {

        $messages = [
                'capaian_tahunan_id.required'           => 'Harus diisi',
                'label.required'                        => 'Harus diisi',
                'manfaat_id.required'                   => 'Harus diisi',

        ];

        $validator = Validator::make(
                        Input::all(),
                        array(
                            'capaian_tahunan_id'        => 'required',
                            'label'                     => 'required',
                            'manfaat_id'                => 'required',
                        ),
                        $messages
        );

        if ( $validator->fails() ){
            //$messages = $validator->messages();
            return response()->json(['errors'=>$validator->messages()],422);
            
        }


        $sr    = new UnsurPenunjangKreativitas;

        $sr->capaian_tahunan_id         = Input::get('capaian_tahunan_id');
        $sr->label                      = Input::get('label');
        $sr->manfaat_id                 = Input::get('manfaat_id');
        $sr->nilai                      = Input::get('manfaat_id');

        if ( $sr->save()){
            return \Response::make('sukses', 200);
        }else{
            return \Response::make('error', 500);
        } 
            
            
    
    }

    public function KreativitasUpdate(Request $request)
    {

        $messages = [
                'unsur_penunjang_kreativitas_id.required'       => 'Harus diisi',
                'label.required'                                => 'Harus diisi',
                'manfaat_id.required'                            => 'Harus diisi',


        ];

        $validator = Validator::make(
                        Input::all(),
                        array(
                            'unsur_penunjang_kreativitas_id'    => 'required',
                            'label'                             => 'required',
                            'manfaat_id'                        => 'required',
                            
                        ),
                        $messages
        );

        if ( $validator->fails() ){
            //$messages = $validator->messages();
            return response()->json(['errors'=>$validator->messages()],422);
            
        }

        
        $sr    = UnsurPenunjangKreativitas::find(Input::get('unsur_penunjang_kreativitas_id'));
        if (is_null($sr)) {
            return $this->sendError('Kreativitas Tidak ditemukan.');
        }


        $sr->label                = Input::get('label');
        $sr->manfaat_id           = Input::get('manfaat_id');
        $sr->nilai                = Input::get('manfaat_id');


        if ( $sr->save()){
            return \Response::make('sukses', 200);
        }else{
            return \Response::make('error', 500);
        } 
            
            

    
    }



    public function KreativitasDestroy(Request $request)
    {

        $messages = [
                'kreativitas_id.required'   => 'Harus diisi',
        ];

        $validator = Validator::make(
                        Input::all(),
                        array(
                            'kreativitas_id'   => 'required',
                        ),
                        $messages
        );

        if ( $validator->fails() ){
            //$messages = $validator->messages();
            return response()->json(['errors'=>$validator->messages()],422);
            
        }

        
        $sr    = UnsurPenunjangKreativitas::find(Input::get('kreativitas_id'));
        if (is_null($sr)) {
            return $this->sendError('Kreativitas tidak ditemukan.');
        }


        if ( $sr->delete()){
            return \Response::make('sukses', 200);
        }else{
            return \Response::make('error', 500);
        } 
            
            
    
    }

    public function KreativitasApprove(Request $request)
    {

        $messages = [
                'kreativitas_id.required'       => 'Harus diisi',
        ];

        $validator = Validator::make(
                        Input::all(),
                        array(
                            'kreativitas_id'    => 'required',
                        ),
                        $messages
        );

        if ( $validator->fails() ){
            //$messages = $validator->messages();
            return response()->json(['errors'=>$validator->messages()],422);
            
        }

        
        $sr    = UnsurPenunjangKreativitas::find(Input::get('kreativitas_id'));
        if (is_null($sr)) {
            return $this->sendError('Kreativitas Tidak ditemukan.');
        }


        $sr->approvement            = '1';


        if ( $sr->save()){
            return \Response::make('sukses', 200);
        }else{
            return \Response::make('error', 500);
        } 
    }

    public function KreativitasReject(Request $request)
    {

        $messages = [
                'kreativitas_id.required'       => 'Harus diisi',
        ];

        $validator = Validator::make(
                        Input::all(),
                        array(
                            'kreativitas_id'    => 'required',
                        ),
                        $messages
        );

        if ( $validator->fails() ){
            //$messages = $validator->messages();
            return response()->json(['errors'=>$validator->messages()],422);
            
        }

        
        $sr    = UnsurPenunjangKreativitas::find(Input::get('kreativitas_id'));
        if (is_null($sr)) {
            return $this->sendError('Kreativitas Tidak ditemukan.');
        }


        $sr->approvement            = '0';


        if ( $sr->save()){
            return \Response::make('sukses', 200);
        }else{
            return \Response::make('error', 500);
        } 
    }
}
