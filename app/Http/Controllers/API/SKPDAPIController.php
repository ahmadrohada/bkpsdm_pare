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
        //\DB::statement(\DB::raw('set @rownum='.$request->get('start')));
        \DB::statement(\DB::raw('set @rownum=0'));
      
        $dt = \DB::table('demo_asn.m_skpd AS skpd')

                ->whereRaw('id = id_skpd AND id != 1 AND id != 6 AND id != 8 AND id != 10 AND id != 12 ')
                ->select([  'skpd.id_skpd AS skpd_id',
                            'skpd.id_unit_kerja AS unit_kerja_id',
                            'skpd.skpd AS skpd',
                            \DB::raw('@rownum  := @rownum  + 1 AS rownum')
                ]);
        



        $datatables = Datatables::of($dt)
        ->addColumn('jm_unit_kerja', function ($x) {
            
            $dx = SKPD::WHERE('parent_id',$x->skpd_id)
                            ->SELECT('id AS parent_id')
                            ->first();

            $jm_uk = SKPD::WHERE('parent_id',$dx->parent_id)
                            ->count();
            



            return  $jm_uk;
        
        })->addColumn('jm_pegawai', function ($x) {
            
         
            $jm_p = HistoryJabatan::WHERE('status','active')
                            ->WHERE('id_skpd',$x->skpd_id)
                            ->count();
            



            return  $jm_p;
        
        })->addColumn('skpd', function ($x) {
            
            return Pustaka::capital_string($x->skpd);
        
        });

        
        if ($keyword = $request->get('search')['value']) {
            $datatables->filterColumn('rownum', 'whereRaw', '@rownum  + 1 like ?', ["%{$keyword}%"]);
        } 

        return $datatables->make(true);
        
    }

    public function administrator_pegawai_skpd_list(Request $request)
    {
        //$id_skpd_admin      = \Auth::user()->pegawai->history_jabatan->where('status','active')->first()->id_skpd;

        $id_skpd = $request->skpd_id ;

        //\DB::statement(\DB::raw('set @rownum='.$request->get('start')));
        \DB::statement(\DB::raw('set @rownum=0'));
      
        $dt = \DB::table('db_pare_2018.users AS user')
        ->rightjoin('demo_asn.tb_pegawai AS pegawai', 'user.id_pegawai', '=', 'pegawai.id')
        //->join('demo_asn.tb_history_jabatan AS a', 'a.id_pegawai','=','pegawai.id')
        ->rightjoin('demo_asn.tb_history_jabatan AS a', function($join){
            $join   ->on('a.id_pegawai','=','pegawai.id');
            //$join   ->where('a.id_skpd','=', $id_skpd);
        })
        ->where('a.id_skpd','=', $id_skpd)
        ->where('a.status', '=', 'active')
        ->join('demo_asn.m_skpd AS jabatan', 'jabatan.id','=','a.id_skpd')
        ->join('demo_asn.m_skpd AS unit_kerja', 'a.id_jabatan','=','unit_kerja.id')
        ->join('demo_asn.m_unit_kerja AS skpd', 'unit_kerja.id_skpd','=','skpd.id')
        ->select([   'pegawai.nama',
                    'user.username AS username',
                    'user.id AS user_id',
                    'pegawai.nip',
                    'pegawai.gelardpn',
                    'pegawai.gelarblk',
                    'a.jabatan',
                    'a.id_jabatan',
                    'unit_kerja.id AS unit_kerja_id',
                    'unit_kerja.skpd AS unit_kerja',
                    'skpd.unit_kerja AS skpd',
                    \DB::raw('@rownum  := @rownum  + 1 AS rownum')
        
                ]);
        



        $datatables = Datatables::of($dt)
        ->addColumn('action', function ($x) {
            return '<a href="user/'.$x->user_id.'/edit" class="btn btn-xs btn-primary" style="margin-top:2px; width:70px;"><i class="fa fa-edit"></i> Edit</a>'
					.' <a href="user/'.$x->user_id.'" class="btn btn-xs btn-primary" style="margin-top:2px; width:70px;"><i class="fa  fa-eye"></i> Lihat</a>';
        })->addColumn('nama_pegawai', function ($x) {
            
            return Pustaka::nama_pegawai($x->gelardpn , $x->nama , $x->gelarblk);
        
        })->addColumn('nama_unit_kerja', function ($x) {
            
            return Pustaka::capital_string($x->unit_kerja);
        
        });

        
        if ($keyword = $request->get('search')['value']) {
            $datatables->filterColumn('rownum', 'whereRaw', '@rownum  + 1 like ?', ["%{$keyword}%"]);
        } 

        return $datatables->make(true);
        
    }

    

   

}
