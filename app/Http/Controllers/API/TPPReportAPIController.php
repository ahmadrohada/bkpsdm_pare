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

        if ( $validator->fails() ){
            //$messages = $validator->messages();
            return response()->json(['errors'=>$validator->messages()],422);
            
        }


        $st_kt    = new TPPReport;

        $st_kt->skpd_id             = Input::get('kegiatan_id');
        $st_kt->periode_tahun       = Input::get('periode_tahun');
        $st_kt->periode_bulan       = Input::get('periode_bulan');

        if ( $st_kt->save()){
            return \Response::make('sukses', 200);
        }else{
            return \Response::make('error', 500);
        } 
            
            
    
    }



}
