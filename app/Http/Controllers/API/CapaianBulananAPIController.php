<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Periode;
use App\Models\PerjanjianKinerja;
use App\Models\SKPTahunan;
use App\Models\SKPBulanan;
use App\Models\Pegawai;
use App\Models\HistoryJabatan;
use App\Models\Golongan;
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

class CapaianBulananAPIController extends Controller {

  

    public function PersonalCapaianBulananList(Request $request)
    {
        $skp = SKPBulanan::
                        WHERE('pegawai_id',$request->pegawai_id)
                        ->select(
                                'skp_bulanan.id AS skp_bulanan_id',
                                'skp_bulanan.skp_tahunan_id',
                                'skp_bulanan.bulan',
                                'skp_bulanan.tgl_mulai',
                                'skp_bulanan.tgl_selesai',
                                'skp_bulanan.u_jabatan_id',
                                'status'
            
                         )
                       // ->orderBy('bulan','ASC')
                        ->get();

       
           $datatables = Datatables::of($skp)
             ->addColumn('periode', function ($x) {
                return  $x->SKPTahunan->Renja->Periode->label;
            }) 
            ->addColumn('bulan', function ($x) {
                return Pustaka::bulan($x->bulan);
            }) 
            ->addColumn('pelaksanaan', function ($x) {
                $masa_penilaian = Pustaka::balik($x->tgl_mulai). ' s.d ' . Pustaka::balik($x->tgl_selesai);
                return   $masa_penilaian;
            }) 
            ->addColumn('jabatan', function ($x) {
                
                return   Pustaka::capital_string($x->PejabatYangDinilai->Jabatan->skpd);
            })
            ->addColumn('capaian', function ($x) {

                $tgl_selesai = $x->tgl_selesai;

                if ( time() > strtotime($tgl_selesai) ){
                    return "1"; //harus bikin capaian
                }else{
                    return "0"; //belum waktunya bikin capaian
                }
            
            })
            ->addColumn('remaining_time', function ($x) {

                $tgl_selesai = strtotime($x->tgl_selesai);
                $now         = time();
                return "-" . floor(($tgl_selesai - $now)/ (60*60*24));

            
                
            });
    
            if ($keyword = $request->get('search')['value']) {
                $datatables->filterColumn('rownum', 'whereRawx', '@rownum  + 1 like ?', ["%{$keyword}%"]);
            } 
            
    
        return $datatables->make(true);
        
    }



}
