<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;

use App\Models\Jabatan;
use App\Models\Skpd;

use App\Helpers\Pustaka;

use Datatables;
use Validator;
use Gravatar;
use Input;
Use Alert;

class JabatanAPIController extends Controller {


   
    public function select2_jabatan_list(Request $request)
    {

        /* $tes = '{
            "results": [
              { 
                "text": "Group 1", 
                "children" : [
                  {
                      "id": 1,
                      "text": "Option 1.1"
                  },
                  {
                      "id": 2,
                      "text": "Option 1.2"
                  }
                ]
              },
              { 
                "text": "Group 2", 
                "children" : [
                  {
                      "id": 3,
                      "text": "Option 2.1",
                      "disabled": true
                  },
                  {
                      "id": 4,
                      "text": "Option 2.2"
                  }
                ]
              }
            ],
            "paginate": {
              "more": true
            }
          }'; */



        
        $data       = Skpd::where('parent_id', $request->get('jabatan_id'))
                      ->get();

        $unit_kerja_list = [];
        foreach  ( $data as $x){
           
            //== cari jabatan pada unit kerja ini
            $jabatan_list = [];
            $jabatan  = Jabatan::where('parent_id',$x->id)->get();
            foreach  ( $jabatan as $y){
                $jabatan_list[] = array(
                            'id'		=> $y->id,
                            'text'		=> Pustaka::capital_string($y->skpd),
                );
    
            }
            
            $unit_kerja_list[] = array(
                'text'		=> Pustaka::capital_string($x->bidang->unit_kerja),
                'children'  => $jabatan_list,
             );


        } 
                    
        return $unit_kerja_list;


    }

}
