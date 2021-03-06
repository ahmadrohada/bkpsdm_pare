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
use App\Models\Skpd;

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
       
        $dt = \DB::table('demo_asn.m_skpd AS skpd')

                ->whereRaw('id = id_skpd AND id != 1 AND id != 6 AND id != 8 AND id != 10 AND id != 12 ')
                ->select([  'skpd.id_skpd AS skpd_id',
                            'skpd.skpd AS skpd'
                ])
                ->get();
            
        $data = array();
        foreach( $dt AS $x ){
                    $data[] = array(
                                    'skpd_id'       => $x->skpd_id,
                                    'skpd'          => $x->skpd,
                                    'singkatan'     => Pustaka::singkatan($x->skpd),
                    );
        }
        
        


        $datatables = Datatables::of(collect($data)) 
                    ->addColumn('skpd_id', function ($x) {
                        return $x['skpd_id'];
                    })
                    ->addColumn('skpd', function ($x) {
                        return Pustaka::capital_string($x['skpd']);
                    })
                    ->addColumn('singkatan', function ($x) {
                        return $x['singkatan'];
                    });

        
        if ($keyword = $request->get('search')['value']) {
            $datatables->filterColumn('rownum', 'whereRaw', '@rownum  + 1 like ?', ["%{$keyword}%"]);
        } 

        return $datatables->make(true); 
        
    }

   /*  public function administrator_pegawai_skpd_list(Request $request)
    {
        
        
        
    } */


    public function administrator_unit_kerja_skpd_list(Request $request)
    {
        
        $id_skpd = $request->skpd_id ;

        
        $dt = \DB::table('demo_asn.m_skpd AS skpd')
                ->rightjoin('demo_asn.m_skpd AS a', function($join){
                    $join   ->on('a.parent_id','=','skpd.id');
                    
                })
                ->join('demo_asn.m_unit_kerja AS unit_kerja', function($join){
                    $join   ->on('a.id','=','unit_kerja.id');
                    
                })
                ->WHERE('skpd.parent_id',$id_skpd)
                ->select([  'unit_kerja.id AS unit_kerja_id',
                            'unit_kerja.unit_kerja AS unit_kerja'
                
                        ]);
               
        
        //unit kerja pegawai yaitu history_jabatan(id_unit_kerja)->m_skpd(parent_id)->m_unit_kerja(unit_kerja)


        $datatables = Datatables::of($dt)
        ->addColumn('nama_unit_kerja', function ($x) {
            
            return Pustaka::capital_string($x->unit_kerja);
        
        });

        
        if ($keyword = $request->get('search')['value']) {
            $datatables->filterColumn('rownum', 'whereRaw', '@rownum  + 1 like ?', ["%{$keyword}%"]);
        } 

        return $datatables->make(true);
        
    }

    

   

}
