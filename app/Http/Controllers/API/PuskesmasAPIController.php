<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;

use App\Models\HistoryJabatan;
use App\Models\Skpd;

use App\Helpers\Pustaka;
use Illuminate\Http\Request;

use Datatables;
class PuskesmasAPIController extends Controller {



    public function AdministratorPuskesmasList(Request $request)
    {
       $dt = Skpd::
                leftjoin('demo_asn.m_unit_kerja AS unit_kerja', function($join){
                    $join   ->on('unit_kerja.id','=','m_skpd.id');
                })
                ->WHERE('m_skpd.parent_id',168)
                ->select([  
                    'm_skpd.id AS puskesmas_id',
                    'unit_kerja.unit_kerja AS nama_puskesmas',
                    'unit_kerja.id AS unit_kerja_id'
                ])
                ->get();
        

        $datatables = Datatables::of($dt)
        ->addColumn('jm_pegawai', function ($x) {
            $jm_p = HistoryJabatan::WHERE('status','active')
                            ->WHERE('id_unit_kerja',$x->puskesmas_id)
                            ->count();
            return $jm_p;
        })->addColumn('nama_puskesmas', function ($x) {

            if ( $x->unit_kerja_id == null ){
                return "ID Puskesmas :".$x->puskesmas_id;
            }else{
                return Pustaka::capital_string($x->nama_puskesmas);
            }
            
        });

        if ($keyword = $request->get('search')['value']) {
            $datatables->filterColumn('rownum', 'whereRaw', '@rownum  + 1 like ?', ["%{$keyword}%"]);
        } 

        return $datatables->make(true);
        
    }

  


}
