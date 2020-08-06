<?php

namespace App\Http\Controllers\PARE_API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use App\Models\SKPTahunan;

class CekHistoryJabatanController extends Controller
{
   
    public function HistoryJabatan(Request $request)
    {

        
        $id    = $request->id ? $request->id : 0 ;


        if ( $id != 0 ){
            $data = SKPTahunan::WHERE('u_jabatan_id', $id)->ORWHERE('p_jabatan_id',$id)->count();
        }else{
            $data = 0 ;
        }
        
        
            return response()->json([   
                                        
                                        'in_use'          => $data 
                                    
                                    
                                    
                                    ],200);
    }
}
