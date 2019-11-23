<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Periode;
use App\Models\SKPD;
use App\Models\SKPTahunan;
use App\Models\SKPBulanan;
use App\Models\CapaianBulanan;
use App\Models\Pegawai;
use App\Models\HistoryJabatan;
use App\Models\TPPReport;
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
use Alert;

class TPPReportAPIController extends Controller
{




    public function SKPDTTPReportList(Request $request)
    {



        $tpp_report = TPPReport::WHERE('skpd_id', $request->skpd_id)
           /*  ->join('db_pare_2018.skp_tahunan_rencana_aksi AS rencana_aksi', function ($join) {
                $join->on('rencana_aksi.indikator_kegiatan_id', '=', 'renja_indikator_kegiatan.id');
            }) */
            ->select([
                'tpp_report.id AS tpp_report_id',
                'tpp_report.periode_id',
                'tpp_report.bulan',
                'tpp_report.skpd_id',
                'tpp_report.status',
                'tpp_report.created_at'

            ])
           /*  ->orderBy('rencana_aksi.waktu_pelaksanaan', 'ASC')
            ->orderBy('rencana_aksi.id', 'DESC') */
            ->get();

        $datatables = Datatables::of($tpp_report)
            ->addColumn('waktu_pelaksanaan', function ($x) {
                if ($x->waktu_pelaksanaan != 0) {
                    return Pustaka::bulan($x->waktu_pelaksanaan);
                } else {
                    return "-";
                }
            });

        if ($keyword = $request->get('search')['value']) {
            $datatables->filterColumn('rownum', 'whereRawx', '@rownum  + 1 like ?', ["%{$keyword}%"]);
        }

        return $datatables->make(true);
    }


    public function Store(Request $request)
    {

        $messages = [
            'skpd_id.required'           => 'Harus diisi',
            'periode_tahun.required'     => 'Harus diisi',
            'periode_bulan.required'     => 'Harus diisi',

        ];

        $validator = Validator::make(
            Input::all(),
            array(
                'skpd_id'           => 'required',
                'periode_tahun'     => 'required|numeric',
                'periode_bulan'     => 'required|numeric',
            ),
            $messages
        );

        if ($validator->fails()) {
            //$messages = $validator->messages();
            return response()->json(['errors' => $validator->messages()], 422);
        }


        $st_kt    = new TPPReport;

        $st_kt->skpd_id             = Input::get('kegiatan_id');
        $st_kt->periode_tahun       = Input::get('periode_tahun');
        $st_kt->periode_bulan       = Input::get('periode_bulan');

        if ($st_kt->save()) {
            return \Response::make('sukses', 200);
        } else {
            return \Response::make('error', 500);
        }
    }
}
