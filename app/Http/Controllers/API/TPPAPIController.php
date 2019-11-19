<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Periode;
use App\Models\PerjanjianKinerja;
use App\Models\SKPTahunan;
use App\Models\SKPBulanan;
use App\Models\CapaianBulanan;
use App\Models\Pegawai;
use App\Models\HistoryJabatan;
use App\Models\Golongan;
use App\Models\Jabatan;
use App\Models\Eselon;

use App\Models\KegiatanSKPTahunan;
use App\Models\RencanaAksi;
use App\Models\KegiatanSKPBulanan;

use App\Helpers\Pustaka;

use Datatables;
use Validator;
use Gravatar;
use Input;
Use Alert;

class TPPAPIController extends Controller {

    //=======================================================================================//
    protected function jabatan($id_jabatan){
        $jabatan       = HistoryJabatan::WHERE('id',$id_jabatan)
                        ->SELECT('jabatan')
                        ->first();
        return Pustaka::capital_string($jabatan->jabatan);
    }

  
   
    public function AdministratorTPPList(Request $request)
    {
            
        $dt = CapaianBulanan::
                    WHERE('status_approve','1')
                   

                    //PEJABAT YANG DINILAI
                    ->leftjoin('demo_asn.tb_history_jabatan AS pejabat', function($join){
                        $join   ->on('capaian_bulanan.u_jabatan_id','=','pejabat.id');
                    })
                   
                   
                    ->select([  'capaian_bulanan.id AS capaian_bulanan_id',
                                'capaian_bulanan.pegawai_id AS pegawai_id',
                                'capaian_bulanan.tgl_mulai',
                                'capaian_bulanan.u_nama',
                                'capaian_bulanan.u_jabatan_id',
                                'capaian_bulanan.p_nama',
                                'capaian_bulanan.p_jabatan_id'

                        ]);
                    

       
                    $datatables = Datatables::of($dt)
                    ->addColumn('status', function ($x) {
                        return $x->status;
                    })->addColumn('periode', function ($x) {
                        return Pustaka::periode($x->tgl_mulai);
                    })->addColumn('nip_pegawai', function ($x) {
                        return $x->u_nip;
                    })->addColumn('nama_pegawai', function ($x) {
                        return $x->u_nama;
                    })
                    ->addColumn('nama_atasan', function ($x) {
                        return $x->p_nama;
                    });
                    if ($keyword = $request->get('search')['value']) {
                        $datatables->filterColumn('rownum', 'whereRaw', '@rownum  + 1 like ?', ["%{$keyword}%"]);
                    } 
                    return $datatables->make(true);
    }

   
}
