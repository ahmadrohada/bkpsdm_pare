<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;

use App\Models\RoleUser;

use Validator;
use Input;

class RoleUserAPIController extends Controller {





    public function AddAdminSKPD(Request $request)
    {
        $user_id = $request->user_id;
        $messages = [
                        'user_id.required'      => 'Harus diisi',
        ];
        $validator = Validator::make(
                        Input::all(),
                        array(
                            'user_id'   => 'required',
                        ),
                        $messages
        );
        if ( $validator->fails() ){
            //$messages = $validator->messages();
            return response()->json(['errors'=>$validator->messages()],422); 
        }
        $ru    = new RoleUser;
        $ru->user_id         = $user_id;
        $ru->role_id         = 2 ;
        if ( $ru->save()){
            return \Response::make('sukses', 200);
        }else{
            return \Response::make('error', 500);
        } 
    }
 
    
    
    public function RemoveAdminSKPD(Request $request)
    {
        $messages = [
                'user_role_id.required'   => 'Harus diisi',
        ];
        $validator = Validator::make(
                        array(
                            'user_role_id'   => 'required',
                        ),
                        $messages
        );
        if ( $validator->fails() ){
            //$messages = $validator->messages();
            return response()->json(['errors'=>$validator->messages()],422);
            
        }
        $ru    = RoleUser::find(Input::get('user_role_id'));
        if (is_null($ru)) {
            return $this->sendError('Role tidak ditemukan.');
        }
        if ( $ru->delete()){
            return \Response::make('sukses', 200);
        }else{
            return \Response::make('error', 500);
        }   
    
    }


    public function AddAdminPuskesmas(Request $request)
    {
        $user_id = $request->user_id;
        $messages = [
                        'user_id.required'      => 'Harus diisi',
        ];
        $validator = Validator::make(
                        Input::all(),
                        array(
                            'user_id'   => 'required',
                        ),
                        $messages
        );
        if ( $validator->fails() ){
            //$messages = $validator->messages();
            return response()->json(['errors'=>$validator->messages()],422); 
        }
        $ru    = new RoleUser;
        $ru->user_id         = $user_id;
        $ru->role_id         = 4 ;
        if ( $ru->save()){
            return \Response::make('sukses', 200);
        }else{
            return \Response::make('error', 500);
        } 
    }
 
    
    
    public function RemoveAdminPuskesmas(Request $request)
    {
        $messages = [
                'user_role_id.required'   => 'Harus diisi',
        ];
        $validator = Validator::make(
                        array(
                            'user_role_id'   => 'required',
                        ),
                        $messages
        );
        if ( $validator->fails() ){
            //$messages = $validator->messages();
            return response()->json(['errors'=>$validator->messages()],422);
            
        }
        $ru    = RoleUser::find(Input::get('user_role_id'));
        if (is_null($ru)) {
            return $this->sendError('Role tidak ditemukan.');
        }
        if ( $ru->delete()){
            return \Response::make('sukses', 200);
        }else{
            return \Response::make('error', 500);
        }   
    
    }
}
