<?php

namespace App\Http\Controllers\PARE_API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use App\Models\TPPReport;
use App\Models\TPPReportData;

class TPPReportController extends Controller
{
   
    public function TTPReport(Request $request)
    {

        $now = date('Y'.'-'.'m');

        $skpd_id    = $request->skpd_id ? $request->skpd_id : 42 ;
        $dt_ym      = $request->month ? $request->month : $now ;
        $dt_x       = explode("-", $dt_ym); 
        $dt_y       = $dt_x[0];
        $dt_m       = $dt_x[1];
        $periode    = "Periode ".$dt_y;


        $tpp_report_detail = TPPReport::
                                    rightjoin('db_pare_2018_demo.periode AS periode', function ($join) use($periode) {
                                        $join->on('periode.id', '=', 'tpp_report.periode_id');
                                        $join->WHERE('periode.label', '=', $periode);
                                    })
                                    ->leftjoin('demo_asn.m_skpd AS skpd', function ($join) {
                                        $join->on('skpd.id', '=', 'tpp_report.skpd_id');
                                    }) 
                                    ->WHERE('tpp_report.skpd_id', $skpd_id)
                                    ->WHERE('tpp_report.bulan',$dt_m)
                                    ->select([
                                        'tpp_report.id AS tpp_report_id',
                                        'tpp_report.periode_id',
                                        'tpp_report.bulan',
                                        'skpd.skpd AS nama_skpd'

                                    ])
               
                                    ->first();
        if ( $tpp_report_detail ){
            $tpp_report_data = TPPReportData::
                                            //JABATAN
                                            leftjoin('demo_asn.m_skpd AS jabatan', function ($join) {
                                                $join->on('jabatan.id', '=', 'tpp_report_data.jabatan_id');
                                            }) 
                                            //ESELON
                                            ->leftjoin('demo_asn.m_eselon AS eselon', function ($join) {
                                                $join->on('eselon.id', '=', 'tpp_report_data.eselon_id');
                                            }) 
                                            //UNIT KERJA 
                                            ->leftjoin('demo_asn.m_unit_kerja AS unit_kerja', function ($join) {
                                                $join->on('unit_kerja.id', '=', 'tpp_report_data.unit_kerja_id');
                                            })
                                            //Golongan
                                            ->leftjoin('demo_asn.m_golongan AS golongan', function ($join) {
                                                $join->on('golongan.id', '=', 'tpp_report_data.golongan_id');
                                            })
                                            
                                            ->select([
                                                'tpp_report_data.nama_pegawai AS nama',
                                                'golongan.pangkat AS pangkat',
                                                'golongan.golongan AS golongan',
                                                'jabatan.skpd AS jabatan',
                                                'tpp_report_data.tpp_rupiah AS tpp',
                                                'tpp_report_data.skor_cap AS skor_skp',
                                                'tpp_report_data.skor_kehadiran AS skor_kehadiran'

                                            ])
                                            ->WHERE('tpp_report_data.tpp_report_id', $tpp_report_detail->tpp_report_id)
                                            ->ORDERBY('tpp_report_data.eselon_id','ASC')
                                            ->get()->toArray();
        }else{
            $tpp_report_data = [];
        }   
       


            

            return response()->json([   
                                        'nama_skpd'     => $tpp_report_detail ? $tpp_report_detail->nama_skpd : '',
                                        'skpd_id'       => $skpd_id,
                                        'periode_tpp'   => $dt_ym,
                                        'tpp_report_id' => $tpp_report_detail ? $tpp_report_detail->tpp_report_id : '',
                                        //'Y'             => $dt_y,
                                        //'M'             => $dt_m,
                                        'data'          => $tpp_report_data 
                                    
                                    
                                    
                                    ],200);
    }
}
