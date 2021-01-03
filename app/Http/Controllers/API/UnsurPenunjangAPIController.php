<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;

use App\Models\UnsurPenunjangTugasTambahan;
use App\Models\UnsurPenunjangKreativitas;

use App\Traits\TraitCapaianTahunan;

use Datatables;
use Validator;
use Input;


class UnsurPenunjangAPIController extends Controller {
    
    
    use TraitCapaianTahunan;
    
   
    public function TugasTambahanList(Request $request)
    {
            
        $data       = $this->UnsurPenunjangTugasTambahan($request->capaian_tahunan_id);
 
        $datatables = Datatables::of(collect($data));
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
            
        
        $data       = $this->UnsurPenunjangKreativitas($request->capaian_tahunan_id);

        $datatables = Datatables::of(collect($data));

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
