<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use App\Helpers\Pustaka;
use GuzzleHttp\Client;

use Validator;
use Input;
class KehadiranAPIController extends Controller { 

  
    public function Kehadiran(Request $request){
        
        $nip     = $request->nip;
        $month   = $request->month;

        $client = new Client([
            // Base URI is used with relative requests
            'base_uri' => 'https://api-siap.silk.bkpsdm.karawangkab.go.id',
        ]);
          
        $response = $client->request('GET', '/absensi/'.$nip.'/monthly-report', [
            'form_params' => [
                'access_token'  => 'MjIzNTZmZjItNTJmOS00NjA1LTk5YWEtOGQwN2VhNmIwNjVm',
                'approvedOnly'  => true
             ],
            'query' =>       [
                            'month'         => $month ,
                        ]
        ]);
         
        //get status code using $response->getStatusCode();
        $body = $response->getBody();
        $arr_body = json_decode($body,true); 

        return  $arr_body['summary']['percentage'];

    }

   
   

}
;