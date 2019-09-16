<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Periode;
use App\Models\PerjanjianKinerja;
use App\Models\SKPTahunan;
use App\Models\SKPBulanan;
use App\Models\CapaianBulanan;
use App\Models\CapaianTahunan;
use App\Models\Pegawai;
use App\Models\HistoryJabatan;
use App\Models\Jabatan;
use App\Models\Golongan;
use App\Models\Eselon;

use App\Models\KegiatanSKPTahunan;
use App\Models\RencanaAksi;
use App\Models\RealisasiRencanaAksiKasubid;
use App\Models\RealisasiRencanaAksiKabid;
use App\Models\RealisasiRencanaAksiKaban;
use App\Models\KegiatanSKPBulanan;
use App\Models\RealisasiKegiatanBulanan;

use App\Helpers\Pustaka;

use Datatables;
use Validator;
use Gravatar;
use Input;
Use Alert;

class CapaianTahunanAPIController extends Controller {

    protected function jabatan($id_jabatan){ 
        $jabatan       = HistoryJabatan::WHERE('id',$id_jabatan)
                        ->SELECT('jabatan')
                        ->first();
        if ( $jabatan == null ){
            return $jabatan;
        }else{
            return Pustaka::capital_string($jabatan->jabatan);
        }
        
    }



    public function PersonalCapaianTahunanList(Request $request)
    {
        $skp = SKPTahunan::
                        leftjoin('db_pare_2018.capaian_tahunan', function($join){
                            $join   ->on('capaian_tahunan.skp_tahunan_id','=','skp_tahunan.id');
                        })
                        ->WHERE('skp_tahunan.pegawai_id',$request->pegawai_id)
                        ->select(
                                'skp_tahunan.id AS skp_tahunan_id',
                                'skp_tahunan.renja_id',
                                'skp_tahunan.tgl_mulai',
                                'skp_tahunan.tgl_selesai',
                                'skp_tahunan.u_jabatan_id',
                                'skp_tahunan.status AS skp_tahunan_status',
                                'capaian_tahunan.id AS capaian_id',
                                'capaian_tahunan.status_approve AS capaian_status_approve',
                                'capaian_tahunan.send_to_atasan AS capaian_send_to_atasan'

            
                         )
                       // ->orderBy('bulan','ASC')
                        ->get();

                    
       
           $datatables = Datatables::of($skp)
             ->addColumn('periode', function ($x) {
                return  Pustaka::Tahun($x->tgl_mulai);
                //return $x->Renja->Periode->label;
            }) 
            ->addColumn('pelaksanaan', function ($x) {
                $masa_penilaian = Pustaka::balik($x->tgl_mulai). ' s.d ' . Pustaka::balik($x->tgl_selesai);
                return   $masa_penilaian;
            }) 
            ->addColumn('jabatan', function ($x) {
                if ( $this->jabatan($x->u_jabatan_id) == null ){
                    return "ID Jabatan : ".$x->u_jabatan_id;
                }else{
                    return  $this->jabatan($x->u_jabatan_id);
                }
            })
            ->addColumn('capaian', function ($x) {
                return $x->capaian_id;
             
            })
            ->addColumn('remaining_time', function ($x) {

                $tgl_selesai = strtotime($x->tgl_selesai);
                $now         = time();
                return floor(($tgl_selesai - $now)/ (60*60*24)) * -1;

            
                
            });
    
            if ($keyword = $request->get('search')['value']) {
                $datatables->filterColumn('rownum', 'whereRawx', '@rownum  + 1 like ?', ["%{$keyword}%"]);
            } 
            
    
        return $datatables->make(true);
        
    }
   

}
