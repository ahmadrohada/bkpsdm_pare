<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Support\Facades\Hash;

use App\Models\Pegawai;
use App\Models\SKPTahunan;
use App\Models\Jabatan;
use App\Models\HistoryJabatan;
use App\Models\User;
use App\Models\RoleUSer;
use App\Models\SKPD;

use App\Helpers\Pustaka;


use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Facades;
use Illuminate\Http\Request;

use Datatables;
use Validator;
use Gravatar;
use Input;
Use Alert;

class SKPDAPIController extends Controller {

    public function administrator_skpd_list(Request $request)
    {
        //\DB::statement(\DB::raw('set @rownum='.$request->get('start')));
        \DB::statement(\DB::raw('set @rownum=0'));
      
        $dt = \DB::table('demo_asn.m_skpd AS skpd')

                ->whereRaw('id = id_skpd AND id != 1 AND id != 6 AND id != 8 AND id != 10 AND id != 12 ')
                ->select([  'skpd.id_skpd AS skpd_id',
                    'skpd.skpd AS skpd',
                    \DB::raw('@rownum  := @rownum  + 1 AS rownum')
                ]);
        



        $datatables = Datatables::of($dt)
        ->addColumn('status', function ($x) {
            
            return '1';
        
        })->addColumn('skpd', function ($x) {
            
            return Pustaka::capital_string($x->skpd);
        
        });

        
        if ($keyword = $request->get('search')['value']) {
            $datatables->filterColumn('rownum', 'whereRaw', '@rownum  + 1 like ?', ["%{$keyword}%"]);
        } 

        return $datatables->make(true);
        
    }

    

   

}
