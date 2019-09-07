<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;

use App\Models\Bantuan;
use App\Helpers\Pustaka;

use Datatables;
use Validator;
use Gravatar;
use Input;
Use Alert;

class BantuanAPIController extends Controller {



    
    public function Detail(Request $request)
    {

        $x = Bantuan::
                SELECT(     'id AS bantuan_id',
                            'topic',
                            'information'
                        ) 
                ->WHERE('id', $request->bantuan_id)
                ->first();

            //return  $rencana_aksi;
            $bantuan = array(
                        'id'         => $x->bantuan_id,
                        'topic'      => $x->topic,
                        'information'=> $x->information
            );
            return $bantuan;
    }

       
}
